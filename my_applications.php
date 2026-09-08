<?php
require_once 'config.php';
requireLogin();

$result = supabaseRequest(
    'applications?user_id=eq.' . rawurlencode($_SESSION['user_id'])
    . '&order=created_at.desc',
    'GET'
);
$applications = ($result['code'] === 200 && !empty($result['data'])) ? $result['data'] : [];

// Manually fetch opportunity titles
foreach ($applications as &$app) {
    if (!empty($app['opportunity_id'])) {
        $oppResult = supabaseRequest('opportunities?id=eq.' . intval($app['opportunity_id']) . '&select=id,title,is_paid,rate,rate_type,sector,location,time_commitment', 'GET');
        $app['opportunities'] = ($oppResult['code'] === 200 && !empty($oppResult['data'])) ? $oppResult['data'][0] : null;
    }
}
unset($app);

// Stats
$totalApps      = count($applications);
$pendingCount   = count(array_filter($applications, fn($a) => ($a['status'] ?? '') === 'pending'));
$approvedCount  = count(array_filter($applications, fn($a) => ($a['status'] ?? '') === 'approved'));
$rejectedCount  = count(array_filter($applications, fn($a) => in_array($a['status'] ?? '', ['rejected','declined'])));
$withdrawnCount = count(array_filter($applications, fn($a) => ($a['status'] ?? '') === 'withdrawn'));

// Notifications 
$toasts = [];
foreach ($applications as $app) {
    $appId  = $app['id'];
    $status = $app['status'] ?? '';
    $title  = $app['opportunities']['title'] ?? 'an opportunity';
    if (in_array($status, ['approved', 'rejected', 'declined'])) {
        $toasts[] = ['id' => $appId, 'status' => $status, 'title' => $title];
    }
}

$pageTitle   = 'My Applications';
$currentPage = 'my_applications';
include 'partials/head.php';
include 'partials/header.php';
?>

