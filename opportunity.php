<?php
require_once 'config.php';

// Shared image map (title → local file)
function oppImageByTitle(string $title, int $index): string {
    $map = [
        'Web Developer for NGO Website'              => 'png_vd/Web_Developer_for_NGO_Website.png',
        'English Tutor for Underprivileged Kids'     => 'png_vd/English_Tutor_for_Underprivileged_Kids.png',
        'Social Media Content Creator'               => 'png_vd/Social_Media_Content_Creator.png',
        'Community Garden Coordinator'               => 'png_vd/Community_Garden_Coordinator.png',
        'Animal Shelter Care Assistant'              => 'png_vd/Animal_Shelter_Care_Assistant.png',
        'Flood Relief Logistics Coordinator'         => 'png_vd/Flood_Relief_Logistics_Coordinator.png',
        'Youth Leadership Programme Facilitator'     => 'png_vd/Youth_Leadership_Programme_Facilitator.png',
        'Community Mural Artist'                     => 'png_vd/Community_Mural_Artist.png',
        'Legal Literacy Workshop Trainer'            => 'png_vd/Legal_Literacy_Workshop_Trainer.png',
        'Food Bank Sorting & Distribution Volunteer' => 'png_vd/Food_Bank_Sorting_and_Distribution_Volunteer.png',
        'Adaptive Sports Coach'                      => 'png_vd/Adaptive_Sports_Coach.png',
        'Refugee Family Support Worker'              => 'png_vd/Refugee_Family_Support_Worker.png',
    ];
    return $map[$title] ?? oppImage($index);
}

// Build filter query
$filter = 'status=eq.active';

if (!empty($_GET['sector']))   $filter .= '&sector=ilike.*'   . rawurlencode($_GET['sector'])   . '*';
if (!empty($_GET['location'])) $filter .= '&location=ilike.*' . rawurlencode($_GET['location']) . '*';

if (isset($_GET['is_paid']) && $_GET['is_paid'] !== '') {
    $filter .= '&is_paid=eq.' . ($_GET['is_paid'] === 'true' ? 'true' : 'false');
}

if (!empty($_GET['search'])) {
    $s = rawurlencode($_GET['search']);
    $filter .= '&or=(title.ilike.*' . $s . '*,description.ilike.*' . $s . '*)';
}

$result        = supabaseRequest('opportunities?' . $filter . '&order=created_at.desc', 'GET');
$opportunities = ($result['code'] === 200 && !empty($result['data'])) ? $result['data'] : [];

// Sector dropdown options
$allOppsResult = supabaseRequest('opportunities?status=eq.active&select=sector&order=sector.asc', 'GET');
$allSectors    = [];
if ($allOppsResult['code'] === 200 && !empty($allOppsResult['data'])) {
    foreach ($allOppsResult['data'] as $row) {
        $sec = trim($row['sector'] ?? '');
        if ($sec && !in_array($sec, $allSectors)) {
            $allSectors[] = $sec;
        }
    }
    sort($allSectors);
}

$pageTitle   = 'Opportunities';
$currentPage = 'opportunities';
include 'partials/head.php';
include 'partials/header.php';
?>

<div class="page-band">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Home</a><i class="fas fa-chevron-right"></i> Opportunities
        </div>
        <h1><i class="fas fa-magnifying-glass" style="color:var(--orange-400);margin-right:10px"></i>Volunteer Opportunities</h1>
        <p>Browse verified positions across Malaysia &mdash; find your perfect match.</p>
    </div>
</div>

