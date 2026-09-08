<?php
require_once 'config.php';

$error   = '';
$success = '';

// Validate ID (opportunities.id is int8)
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (empty($id)) {
    redirect('opportunity.php');
}

// Handle apply POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'apply') {
    requireLogin();
    csrfVerify();

    $opportunity_id = intval($_POST['opportunity_id'] ?? 0);
    $cover_letter   = clean($_POST['cover_letter']    ?? '');

    if (empty($cover_letter)) {
        $error = 'Please write a cover letter before submitting.';
    } else {
        // Check for duplicate application
        $check = supabaseRequest(
            'applications?opportunity_id=eq.' . $opportunity_id
            . '&user_id=eq.' . rawurlencode($_SESSION['user_id'])
            . '&select=id',
            'GET'
        );

        if ($check['code'] === 200 && !empty($check['data'])) {
            $error = 'You have already applied for this opportunity.';
        } else {
            $appData = [
                'opportunity_id' => $opportunity_id,
                'user_id'        => $_SESSION['user_id'],
                'cover_letter'   => $cover_letter,
                'status'         => 'pending',
            ];
            $result = supabaseRequest('applications', 'POST', $appData);

            if (in_array($result['code'], [200, 201])) {
                $success = 'Application submitted successfully! We will be in touch.';
            } else {
                $error = 'Failed to submit application. Error: HTTP ' . $result['code'] . ' — ' . json_encode($result['data']);
                error_log('Apply error: HTTP ' . $result['code'] . ' ' . json_encode($result['data']));
            }
        }
    }
}

// Fetch opportunity
$result      = supabaseRequest('opportunities?id=eq.' . rawurlencode($id), 'GET');
$opportunity = ($result['code'] === 200 && !empty($result['data'])) ? $result['data'][0] : null;

if (!$opportunity) {
    redirect('opportunity.php');
}

// Image map
$imageMap = [
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
$detailImg = $imageMap[$opportunity['title']] ?? oppImage(0);

$pageTitle   = htmlspecialchars($opportunity['title']);
$currentPage = 'opportunities';
include 'partials/head.php';
include 'partials/header.php';
?>

<div class="page-band">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Home</a><i class="fas fa-chevron-right"></i>
            <a href="opportunity.php">Opportunities</a><i class="fas fa-chevron-right"></i>
            Detail
        </div>
        <h1><?= htmlspecialchars($opportunity['title']) ?></h1>
    </div>
</div>

<section class="section">
    <div class="container">

        <?php if ($error): ?>
            <div class="alert alert-error" style="max-width:820px;margin:0 auto 24px">
                <i class="fas fa-circle-exclamation"></i><?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success" style="max-width:820px;margin:0 auto 24px">
                <i class="fas fa-circle-check"></i><?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="detail-wrap">
            <div class="detail-card">

                <div class="detail-img-wrap">
                    <img src="<?= htmlspecialchars($detailImg) ?>"
                         alt="<?= htmlspecialchars($opportunity['title']) ?>"
                         class="detail-hero-img">
                    <div class="detail-img-overlay"></div>
                </div>

                <div class="detail-body">
                    <h1 class="detail-title"><?= htmlspecialchars($opportunity['title']) ?></h1>

                    <div class="detail-meta">
                        <?php if ($opportunity['is_paid']): ?>
                            <span class="pill" style="background:var(--green-50);color:var(--green-700);border:1px solid var(--green-100)">
                                <i class="fas fa-circle-dollar-to-slot"></i>
                                RM<?= number_format($opportunity['rate'], 2) ?>/<?= $opportunity['rate_type'] === 'per_task' ? 'per-task' : htmlspecialchars($opportunity['rate_type']) ?>
                            </span>
                        <?php else: ?>
                            <span class="pill" style="background:#fdf2f8;color:#db2777;border:1px solid #f9a8d4">
                                <i class="fas fa-heart"></i>Volunteer
                            </span>
                        <?php endif; ?>
                        <span class="pill"><i class="fas fa-tag"></i><?= htmlspecialchars($opportunity['sector']) ?></span>
                        <span class="pill"><i class="fas fa-location-dot"></i><?= htmlspecialchars($opportunity['location']) ?></span>
                        <span class="pill"><i class="fas fa-clock"></i><?= htmlspecialchars($opportunity['time_commitment']) ?></span>
                    </div>

                    <div class="detail-sec">
                        <h3><i class="fas fa-circle-info"></i> About This Opportunity</h3>
                        <p><?= nl2br(htmlspecialchars($opportunity['description'])) ?></p>
                    </div>

                    <?php
                    $skills = is_array($opportunity['required_skills'] ?? null)
                        ? $opportunity['required_skills']
                        : (is_string($opportunity['required_skills'] ?? null)
                            ? json_decode($opportunity['required_skills'], true)
                            : []);
                    if (!empty($skills)):
                    ?>
                    <div class="detail-sec">
                        <h3><i class="fas fa-screwdriver-wrench"></i> Required Skills</h3>
                        <div class="skills-wrap">
                            <?php foreach ($skills as $skill): ?>
                                <span class="skill-chip"><?= htmlspecialchars($skill) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="divider"></div>

                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <button onclick="openModal('applyModal')" class="btn btn-primary btn-lg"
                                style="width:100%;justify-content:center">
                            <i class="fas fa-paper-plane"></i> Apply Now
                        </button>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-dark btn-lg" style="width:100%;justify-content:center">
                            <i class="fas fa-right-to-bracket"></i> Login to Apply
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>
</section>

<!-- Apply Modal -->
<div class="modal-overlay" id="applyModal">
    <div class="modal-box">
        <div class="modal-head">
            <h2><i class="fas fa-paper-plane" style="margin-right:8px"></i>Apply for This Role</h2>
            <p>Tell us why you're the perfect fit for this opportunity</p>
            <button class="modal-close" onclick="closeModal('applyModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="opportunity_details.php?id=<?= htmlspecialchars($id) ?>" class="js-form">
                <?= csrfField() ?>
                <input type="hidden" name="action" value="apply">
                <input type="hidden" name="opportunity_id" value="<?= intval($opportunity['id']) ?>">
                <div class="form-group">
                    <label><i class="fas fa-pen-to-square" style="color:var(--blue-400)"></i> Cover Letter <span class="req">*</span></label>
                    <textarea name="cover_letter" rows="6"
                              placeholder="Share your relevant experience, skills, and passion for this opportunity..."
                              required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center">
                    <i class="fas fa-paper-plane"></i> Submit Application
                </button>
            </form>
        </div>
    </div>
</div>

<style>
@media(max-width:480px){
  .detail-hero-img{height:200px !important}
  .modal-overlay{padding:10px}
  .modal-box{max-height:92vh;overflow-y:auto}
}
</style>
<?php include 'partials/footer.php'; ?>