<style>
.app-controls {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.app-controls-left { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.app-filter-tabs { display: flex; gap: 6px; flex-wrap: wrap; }
.filter-tab {
    padding: 6px 16px;
    border-radius: 20px;
    border: 1.5px solid var(--border);
    background: #fff;
    font-size: 13px;
    font-weight: 600;
    color: var(--ink-muted);
    cursor: pointer;
    transition: all .18s;
    white-space: nowrap;
}
.filter-tab.active, .filter-tab:hover { background: var(--blue-600); color: #fff; border-color: var(--blue-600); }
.app-controls-right { display: flex; align-items: center; gap: 10px; }
.app-count-label { font-size: 13px; color: var(--ink-muted); font-weight: 500; white-space: nowrap; }
.sort-select {
    padding: 6px 12px;
    border-radius: 10px;
    border: 1.5px solid var(--border);
    background: #fff;
    font-size: 13px;
    font-weight: 600;
    color: var(--ink-muted);
    cursor: pointer;
    outline: none;
    transition: border-color .18s;
}
.sort-select:focus { border-color: var(--blue-400); }

.app-cards { display: flex; flex-direction: column; gap: 16px; }
.app-card {
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: 18px;
    padding: 24px 28px;
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 20px;
    align-items: start;
    transition: box-shadow .2s, border-color .2s, transform .2s;
    position: relative;
    overflow: hidden;
}
.app-card::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 4px;
    border-radius: 18px 0 0 18px;
    background: var(--card-accent, var(--blue-400));
}
.app-card:hover { box-shadow: 0 8px 32px rgba(37,99,235,.10); border-color: var(--blue-200); transform: translateY(-2px); }
.app-card[data-status="pending"]   { --card-accent: #f59e0b; }
.app-card[data-status="approved"]  { --card-accent: #22c55e; }
.app-card[data-status="rejected"],
.app-card[data-status="declined"]  { --card-accent: #ef4444; }
.app-card[data-status="withdrawn"] { --card-accent: #94a3b8; }

.app-card-title { font-size: 16px; font-weight: 800; color: var(--ink); margin-bottom: 14px; line-height: 1.35; }
.app-card-meta { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; margin-top: 8px; }
.app-card-meta .pill { padding: 7px 16px; }

.app-stepper {
   display: flex;
    align-items: flex-start;
    margin: 4px 0 8px;
}
.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    flex: 1;
    position: relative;
}
.step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 11px;
    left: 50%;
    width: 100%;
    height: 2px;
    background: var(--border);
    z-index: 0;
    transition: background .3s;
}
.step.done:not(:last-child)::after  { background: #22c55e; }
.step.active:not(:last-child)::after { background: var(--border); }
.step-dot {
    width: 22px; height: 22px;
    border-radius: 50%;
    border: 2px solid var(--border);
    background: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 9px;
    color: var(--ink-faint);
    position: relative; z-index: 1;
    transition: all .2s;
    flex-shrink: 0;
    line-height: 1;
}
.step-dot i {
    display: block;
    line-height: 1;
    margin: 0;
    padding: 0;
    width: auto;
    height: auto;
    text-align: center;
}
.step.done .step-dot     { background: #22c55e; border-color: #22c55e; color: #fff; font-size: 10px; }
.step.active .step-dot   { background: #f59e0b; border-color: #f59e0b; color: #fff; box-shadow: 0 0 0 4px rgba(245,158,11,.18); font-size: 6px; }
.step.approved .step-dot { background: #22c55e; border-color: #22c55e; color: #fff; box-shadow: 0 0 0 4px rgba(34,197,94,.18); font-size: 10px; }
.step.rejected .step-dot { background: #ef4444; border-color: #ef4444; color: #fff; box-shadow: 0 0 0 4px rgba(239,68,68,.18); font-size: 10px; }
.step-label { font-size: 10px; font-weight: 700; color: var(--ink-faint); text-align: center; white-space: nowrap; letter-spacing: .02em; }
.step.done .step-label     { color: #16a34a; }
.step.active .step-label   { color: #92400e; }
.step.approved .step-label { color: #22c55e; }
.step.rejected .step-label { color: #ab3333; }

.app-timeline {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 18px;
    padding-top: 14px;
    border-top: 1px solid var(--border);
    font-size: 12px;
    color: var(--ink-faint);
    font-weight: 500;
    flex-wrap: wrap;
}
.app-timeline i { color: var(--blue-300); font-size: 11px; }
.app-timeline strong { color: var(--ink-muted); }
.app-card-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 12px;
    min-width: 140px;
}

.status-pill {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 12px; font-weight: 700; padding: 5px 14px;
    border-radius: 20px; white-space: nowrap; border: 1.5px solid transparent;
}
.status-pill::before {
    content: ''; width: 7px; height: 7px; border-radius: 50%;
    background: currentColor; opacity: .7; flex-shrink: 0;
}
.status-pending   { background:#fef3c7; color:#92400e; border-color:#fcd34d; }
.status-approved  { background:#f0fdf4; color:#14532d; border-color:#86efac; }
.status-rejected,
.status-declined  { background:#fee2e2; color:#7f1d1d; border-color:#fca5a5; }
.status-withdrawn { background:#f8fafc; color:#64748b; border-color:#e2e8f0; }

.type-pill {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 700; padding: 5px 14px;
    border-radius: 20px; border: 1.5px solid transparent;
}
.type-paid { background:#f0fdf4; color:#15803d; border-color:#bbf7d0; }
.type-vol  { background:#fdf2f8; color:#db2777; border-color:#f9a8d4; }

.app-actions { display: flex; gap: 8px; flex-wrap: wrap; justify-content: flex-end; margin-top: 4px; }

.next-steps {
    margin-top: 14px; background: #f0fdf4;
    border: 1.5px solid #86efac; border-radius: 10px; padding: 14px 16px;
}
.next-steps-title {
    font-size: 12px; font-weight: 800; text-transform: uppercase;
    letter-spacing: .06em; color: #15803d; margin-bottom: 10px;
    display: flex; align-items: center; gap: 6px;
}
.next-steps-list { display: flex; flex-direction: column; gap: 6px; }
.next-step-item {
    display: flex; align-items: center; gap: 9px;
    font-size: 12.5px; color: #166534; font-weight: 500;
}
.next-step-item i { width: 18px; text-align: center; color: #16a34a; font-size: 12px; flex-shrink: 0; }

.empty-app {
    text-align: center; padding: 80px 20px; background: #fff;
    border: 2px dashed var(--border); border-radius: 20px;
}
.empty-app-icon {
    width: 80px; height: 80px; border-radius: 50%; background: var(--blue-50);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px; font-size: 32px; color: var(--blue-400);
}
.empty-app h3 { font-size: 20px; font-weight: 800; margin-bottom: 10px; }
.empty-app p  { color: var(--ink-muted); margin-bottom: 24px; font-size: 15px; }

.empty-filter {
    display: none; text-align: center; padding: 60px 20px; background: #fff;
    border: 2px dashed var(--border); border-radius: 20px;
}
.empty-filter.visible { display: block; }
.empty-filter i  { font-size: 36px; color: var(--blue-200); margin-bottom: 14px; display: block; }
.empty-filter h4 { font-size: 16px; font-weight: 800; margin-bottom: 6px; }
.empty-filter p  { font-size: 13px; color: var(--ink-muted); }

#toast-stack {
    position: fixed; bottom: 28px; right: 24px; z-index: 9999;
    display: flex; flex-direction: column-reverse; gap: 12px; pointer-events: none;
}
.toast {
    pointer-events: all; display: flex; align-items: flex-start; gap: 14px;
    min-width: 320px; max-width: 400px; padding: 16px 18px 14px;
    border-radius: 14px; box-shadow: 0 8px 30px rgba(0,0,0,.14);
    background: #fff; border-left: 5px solid transparent;
    animation: toastIn .38s cubic-bezier(.22,1,.36,1) both;
    transition: opacity .28s ease, transform .28s ease;
    position: relative; overflow: hidden;
}
.toast.removing { opacity:0; transform: translateX(120%); pointer-events:none; }
.toast-approved { border-color: #22c55e; }
.toast-rejected, .toast-declined { border-color: #ef4444; }
.toast-icon { flex-shrink:0; width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:17px; }
.toast-approved .toast-icon { background:#f0fdf4; color:#16a34a; }
.toast-rejected .toast-icon, .toast-declined .toast-icon { background:#fee2e2; color:#dc2626; }
.toast-body { flex:1; min-width:0; }
.toast-label { font-size:11px; font-weight:800; letter-spacing:.06em; text-transform:uppercase; margin-bottom:3px; }
.toast-approved .toast-label { color:#16a34a; }
.toast-rejected .toast-label, .toast-declined .toast-label { color:#dc2626; }
.toast-msg { font-size:13.5px; font-weight:600; color:#1e293b; line-height:1.4; word-break:break-word; }
.toast-sub { font-size:12px; color:#64748b; margin-top:2px; }
.toast-dismiss-row { display:flex; align-items:center; gap:7px; margin-top:10px; padding-top:9px; border-top:1px solid #f1f5f9; cursor:pointer; }
.toast-dismiss-row input { width:15px; height:15px; accent-color:#2563eb; cursor:pointer; flex-shrink:0; }
.toast-dismiss-row label { font-size:12px; color:#64748b; cursor:pointer; font-weight:500; }
.toast.dismissed { opacity:.45; pointer-events:none; }
.toast-close { flex-shrink:0; background:none; border:none; font-size:18px; color:#94a3b8; cursor:pointer; padding:0; margin-top:-2px; transition:color .15s; }
.toast-close:hover { color:#475569; }
.toast-progress { position:absolute; bottom:0; left:0; height:3px; border-radius:0 0 0 9px; animation: toastProgress 7s linear forwards; }
.toast-approved .toast-progress { background:#22c55e; }
.toast-rejected .toast-progress, .toast-declined .toast-progress { background:#ef4444; }

@keyframes toastIn   { from{opacity:0;transform:translateX(60px) scale(.94)} to{opacity:1;transform:translateX(0) scale(1)} }
@keyframes slideUp   { from{opacity:0;transform:translateY(30px) scale(.97)} to{opacity:1;transform:translateY(0) scale(1)} }
@keyframes toastProgress { from{width:100%} to{width:0%} }

@media (max-width: 640px) {
    .app-card { grid-template-columns: 1fr; padding: 18px; }
    .app-card-right { align-items: flex-start; flex-direction: row; flex-wrap: wrap; min-width: 0; }
    .app-actions { justify-content: flex-start; }
    .app-stepper { display: none; }
    #toast-stack { right: 12px; bottom: 16px; }
    .toast { min-width: 0; width: calc(100vw - 24px); }
    .app-controls { flex-direction: column; align-items: flex-start; }
    .app-controls-right { width: 100%; justify-content: space-between; }
}
</style>

<!-- TOAST STACK -->
<div id="toast-stack"></div>

<div class="page-band">
    <div class="container">
        <div class="breadcrumb"><a href="index.php">Home</a><i class="fas fa-chevron-right"></i> My Applications</div>
        <h1><i class="fas fa-clipboard-list" style="color:var(--orange-400);margin-right:10px"></i>My Applications</h1>
        <p>Track the status of your volunteer applications in real time.</p>
    </div>
</div>

<section class="section">
    <div class="container">

        <?php if (empty($applications)): ?>
            <div class="empty-app">
                <div class="empty-app-icon"><i class="fas fa-clipboard-list"></i></div>
                <h3>No Applications Yet</h3>
                <p>You haven't applied to any opportunities yet.<br>Start exploring and make your first move!</p>
                <a href="opportunity.php" class="btn btn-primary btn-lg">
                    <i class="fas fa-magnifying-glass"></i> Browse Opportunities
                </a>
            </div>

        <?php else: ?>


            <!-- Filter Tabs + Sort -->
            <div class="app-controls">
                <div class="app-controls-left">
                    <div class="app-filter-tabs">
                        <button class="filter-tab active" data-filter="all">All <span style="opacity:.6;font-weight:500">(<?= $totalApps ?>)</span></button>
                        <?php if ($pendingCount):   ?><button class="filter-tab" data-filter="pending">Pending (<?= $pendingCount ?>)</button><?php endif; ?>
                        <?php if ($approvedCount):  ?><button class="filter-tab" data-filter="approved">Approved (<?= $approvedCount ?>)</button><?php endif; ?>
                        <?php if ($rejectedCount):  ?><button class="filter-tab" data-filter="declined">Not Selected (<?= $rejectedCount ?>)</button><?php endif; ?>
                        <?php if ($withdrawnCount): ?><button class="filter-tab" data-filter="withdrawn">Withdrawn (<?= $withdrawnCount ?>)</button><?php endif; ?>
                    </div>
                </div>
                <div class="app-controls-right">
                    <select class="sort-select" id="sortSelect" aria-label="Sort applications">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                    </select>
                    <span class="app-count-label" id="visibleCount">Showing <?= $totalApps ?> application<?= $totalApps !== 1 ? 's' : '' ?></span>
                </div>
            </div>

            <!-- Cards -->
            <div class="app-cards" id="appCards">
                <?php foreach ($applications as $app):
                    $opp        = $app['opportunities'] ?? null;
                    $status     = $app['status'] ?? 'pending';
                    $isPaid     = $opp['is_paid'] ?? false;
                    $statusNorm = in_array($status, ['rejected','declined']) ? 'declined' : $status;
                    $statusLabel = match($status) {
                        'pending'            => 'Pending Review',
                        'approved'           => 'Approved',
                        'rejected','declined'=> 'Not Selected',
                        'withdrawn'          => 'Withdrawn',
                        default              => ucfirst($status),
                    };

                    // Stepper states
                    $stepStates = match($statusNorm) {
                        'pending'   => ['done',     'active',   'pending'],
                        'approved'  => ['done',     'done',     'approved'],
                        'declined'  => ['done',     'done',     'rejected'],
                        'withdrawn' => ['done',     'done',     'rejected'],
                        default     => ['done',     'active',   'pending'],
                    };
                    $stepDefs = [
                        ['label' => 'Submitted',    'icon_active' => 'fa-check',     'icon_pending' => 'fa-paper-plane'],
                        ['label' => 'Under Review', 'icon_active' => 'fa-check',     'icon_pending' => 'fa-magnifying-glass'],
                        ['label' => 'Decision',     'icon_active' => 'fa-check',     'icon_pending' => 'fa-gavel'],
                    ];

                    $oppTitle = $opp['title'] ?? 'N/A';
                    $tz       = new DateTimeZone('Asia/Kuala_Lumpur');
                    $appDateTime    = new DateTime($app['created_at'], $tz);
                    $now            = new DateTime('now', $tz);
                    $todayStart     = new DateTime('today', $tz);
                    $yesterdayStart = new DateTime('yesterday', $tz);
                    $diff           = $now->diff($appDateTime);
                    $appDate        = $appDateTime->format('d M Y');

                    if ($appDateTime >= $todayStart) {
                        $diffStr = 'Today';
                    } elseif ($appDateTime >= $yesterdayStart) {
                        $diffStr = 'Yesterday';
                    } elseif ($diff->days < 30) {
                        $diffStr = $diff->days . ' days ago';
                    } elseif ($diff->days < 365) {
                        $months  = round($diff->days / 30);
                        $diffStr = $months . ' month' . ($months > 1 ? 's' : '') . ' ago';
                    } else {
                        $years   = round($diff->days / 365);
                        $diffStr = $years . ' year' . ($years > 1 ? 's' : '') . ' ago';
                    }
                ?>
                <div class="app-card"
                     data-status="<?= htmlspecialchars($statusNorm) ?>"
                     data-date="<?= strtotime($app['created_at']) ?>">

                    <div class="app-card-left">
                        <div class="app-card-title"><?= htmlspecialchars($oppTitle) ?></div>

                        <div class="app-card-meta">
                            <?php if ($isPaid): ?>
                                <span class="type-pill type-paid"><i class="fas fa-circle-dollar-to-slot"></i>
                                    Paid<?php if (!empty($opp['rate'])): ?> · RM<?= number_format($opp['rate'],2) ?>/<?= htmlspecialchars($opp['rate_type'] ?? '') ?><?php endif; ?>
                                </span>
                            <?php else: ?>
                                <span class="type-pill type-vol"><i class="fas fa-heart"></i> Volunteer</span>
                            <?php endif; ?>
                            <?php if (!empty($opp['sector'])): ?>
                                <span class="pill"><i class="fas fa-tag"></i><?= htmlspecialchars($opp['sector']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($opp['location'])): ?>
                                <span class="pill"><i class="fas fa-location-dot"></i><?= htmlspecialchars($opp['location']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($opp['time_commitment'])): ?>
                                <span class="pill"><i class="fas fa-clock"></i><?= htmlspecialchars($opp['time_commitment']) ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- Progress Stepper -->
                        <div class="app-stepper">
                            <?php foreach ($stepDefs as $i => $step):
                                $state = $stepStates[$i];
                                $icon  = match($state) {
                                    'done'     => 'fa-check',
                                    'active'   => 'fa-circle',
                                    'approved' => 'fa-check',
                                    'rejected' => 'fa-xmark',
                                    default    => 'fa-circle',
                                };
                            ?>
                            <div class="step <?= $state ?>">
                                <div class="step-dot"><i class="fas <?= $icon ?>"></i></div>
                                <div class="step-label"><?= $step['label'] ?></div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if ($status === 'approved'): ?>
                        <div class="next-steps">
                            <div class="next-steps-title"><i class="fas fa-circle-check"></i> What happens next?</div>
                            <div class="next-steps-list">
                                <div class="next-step-item"><i class="fas fa-envelope"></i> Check your inbox — the organiser will reach out via email.</div>
                                <div class="next-step-item"><i class="fas fa-calendar-check"></i> Confirm your availability and onboarding schedule.</div>
                                <div class="next-step-item"><i class="fas fa-id-badge"></i> Prepare any required documents or identification.</div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (in_array($status, ['rejected','declined'])): ?>
                        <div style="margin-top:13px;font-size:12.5px;color:#7f1d1d;display:flex;align-items:center;gap:8px;background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;padding:10px 12px;">
                            <i class="fas fa-circle-xmark" style="color:#dc2626;flex-shrink:0;font-size:14px;"></i>
                            <span>Your application wasn't selected this time — but your effort matters. Browse new openings and apply again.</span>
                        </div>
                        <?php endif; ?>

                        <div class="app-timeline">
                            <i class="fas fa-calendar-check"></i>
                            Applied on <strong><?= $appDate ?></strong>
                            &nbsp;·&nbsp;
                            <i class="fas fa-clock"></i> <?= $diffStr ?>
                        </div>
                    </div>

                    <div class="app-card-right">
                        <span class="status-pill status-<?= htmlspecialchars($statusNorm) ?>"><?= $statusLabel ?></span>
                        <div class="app-actions">
                            <?php if ($opp): ?>
                            <a href="opportunity_details.php?id=<?= htmlspecialchars($app['opportunity_id']) ?>" class="btn btn-primary btn-sm">
                                View <i class="fas fa-arrow-right"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Empty filtered state -->
            <div class="empty-filter" id="emptyFilter">
                <i class="fas fa-filter-circle-xmark"></i>
                <h4>No applications here</h4>
                <p>You don't have any applications with this status yet.</p>
            </div>

        <?php endif; ?>
    </div>
</section>

<script>
/* Filter tabs */
const tabs        = document.querySelectorAll('.filter-tab');
const cardContainer = document.getElementById('appCards');
const countLabel  = document.getElementById('visibleCount');
const emptyFilter = document.getElementById('emptyFilter');
let currentFilter = 'all';

function applyFilter(filter) {
    currentFilter = filter;
    let visible = 0;
    [...document.querySelectorAll('.app-card')].forEach(card => {
        const show = filter === 'all' || card.dataset.status === filter;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    countLabel.textContent = `Showing ${visible} application${visible !== 1 ? 's' : ''}`;
    if (emptyFilter) emptyFilter.classList.toggle('visible', visible === 0);
}

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        applyFilter(tab.dataset.filter);
    });
});

/* Sort */
document.getElementById('sortSelect')?.addEventListener('change', function () {
    const cards = [...document.querySelectorAll('.app-card')];
    cards.sort((a, b) => {
        const da = parseInt(a.dataset.date), db = parseInt(b.dataset.date);
        return this.value === 'newest' ? db - da : da - db;
    }).forEach(c => cardContainer.appendChild(c));
    applyFilter(currentFilter);
});

/* Toast System */
const TOASTS = <?= json_encode($toasts, JSON_HEX_TAG | JSON_HEX_AMP) ?>;
const STORAGE_KEY = 'volunet_dismissed_notifications';
const stack = document.getElementById('toast-stack');

function getDismissed() { try { return JSON.parse(localStorage.getItem(STORAGE_KEY)||'[]'); } catch { return []; } }
function markDismissed(id) { const l=getDismissed(); if(!l.includes(id)){l.push(id);localStorage.setItem(STORAGE_KEY,JSON.stringify(l));} }
function isDismissed(id)   { return getDismissed().includes(id); }
function removeToast(el)   { el.classList.add('removing'); setTimeout(()=>el.remove(), 300); }

function createToast({id, status, title}) {
    if (isDismissed(id)) return;
    const isApproved = status === 'approved';
    const label = isApproved ? 'Application Approved 🎉' : 'Application Declined';
    const msg   = isApproved ? `You've been approved for <strong>${title}</strong>!` : `Your application for <strong>${title}</strong> was not selected this time.`;
    const sub   = isApproved ? 'Congratulations — check your email for next steps.' : "Don't give up — keep exploring more opportunities!";
    const icon  = isApproved ? 'fa-circle-check' : 'fa-circle-xmark';
    const cbId  = 'dismiss-cb-' + id;
    const toast = document.createElement('div');
    toast.className = `toast toast-${status}`;
    toast.setAttribute('data-id', id);
    toast.innerHTML = `
        <div class="toast-icon"><i class="fas ${icon}"></i></div>
        <div class="toast-body">
            <div class="toast-label">${label}</div>
            <div class="toast-msg">${msg}</div>
            <div class="toast-sub">${sub}</div>
            <div class="toast-dismiss-row"> 
                <input type="checkbox" id="${cbId}">
                <label for="${cbId}">Don't show this again</label>
            </div>
        </div>
        <button class="toast-close" aria-label="Dismiss">×</button>
        <div class="toast-progress"></div>`;
    toast.querySelector(`#${cbId}`).addEventListener('change', function() {
        if (this.checked) { markDismissed(id); toast.classList.add('dismissed'); setTimeout(()=>removeToast(toast), 800); }
    });
    toast.querySelector('.toast-close').addEventListener('click', () => removeToast(toast));
    setTimeout(() => removeToast(toast), 7000);
    stack.appendChild(toast);
}

document.addEventListener('DOMContentLoaded', () => {
    TOASTS.forEach((t, i) => setTimeout(() => createToast(t), i * 500));
});
</script>

<?php include 'partials/footer.php'; ?>
<style>
@media(max-width:480px){
  .app-filter-tabs{gap:4px}
  .filter-tab{padding:5px 12px;font-size:12px}
  .app-card{padding:16px 14px}
  .app-card-title{font-size:14.5px}
  .app-card-meta .pill{font-size:11px;padding:4px 10px}
  .sort-select{font-size:12px;padding:5px 9px}
  .app-count-label{font-size:12px}
}
</style>