<section class="section">
    <div class="container">

        <!-- Filter Bar -->
        <div class="filter-bar">
            <form method="GET" action="opportunity.php">
                <div class="form-group">
                    <label><i class="fas fa-magnifying-glass" style="color:var(--blue-400)"></i> Keyword</label>
                    <input type="text" name="search" placeholder="e.g. design, youth, coding"
                           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-tag" style="color:var(--blue-400)"></i> Sector</label>
                    <select name="sector">
                        <option value="">All Sectors</option>
                        <?php foreach ($allSectors as $sec): ?>
                            <option value="<?= htmlspecialchars($sec) ?>"
                                <?= (($_GET['sector'] ?? '') === $sec) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($sec) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-location-dot" style="color:var(--blue-400)"></i> Location</label>
                    <input type="text" name="location" placeholder="e.g. Kuala Lumpur, Penang"
                           value="<?= htmlspecialchars($_GET['location'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-filter" style="color:var(--blue-400)"></i> Type</label>
                    <select name="is_paid">
                        <option value="">All Types</option>
                        <option value="true"  <?= (($_GET['is_paid'] ?? '') === 'true')  ? 'selected' : '' ?>>Paid Positions</option>
                        <option value="false" <?= (($_GET['is_paid'] ?? '') === 'false') ? 'selected' : '' ?>>Volunteer</option>
                    </select>
                </div>
                <div class="filter-btns">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-magnifying-glass"></i> Search</button>
                    <a href="opportunity.php" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>

        <!-- Results count -->
        <?php if (!empty($opportunities)): ?>
        <div style="margin-bottom:20px;font-size:14px;color:var(--ink-muted)">
            Showing <strong><?= count($opportunities) ?></strong>
            opportunit<?= count($opportunities) === 1 ? 'y' : 'ies' ?>
            <?php if (!empty($_GET['sector']) || !empty($_GET['location']) || !empty($_GET['is_paid']) || !empty($_GET['search'])): ?>
                &mdash; <a href="opportunity.php" style="color:var(--blue-600)">Clear all filters</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if (empty($opportunities)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-magnifying-glass"></i></div>
                <h3>No Opportunities Found</h3>
                <p>Try adjusting your search filters or check back later for new listings.</p>
                <a href="opportunity.php" class="btn btn-primary">Clear Filters</a>
            </div>
        <?php else: ?>
            <div class="opp-grid">
                <?php foreach ($opportunities as $k => $opp): ?>
                <div class="opp-card">
                    <div class="opp-card-img">
                        <img src="<?= htmlspecialchars(oppImageByTitle($opp['title'], $k)) ?>"
                             alt="<?= htmlspecialchars($opp['title']) ?>" loading="lazy">
                        <span class="opp-badge <?= $opp['is_paid'] ? 'badge-paid' : 'badge-unpaid' ?>">
                            <i class="fas <?= $opp['is_paid'] ? 'fa-circle-dollar-to-slot' : 'fa-heart' ?>"></i>
                            <?= $opp['is_paid'] ? 'Paid' : 'Volunteer' ?>
                        </span>
                    </div>
                    <div class="opp-card-body">
                        <span class="opp-sector"><?= htmlspecialchars($opp['sector']) ?></span>
                        <h3 class="opp-title"><?= htmlspecialchars($opp['title']) ?></h3>
                        <p class="opp-desc"><?= htmlspecialchars($opp['description']) ?></p>
                        <div class="opp-meta">
                            <span class="opp-meta-i"><i class="fas fa-location-dot"></i><?= htmlspecialchars($opp['location']) ?></span>
                            <span class="opp-meta-i"><i class="fas fa-clock"></i><?= htmlspecialchars($opp['time_commitment']) ?></span>
                        </div>
                        <?php if ($opp['is_paid']): ?>
                        <div class="opp-rate">
                            <i class="fas fa-circle-dollar-to-slot"></i>RM<?= number_format($opp['rate'], 2) ?>/<?= $opp['rate_type'] === 'per_task' ? 'per-task' : htmlspecialchars($opp['rate_type']) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="opp-card-footer">
                        <a href="opportunity_details.php?id=<?= $opp['id'] ?>" class="btn btn-primary">
                            View Details <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php include 'partials/footer.php'; ?>