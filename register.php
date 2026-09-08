<?php
require_once 'config.php';

// Redirect if already logged in
if (!empty($_SESSION['user_id'])) {
    redirect('index.php');
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfVerify();
    $full_name        = clean($_POST['full_name']        ?? '');
    $email            = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone            = clean($_POST['phone']            ?? '');
    $location         = clean($_POST['location']         ?? '');
    $password         = $_POST['password']               ?? '';
    $confirm_password = $_POST['confirm_password']       ?? '';

    // Validation
    if (empty($full_name) || empty($email) || empty($password)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check for duplicate email
        $check = supabaseRequest('users?select=id&email=eq.' . rawurlencode($email), 'GET');

        $emailTaken = false;
        if ($check['code'] === 200 && !empty($check['data'])) {
            $emailTaken = true;
        }

        if ($emailTaken) {
            $error = 'An account with that email already exists. Please login instead.';
        } else {
            // Insert new user
            $userData = [
                'email'      => $email,
                'password'   => password_hash($password, PASSWORD_BCRYPT),
                'full_name'  => $full_name,
                'phone'      => $phone,
                'location'   => $location,
                'is_admin'   => false,
            ];

            $result = supabaseRequest('users', 'POST', $userData);

            if (in_array($result['code'], [200, 201])) {
                $success = 'Registration successful! You can now login.';
                header('Location: login.php?registered=1');
                exit;
            } else {
                $detail = '';
                if (!empty($result['data']['message'])) {
                    $detail = ' (' . $result['data']['message'] . ')';
                } elseif (!empty($result['data']['details'])) {
                    $detail = ' (' . $result['data']['details'] . ')';
                }
                $error = 'Registration failed. Please try again.' . $detail;
                error_log('Supabase register error (HTTP ' . $result['code'] . '): ' . json_encode($result['data']));
            }
        }
    }
}

$pageTitle  = 'Create Account';
$currentPage = 'register';
include 'partials/head.php';
include 'partials/header.php';
?>

<section class="section">
    <div class="container">
        <div class="form-wrap" style="max-width:620px;width:100%">

            <?php if ($error): ?>
                <div class="alert alert-error"><i class="fas fa-circle-exclamation"></i><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><i class="fas fa-circle-check"></i><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <div class="form-card">
                <div class="form-head">
                    <div class="form-icon"><i class="fas fa-user-plus"></i></div>
                    <h2>Join Our Community</h2>
                    <p>Create your free account and start making a difference today</p>
                </div>

                <form method="POST" action="register.php" class="js-form" id="registerForm" novalidate>
                    <?= csrfField() ?>
                    <div class="form-group">
                        <label><i class="fas fa-user" style="color:var(--blue-400)"></i> Full Name <span class="req">*</span></label>
                        <input type="text" name="full_name" placeholder="e.g. Siti Nurhaliza Ahmad"
                               value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" required>
                        <div class="form-hint" style="margin-top:6px">
                            <i class="fas fa-circle-info" style="color:var(--blue-400)"></i> Please enter your full name as per your IC (Identity Card).
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-envelope" style="color:var(--blue-400)"></i> Email Address <span class="req">*</span></label>
                            <input type="email" name="email" placeholder="you@example.com"
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-phone" style="color:var(--blue-400)"></i> Phone</label>
                            <input type="tel" name="phone" placeholder="+60 12 345 6789"
                                   value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-location-dot" style="color:var(--blue-400)"></i> Location</label>
                        <input type="text" name="location" placeholder="e.g. Kuala Lumpur, Selangor"
                               value="<?= htmlspecialchars($_POST['location'] ?? '') ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-lock" style="color:var(--blue-400)"></i> Password <span class="req">*</span></label>
                            <input type="password" name="password" id="pw1" placeholder="Min. 8 characters" required minlength="8">
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-lock" style="color:var(--blue-400)"></i> Confirm Password <span class="req">*</span></label>
                            <input type="password" name="confirm_password" id="pw2" placeholder="Re-enter password" required>
                        </div>
                    </div>
                    <div class="form-hint" style="margin-top:-10px;margin-bottom:18px">
                        <i class="fas fa-circle-info" style="color:var(--blue-400)"></i> Password must be at least 8 characters.
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center">
                        <i class="fas fa-user-plus"></i> Create My Account
                    </button>
                </form>

                <div class="divider"></div>
                <p style="text-align:center;font-size:14px;color:var(--ink-muted)">
                    Already have an account?
                    <a href="login.php" style="color:var(--blue-600);font-weight:700;text-decoration:none">Login here →</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php include 'partials/footer.php'; ?>