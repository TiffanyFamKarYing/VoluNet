<?php
require_once 'config.php';
requireLogin();

$error   = '';
$success = '';

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfVerify(); // CSRF check belongs inside the POST block

    $full_name     = clean($_POST['full_name']     ?? '');
    $phone         = clean($_POST['phone']         ?? '');
    $location      = clean($_POST['location']      ?? '');
    $bio           = clean($_POST['bio']           ?? '');
    $skills        = array_values(array_filter(array_map('trim', explode(',', $_POST['skills'] ?? ''))));
    $date_of_birth = $_POST['date_of_birth'] ?? '';

    if (empty($full_name)) {
        $error = 'Full name is required.';
    } else {
        $dob_value = null;

        if (!empty($date_of_birth)) {
            $dob_parsed = DateTime::createFromFormat('Y-m-d', $date_of_birth);
            if ($dob_parsed && $dob_parsed->format('Y-m-d') === $date_of_birth) {
                $now       = new DateTime();
                $age_years = $now->diff($dob_parsed)->y;
                if ($dob_parsed >= $now) {
                    $error = 'Date of birth must be in the past.';
                } elseif ($age_years < 10) {
                    $error = 'Please enter a valid date of birth.';
                } else {
                    $dob_value = $date_of_birth;
                }
            } else {
                $error = 'Invalid date of birth format.';
            }
        }

        if (empty($error)) {
            $update = [
                'full_name'     => $full_name,
                'phone'         => $phone,
                'location'      => $location,
                'bio'           => $bio,
                'skills'        => $skills,
                'date_of_birth' => $dob_value,
            ];
            $result = supabaseRequest('users?id=eq.' . rawurlencode($_SESSION['user_id']), 'PATCH', $update);

            if (in_array($result['code'], [200, 204])) {
                $_SESSION['user_name'] = $full_name;
                $success = 'Profile updated successfully!';
            } else {
                $error = 'Failed to update profile. Please try again.';
                error_log('Profile update error: HTTP ' . $result['code'] . ' ' . json_encode($result['data']));
            }
        }
    }
}

// Fetch user data
$result      = supabaseRequest('users?id=eq.' . rawurlencode($_SESSION['user_id']), 'GET');
$userProfile = ($result['code'] === 200 && !empty($result['data'])) ? $result['data'][0] : null;

// Fetch application stats
$appResult    = supabaseRequest('applications?user_id=eq.' . rawurlencode($_SESSION['user_id']) . '&order=created_at.desc', 'GET');
$applications = ($appResult['code'] === 200 && !empty($appResult['data'])) ? $appResult['data'] : [];

$totalApps    = count($applications);
$pendingApps  = count(array_filter($applications, fn($a) => $a['status'] === 'pending'));
$approvedApps = count(array_filter($applications, fn($a) => $a['status'] === 'approved'));
$rejectedApps = count(array_filter($applications, fn($a) => in_array($a['status'], ['rejected', 'declined'])));

// Profile completion
$completionSteps = [
    'Name'     => !empty($userProfile['full_name']),
    'Email'    => !empty($userProfile['email']),
    'Phone'    => !empty($userProfile['phone']),
    'Location' => !empty($userProfile['location']),
    'Birthday' => !empty($userProfile['date_of_birth']),
    'Skills'   => !empty($userProfile['skills']),
    'Bio'      => !empty($userProfile['bio']),
];
$completedCount = count(array_filter($completionSteps));
$completionPct  = (int) round(($completedCount / count($completionSteps)) * 100);
$completionLabel = match(true) {
    $completionPct === 100 => 'Complete ✓',
    $completionPct >= 66   => 'Almost There',
    $completionPct >= 33   => 'Getting Started',
    default                => 'Just Started',
};
$completionColor = match(true) {
    $completionPct === 100 => '#16a34a',
    $completionPct >= 66   => '#2563eb',
    $completionPct >= 33   => '#f97316',
    default                => '#ef4444',
};

$pageTitle   = 'My Profile';
$currentPage = 'profile';
include 'partials/head.php';
include 'partials/header.php';
?>

