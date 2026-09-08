<?php
require_once 'config.php';

// Fetch all resources ordered by type then title
$result    = supabaseRequest('resources?order=resource_type.asc,title.asc', 'GET');
$resources = ($result['code'] === 200 && !empty($result['data'])) ? $result['data'] : [];

// Group resources by type for organised display
$grouped = [];
foreach ($resources as $r) {
    $type = $r['resource_type'] ?? 'other';
    $grouped[$type][] = $r;
}
// Preferred display order for types
$typeOrder = ['course', 'tutorial', 'certificate'];

// badge class, icon, label
function resourceMeta(string $type): array {
    return match($type) {
        'course'      => ['rb-course',   'fa-book-open',    'Course'],
        'tutorial'    => ['rb-tutorial', 'fa-play-circle',  'Tutorial'],
        'certificate' => ['rb-cert',     'fa-certificate',  'Certificate'],
        default       => ['rb-cert',     'fa-file-lines',   ucfirst($type)],
    };
}

$pageTitle   = 'Resources';
$currentPage = 'resources';
include 'partials/head.php';
include 'partials/header.php';
?>

<div class="page-band">
    <div class="container">
        <div class="breadcrumb"><a href="index.php">Home</a><i class="fas fa-chevron-right"></i> Resources</div>
        <h1><i class="fas fa-book-open" style="color:var(--orange-400);margin-right:10px"></i>Skill Development Resources</h1>
        <p>Unlock your potential with curated courses, tutorials, and certifications — all free.</p>
    </div>
</div>

<section class="section">
    <div class="container">

        <?php if (empty($resources)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-book-open"></i></div>
                <h3>Resources Coming Soon</h3>
                <p>We're curating amazing learning materials for the VoluNet community. Check back very soon!</p>
                <a href="opportunity.php" class="btn btn-primary"><i class="fas fa-magnifying-glass"></i> Browse Opportunities</a>
            </div>

        <?php else: ?>

            <!-- Summary strip -->
            <div class="admin-stats res-summary-strip" style="margin-bottom:40px">
                <div class="admin-stat">
                    <div class="admin-stat-icon fi-blue"><i class="fas fa-layer-group"></i></div>
                    <div>
                        <div class="admin-stat-num"><?= count($resources) ?></div>
                        <div class="admin-stat-lbl">Total Resources</div>
                    </div>
                </div>
                <div class="admin-stat">
                    <div class="admin-stat-icon fi-orange"><i class="fas fa-book-open"></i></div>
                    <div>
                        <div class="admin-stat-num"><?= count($grouped['course'] ?? []) ?></div>
                        <div class="admin-stat-lbl">Courses</div>
                    </div>
                </div>
                <div class="admin-stat">
                    <div class="admin-stat-icon" style="background:#fdf2f8;color:#db2777"><i class="fas fa-play-circle"></i></div>
                    <div>
                        <div class="admin-stat-num"><?= count($grouped['tutorial'] ?? []) ?></div>
                        <div class="admin-stat-lbl">Tutorials</div>
                    </div>
                </div>
                <div class="admin-stat">
                    <div class="admin-stat-icon" style="background:var(--green-50);color:var(--green-600)"><i class="fas fa-certificate"></i></div>
                    <div>
                        <div class="admin-stat-num"><?= count($grouped['certificate'] ?? []) ?></div>
                        <div class="admin-stat-lbl">Certifications</div>
                    </div>
                </div>
            </div>

            <?php
            // Display grouped by type in preferred order, then any remaining types
            $displayOrder = array_merge($typeOrder, array_diff(array_keys($grouped), $typeOrder));

            foreach ($displayOrder as $type):
                if (empty($grouped[$type])) continue;
                [$badgeClass, $icon, $label] = resourceMeta($type);
                $sectionIcon = match($type) {
                    'course'      => 'fa-book-open',
                    'tutorial'    => 'fa-play-circle',
                    'certificate' => 'fa-certificate',
                    default       => 'fa-file-lines',
                };
                $sectionColour = match($type) {
                    'course'      => 'var(--blue-600)',
                    'tutorial'    => '#db2777',
                    'certificate' => 'var(--green-600)',
                    default       => 'var(--ink)',
                };
            ?>

            <!-- Section heading -->
            <div class="res-section-head" style="display:flex;align-items:center;gap:12px;margin:40px 0 24px;flex-wrap:wrap">
                <div style="width:40px;height:40px;border-radius:10px;background:var(--blue-50);display:flex;align-items:center;justify-content:center;color:<?= $sectionColour ?>;font-size:18px;flex-shrink:0">
                    <i class="fas <?= $sectionIcon ?>"></i>
                </div>
                <h2 style="font-size:1.35rem;font-weight:800;margin:0;color:var(--ink)">
                    <?= htmlspecialchars($label) ?>s
                    <span style="font-size:0.95rem;font-weight:600;color:var(--ink-muted);margin-left:8px">(<?= count($grouped[$type]) ?>)</span>
                </h2>
                <div style="flex:1;height:1px;background:var(--border);margin-left:8px"></div>
            </div>

            <div class="res-grid">
                <?php foreach ($grouped[$type] as $r): ?>
                <div class="res-card" data-reveal>
                    <span class="res-badge <?= $badgeClass ?>">
                        <i class="fas <?= $icon ?>"></i><?= htmlspecialchars($label) ?>
                    </span>
                    <h3><?= htmlspecialchars($r['title']) ?></h3>
                    <p><?= htmlspecialchars($r['description']) ?></p>
                    <a href="<?= htmlspecialchars($r['url']) ?>" target="_blank" rel="noopener noreferrer"
                       class="btn btn-primary" style="width:100%;justify-content:center">
                        Access Resource <i class="fas fa-external-link"></i>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>

            <?php endforeach; ?>

        <?php endif; ?>
    </div>
</section>

<style>
.res-summary-strip{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:16px;
}

@media(max-width:768px){
    .res-summary-strip{
        grid-template-columns:repeat(2,1fr) !important;
        max-width:520px;
        margin-left:auto !important;
        margin-right:auto !important;
    }
}

.res-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:22px;
}

@media(max-width:1100px){
    .res-grid{grid-template-columns:repeat(2,1fr)}
}

@media(max-width:768px){
    .res-grid{grid-template-columns:1fr}
}

@media(max-width:480px){
    .res-grid{
        grid-template-columns:1fr;
    }
    .res-summary-strip{
        grid-template-columns:repeat(2,1fr) !important;
        max-width:100% !important;
        gap:12px;
    }
    .admin-stat{
        padding:16px 14px;
        gap:10px;
    }
    .admin-stat-icon{
        width:40px;
        height:40px;
        font-size:16px;
        flex-shrink:0;
    }
    .admin-stat-num{
        font-size:22px;
    }
    .admin-stat-lbl{
        font-size:11px;
    }
}

@media(max-width:640px){
    .res-section-head>div:last-of-type{display:none}
    .res-section-head{margin:28px 0 18px}
}

@media(max-width:640px){
    .res-card{padding:20px 18px}
    .res-card h3{font-size:14.5px}
    .res-badge{font-size:11px;padding:3px 10px}
}

@media(max-width:480px){
    .page-band h1{font-size:clamp(18px,5vw,26px)}
    .page-band p{font-size:13.5px}
}
</style>
<?php include 'partials/footer.php'; ?>