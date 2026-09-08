<?php
// partials/header.php
if (!isset($currentPage)) $currentPage = '';
?>
<header id="siteHeader" style="position:relative">
    <div class="container">
        <div class="header-inner">
            <a href="index.php" class="logo">
                <div class="logo-mark"><i class="fas fa-handshake"></i></div>
                <div class="logo-text">Volu<em>Net</em></div>
            </a>
            <nav id="mainNav">
                <a href="index.php"          class="<?= $currentPage==='home'?'active':'' ?>"><i class="fas fa-house"></i> Home</a>
                <a href="aboutus.php"         class="<?= $currentPage==='about'?'active':'' ?>"><i class="fas fa-circle-info"></i> About</a>
                <a href="opportunity.php"     class="<?= $currentPage==='opportunities'?'active':'' ?>"><i class="fas fa-magnifying-glass"></i> Opportunities</a>
                <a href="resources.php"       class="<?= $currentPage==='resources'?'active':'' ?>"><i class="fas fa-book-open"></i> Resources</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="my_applications.php" class="<?= $currentPage==='my_applications'?'active':'' ?>"><i class="fas fa-clipboard-list"></i> Applications</a>
                    <a href="profile.php"         class="<?= $currentPage==='profile'?'active':'' ?>"><i class="fas fa-user"></i> Profile</a>
                    <?php if (!empty($_SESSION['is_admin'])): ?>
                        <a href="admin.php" class="<?= $currentPage==='admin'?'active':'' ?>"><i class="fas fa-gauge"></i> Admin</a>
                    <?php endif; ?>
                    <a href="logout.php" class="nav-danger"><i class="fas fa-right-from-bracket"></i> Logout</a>
                <?php else: ?>
                    <a href="login.php"    class="<?= $currentPage==='login'?'active':'' ?>"><i class="fas fa-right-to-bracket"></i> Login</a>
                    <a href="register.php" class="nav-cta"><i class="fas fa-user-plus"></i> Get Started</a>
                <?php endif; ?>
            </nav>
            <div class="hamburger" id="hamburger" onclick="toggleMobileNav()" aria-label="Menu">
                <span></span><span></span><span></span>
            </div>
        </div>
    </div>
    <!-- Mobile Nav -->
    <div class="mobile-nav" id="mobileNav">
        <a href="index.php"          class="<?= $currentPage==='home'?'active':'' ?>"><i class="fas fa-house"></i> Home</a>
        <a href="aboutus.php"        class="<?= $currentPage==='about'?'active':'' ?>"><i class="fas fa-circle-info"></i> About</a>
        <a href="opportunity.php"    class="<?= $currentPage==='opportunities'?'active':'' ?>"><i class="fas fa-magnifying-glass"></i> Opportunities</a>
        <a href="resources.php"      class="<?= $currentPage==='resources'?'active':'' ?>"><i class="fas fa-book-open"></i> Resources</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="my_applications.php" class="<?= $currentPage==='my_applications'?'active':'' ?>"><i class="fas fa-clipboard-list"></i> My Applications</a>
            <a href="profile.php"         class="<?= $currentPage==='profile'?'active':'' ?>"><i class="fas fa-user"></i> Profile</a>
            <?php if (!empty($_SESSION['is_admin'])): ?>
                <a href="admin.php" class="<?= $currentPage==='admin'?'active':'' ?>"><i class="fas fa-gauge"></i> Admin</a>
            <?php endif; ?>
            <a href="logout.php" class="mn-danger"><i class="fas fa-right-from-bracket"></i> Logout</a>
        <?php else: ?>
            <a href="login.php"    class="<?= $currentPage==='login'?'active':'' ?>"><i class="fas fa-right-to-bracket"></i> Login</a>
            <a href="register.php" class="mn-cta"><i class="fas fa-user-plus"></i> Get Started Free</a>
        <?php endif; ?>
    </div>
</header>