<style>
.progress-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 16px;
    padding: 24px 28px;
    margin-bottom: 40px;
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
}
.progress-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
    flex-wrap: wrap;
    gap: 8px;
}
.progress-title {
    font-weight: 700;
    font-size: 15px;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 8px;
}
.progress-badge {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 12px;
    border-radius: 20px;
    color: #fff;
}
.progress-track {
    background: #f1f5f9;
    border-radius: 99px;
    height: 11px;
    overflow: hidden;
    margin-bottom: 14px;
}
.progress-fill {
    height: 100%;
    border-radius: 99px;
    width: 0;
    transition: width 1.1s cubic-bezier(.4,0,.2,1);
}
.progress-steps { display: flex; flex-wrap: wrap; gap: 8px; }
.progress-step {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: #6b7280;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 4px 11px;
    border-radius: 8px;
}
.progress-step.done { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
.progress-step i { font-size: 10px; }

.profile-stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 20px;
}
@media (max-width: 600px) { .profile-stats-row { grid-template-columns: repeat(2, 1fr); } }

.profile-stat-card {
    background: #fff;
    border: 1.5px solid #e5e7eb;
    border-radius: 14px;
    padding: 18px 14px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,.03);
    transition: transform .2s, box-shadow .2s;
}
.profile-stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.08); }
.ps-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    font-size: 15px;
}
.ps-num { font-size: 24px; font-weight: 800; color: #111827; line-height: 1; margin-bottom: 4px; }
.ps-lbl { font-size: 11px; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; }

.skills-preview { display: flex; flex-wrap: wrap; gap: 7px; margin-top: 10px; }
.skill-preview-chip {
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #dbeafe;
    border-radius: 20px;
    padding: 4px 12px;
    font-size: 12px;
    font-weight: 600;
}

.profile-header {
    background: linear-gradient(135deg, #0a0f1e 0%, #0d2260 40%, #1a4fa8 70%, #5b9bd5 100%) !important;
}

.profile-avatar-wrap { position: relative; flex-shrink: 0; width: 76px; height: 76px; }
.profile-avatar {
    width: 76px;
    height: 76px;
    border-radius: 50%;
    background: rgba(255,255,255,.14);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-display);
    font-size: 30px;
    font-weight: 700;
    color: #fff;
    border: 3px solid rgba(255,255,255,.22);
    overflow: hidden;
    position: relative;
}
.profile-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 50%; }
.avatar-overlay {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background: rgba(0,0,0,.45);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 18px;
    cursor: pointer;
    opacity: 0;
    transition: opacity .2s;
}
.profile-avatar-wrap:hover .avatar-overlay { opacity: 1; }
.btn-avatar-action {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all .2s;
}
.btn-avatar-upload { background: rgba(255,255,255,.18); color: #fff; border: 1px solid rgba(255,255,255,.3); }
.btn-avatar-upload:hover { background: rgba(255,255,255,.28); }
.btn-avatar-remove { background: rgba(239,68,68,.2); color: #fca5a5; border: 1px solid rgba(239,68,68,.3); }
.btn-avatar-remove:hover { background: rgba(239,68,68,.35); }
</style>

<div class="page-band">
    <div class="container">
        <div class="breadcrumb"><a href="index.php">Home</a><i class="fas fa-chevron-right"></i> My Profile</div>
        <h1><i class="fas fa-user" style="color:var(--orange-400);margin-right:10px"></i>My Profile</h1>
        <p>Manage your volunteer profile and track your impact.</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="form-wrap" style="max-width:680px;width:100%">

            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-avatar-wrap">
                    <div class="profile-avatar" id="avatarCircle">
                        <img id="avatarImg" src="" alt="Profile" style="display:none">
                        <span id="avatarInitial"><?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?></span>
                    </div>
                    <div class="avatar-overlay" onclick="document.getElementById('avatarFileInput').click()" title="Change photo">
                        <i class="fas fa-camera"></i>
                    </div>
                    <input type="file" id="avatarFileInput" accept="image/jpeg,image/png,image/gif,image/webp"
                           style="display:none" onchange="handleAvatarSelect(this)">
                </div>
                <div>
                    <h2><?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></h2>
                    <p><i class="fas fa-envelope" style="margin-right:5px"></i><?= htmlspecialchars($_SESSION['user_email'] ?? '') ?></p>
                    <?php if (!empty($userProfile['location'])): ?>
                        <p style="margin-top:3px">
                            <i class="fas fa-location-dot" style="margin-right:5px"></i><?= htmlspecialchars($userProfile['location']) ?>
                        </p>
                    <?php endif; ?>
                    <div class="avatar-btns" style="margin-top:10px;display:flex;gap:8px;flex-wrap:wrap">
                        <button type="button" class="btn-avatar-action btn-avatar-upload"
                                onclick="document.getElementById('avatarFileInput').click()">
                            <i class="fas fa-camera"></i> <span id="uploadBtnLabel">Upload Photo</span>
                        </button>
                        <button type="button" class="btn-avatar-action btn-avatar-remove"
                                id="removeAvatarBtn" style="display:none" onclick="removeAvatar()">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            <?php if ($error): ?>
                <div class="alert alert-error"><i class="fas fa-circle-exclamation"></i><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><i class="fas fa-circle-check"></i><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <?php if ($userProfile): ?>
            <div class="form-card">
                <div class="form-head" style="margin-bottom:24px">
                    <h2>Edit Profile</h2>
                    <p>Update your details and skills below</p>
                </div>
                <form method="POST" action="profile.php" class="js-form">
                    <?= csrfField() ?>

                    <div class="form-group">
                        <label><i class="fas fa-user" style="color:var(--blue-400)"></i> Full Name <span class="req">*</span></label>
                        <input type="text" name="full_name" value="<?= htmlspecialchars($userProfile['full_name']) ?>" required>
                        <div class="form-hint">
                            <i class="fas fa-id-card" style="color:var(--blue-400)"></i> Please enter your full name as per your IC.
                        </div>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-envelope" style="color:var(--blue-400)"></i> Email Address</label>
                        <input type="email" value="<?= htmlspecialchars($userProfile['email']) ?>" disabled>
                        <div class="form-hint"><i class="fas fa-lock"></i> Email cannot be changed.</div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-phone" style="color:var(--blue-400)"></i> Phone Number</label>
                            <input type="tel" name="phone"
                                   value="<?= htmlspecialchars($userProfile['phone'] ?? '') ?>"
                                   placeholder="+60 12 345 6789">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-location-dot" style="color:var(--blue-400)"></i> Location</label>
                            <input type="text" name="location"
                                   value="<?= htmlspecialchars($userProfile['location'] ?? '') ?>"
                                   placeholder="e.g. Kuala Lumpur">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-cake-candles" style="color:var(--blue-400)"></i> Date of Birth</label>
                            <input type="date" name="date_of_birth"
                                   value="<?= htmlspecialchars($userProfile['date_of_birth'] ?? '') ?>"
                                   max="<?= date('Y-m-d', strtotime('-10 years')) ?>">
                            <div class="form-hint">
                                <i class="fas fa-circle-info" style="color:var(--blue-400)"></i>
                                Your age will be calculated from this date.
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-user-clock" style="color:var(--blue-400)"></i> Age</label>
                            <?php if (!empty($userProfile['date_of_birth'])): ?>
                                <?php
                                $dob = new DateTime($userProfile['date_of_birth']);
                                $age = (new DateTime())->diff($dob)->y;
                                ?>
                                <input type="text" value="<?= $age ?> years old" disabled
                                       style="background:#f8fafc;color:#374151;font-weight:600">
                                <div class="form-hint"><i class="fas fa-lock"></i> Calculated from your date of birth.</div>
                            <?php else: ?>
                                <input type="text" value="&mdash;" disabled style="background:#f8fafc;color:#9ca3af">
                                <div class="form-hint">
                                    <i class="fas fa-circle-info" style="color:var(--blue-400)"></i>
                                    Enter your date of birth first.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-screwdriver-wrench" style="color:var(--blue-400)"></i> Skills</label>
                        <?php
                        $skillsVal = '';
                        if (!empty($userProfile['skills'])) {
                            $s = $userProfile['skills'];
                            if (is_string($s)) $s = json_decode($s, true) ?? [$s];
                            $skillsVal = implode(', ', (array)$s);
                        }
                        $skillsArr = array_filter(array_map('trim', explode(',', $skillsVal)));
                        ?>
                        <input type="text" name="skills" id="skillsInput"
                               value="<?= htmlspecialchars($skillsVal) ?>"
                               placeholder="e.g. Project Management, Marketing, Web Design"
                               oninput="updateSkillChips(this.value)">
                        <div class="form-hint">Separate multiple skills with commas.</div>
                        <div class="skills-preview" id="skillChips">
                            <?php foreach ($skillsArr as $sk): ?>
                                <span class="skill-preview-chip"><?= htmlspecialchars($sk) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-pen-to-square" style="color:var(--blue-400)"></i> Bio</label>
                        <textarea name="bio" placeholder="Tell us about yourself, your interests, and what drives you to volunteer..."><?= htmlspecialchars($userProfile['bio'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center">
                        <i class="fas fa-floppy-disk"></i> Save Profile
                    </button>
                </form>

                <div class="divider"></div>

                <div style="display:flex;gap:10px;flex-wrap:wrap">
                    <a href="my_applications.php" class="btn btn-secondary" style="flex:1;justify-content:center">
                        <i class="fas fa-clipboard-list"></i> My Applications
                    </a>
                    <a href="opportunity.php" class="btn btn-secondary" style="flex:1;justify-content:center">
                        <i class="fas fa-magnifying-glass"></i> Browse Opportunities
                    </a>
                </div>
            </div>
            <?php else: ?>
                <div class="alert alert-error">
                    <i class="fas fa-circle-exclamation"></i> Could not load profile data. Please try again.
                </div>
            <?php endif; ?>

            <!-- Application Stats -->
            <div class="profile-stats-row" style="margin-top:20px">
                <div class="profile-stat-card">
                    <div class="ps-icon" style="background:#eff6ff;color:#2563eb"><i class="fas fa-paper-plane"></i></div>
                    <div class="ps-num js-count" data-target="<?= $totalApps ?>"><?= $totalApps ?></div>
                    <div class="ps-lbl">Applications</div>
                </div>
                <div class="profile-stat-card">
                    <div class="ps-icon" style="background:#f0fdf4;color:#16a34a"><i class="fas fa-circle-check"></i></div>
                    <div class="ps-num js-count" data-target="<?= $approvedApps ?>"><?= $approvedApps ?></div>
                    <div class="ps-lbl">Approved</div>
                </div>
                <div class="profile-stat-card">
                    <div class="ps-icon" style="background:#fff7ed;color:#f97316"><i class="fas fa-hourglass-half"></i></div>
                    <div class="ps-num js-count" data-target="<?= $pendingApps ?>"><?= $pendingApps ?></div>
                    <div class="ps-lbl">Pending</div>
                </div>
                <div class="profile-stat-card">
                    <div class="ps-icon" style="background:#fef2f2;color:#ef4444"><i class="fas fa-circle-xmark"></i></div>
                    <div class="ps-num js-count" data-target="<?= $rejectedApps ?>"><?= $rejectedApps ?></div>
                    <div class="ps-lbl">Declined</div>
                </div>
            </div>

            <!-- Profile Completion Progress Bar -->
            <div class="progress-card">
                <div class="progress-header">
                    <div class="progress-title">
                        <i class="fas fa-chart-line" style="color:<?= $completionColor ?>"></i>
                        Profile Completeness
                    </div>
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:22px;font-weight:800;color:<?= $completionColor ?>"><?= $completionPct ?>%</span>
                        <span class="progress-badge" style="background:<?= $completionColor ?>"><?= $completionLabel ?></span>
                    </div>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" id="progressFill"
                         data-target="<?= $completionPct ?>"
                         style="background:linear-gradient(90deg,<?= $completionColor ?>cc,<?= $completionColor ?>)">
                    </div>
                </div>
                <div class="progress-steps">
                    <?php foreach ($completionSteps as $label => $done): ?>
                    <div class="progress-step <?= $done ? 'done' : '' ?>">
                        <i class="fas <?= $done ? 'fa-circle-check' : 'fa-circle' ?>"></i>
                        <?= $label ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php if ($completionPct < 100): ?>
                    <p style="font-size:12px;color:#6b7280;margin:12px 0 0">
                        <i class="fas fa-lightbulb" style="color:#f97316"></i>
                        Fill in the missing fields above to boost your profile visibility with organisations.
                    </p>
                <?php else: ?>
                    <p style="font-size:12px;color:#16a34a;margin:12px 0 0;font-weight:600">
                        <i class="fas fa-circle-check"></i> Your profile is 100% complete &mdash; you're ready to impress!
                    </p>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<script>
// Avatar (stored in localStorage)
const AVATAR_KEY = 'volunet_avatar_<?= $_SESSION['user_id'] ?>';

function loadAvatar() {
    const saved     = localStorage.getItem(AVATAR_KEY);
    const img       = document.getElementById('avatarImg');
    const initial   = document.getElementById('avatarInitial');
    const removeBtn = document.getElementById('removeAvatarBtn');
    const uploadBtn = document.getElementById('uploadBtnLabel');

    if (saved) {
        img.src = saved;
        img.style.display      = 'block';
        initial.style.display  = 'none';
        removeBtn.style.display = 'inline-flex';
        uploadBtn.textContent  = 'Change Photo';
    } else {
        img.style.display      = 'none';
        initial.style.display  = '';
        removeBtn.style.display = 'none';
        uploadBtn.textContent  = 'Upload Photo';
    }
}

function handleAvatarSelect(input) {
    if (!input.files.length) return;
    const file = input.files[0];
    if (!file.type.startsWith('image/')) { alert('Please select an image file.'); return; }

    const reader = new FileReader();
    reader.onload = function(e) {
        const image = new Image();
        image.onload = function() {
            const SIZE   = 200;
            const min    = Math.min(image.width, image.height);
            const canvas = document.createElement('canvas');
            canvas.width = SIZE;
            canvas.height = SIZE;
            const ctx = canvas.getContext('2d');
            const sx  = (image.width  - min) / 2;
            const sy  = (image.height - min) / 2;
            ctx.drawImage(image, sx, sy, min, min, 0, 0, SIZE, SIZE);
            const b64 = canvas.toDataURL('image/jpeg', 0.85);
            try {
                localStorage.setItem(AVATAR_KEY, b64);
                loadAvatar();
            } catch(err) {
                alert('Image too large for browser storage. Please pick a smaller photo.');
            }
        };
        image.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function removeAvatar() {
    if (!confirm('Remove your profile picture?')) return;
    localStorage.removeItem(AVATAR_KEY);
    loadAvatar();
}

document.addEventListener('DOMContentLoaded', () => {
    loadAvatar();

    // Animate progress bar
    const fill = document.getElementById('progressFill');
    if (fill) {
        requestAnimationFrame(() => { fill.style.width = fill.dataset.target + '%'; });
    }

    // Animate counters
    document.querySelectorAll('.js-count').forEach(el => {
        const target = parseInt(el.dataset.target, 10) || 0;
        if (!target) return;
        const duration  = 900;
        const startTime = performance.now();
        const tick = now => {
            const t      = Math.min((now - startTime) / duration, 1);
            const eased  = 1 - Math.pow(1 - t, 3);
            el.textContent = Math.round(eased * target);
            if (t < 1) requestAnimationFrame(tick);
            else el.textContent = target;
        };
        requestAnimationFrame(tick);
    });

    // Live age calculation
    const dobInput = document.querySelector('input[name="date_of_birth"]');
    const ageInput = dobInput ? dobInput.closest('.form-row')?.querySelector('input[disabled]') : null;
    if (dobInput && ageInput) {
        dobInput.addEventListener('change', function() {
            const dob = new Date(this.value);
            if (!this.value || isNaN(dob)) { ageInput.value = '—'; return; }
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;
            ageInput.value = age >= 0 ? age + ' years old' : '—';
            ageInput.style.color      = '#374151';
            ageInput.style.fontWeight = '600';
        });
    }
});

// Live skills chip preview
function updateSkillChips(val) {
    const container = document.getElementById('skillChips');
    const skills    = val.split(',').map(s => s.trim()).filter(Boolean);
    container.innerHTML = skills.map(s =>
        `<span class="skill-preview-chip">${s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')}</span>`
    ).join('');
}
</script>

<?php include 'partials/footer.php'; ?>

<style>
@media(max-width:480px){
  .progress-steps{gap:6px}
  .progress-step{font-size:11px;padding:3px 8px}
  .profile-stat-card{padding:14px 10px}
  .ps-num{font-size:20px}
  .ps-lbl{font-size:10px}
}
</style>
