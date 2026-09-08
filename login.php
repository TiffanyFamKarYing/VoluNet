<?php
require_once 'config.php';

if (!empty($_SESSION['user_id'])) {
    redirect('index.php');
}

$error   = '';
$success = '';

// Session-timeout flash message
if (!empty($_SESSION['timeout_msg'])) {
    $error = $_SESSION['timeout_msg'];
    unset($_SESSION['timeout_msg']);
}

// Registration success flash
if (isset($_GET['registered'])) {
    $success = 'Registration successful! Please login to continue.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrfVerify();

    $email    = filter_var(trim($_POST['email']    ?? ''), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $result = supabaseRequest('users?email=eq.' . rawurlencode($email), 'GET');

        if ($result['code'] === 200 && !empty($result['data'][0])) {
            $user = $result['data'][0];

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name']  = $user['full_name'];
                $_SESSION['is_admin']   = $user['is_admin'] ?? false;
                $_SESSION['last_active'] = time(); // initialise activity timer
                redirect('index.php');
            } else {
                $error = 'Invalid email or password.';
            }
        } else {
            $error = 'Invalid email or password.';
        }
    }
}

$pageTitle   = 'Login';
$currentPage = 'login';
include 'partials/head.php';
include 'partials/header.php';
?>

<section class="section">
    <div class="container">
        <div class="form-wrap">

            <?php if ($error): ?>
                <div class="alert alert-error"><i class="fas fa-circle-exclamation"></i><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><i class="fas fa-circle-check"></i><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <div class="form-card">
                <div class="form-head">
                    <div class="form-icon"><i class="fas fa-handshake"></i></div>
                    <h2>Welcome Back</h2>
                    <p>Login to continue your volunteering journey</p>
                </div>

                <form method="POST" action="login.php" class="js-form">
                    <?= csrfField() ?>
                    <div class="form-group">
                        <label><i class="fas fa-envelope" style="color:var(--blue-400)"></i> Email Address <span class="req">*</span></label>
                        <input type="email" name="email" placeholder="you@example.com" required autocomplete="email"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-lock" style="color:var(--blue-400)"></i> Password <span class="req">*</span></label>
                        <input type="password" name="password" placeholder="Your password" required autocomplete="current-password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;margin-top:6px">
                        <i class="fas fa-right-to-bracket"></i> Login to Account
                    </button>
                </form>

                <div class="divider"></div>
                <p style="text-align:center;font-size:14px;color:var(--ink-muted)">
                    Don't have an account?
                    <a href="register.php" style="color:var(--blue-600);font-weight:700;text-decoration:none">Create one free &rarr;</a>
                </p>
            </div>

        </div>
    </div>
</section>

<?php include 'partials/footer.php'; ?>