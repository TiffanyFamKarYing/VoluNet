<?php
require_once 'config.php';

// Fetch a few active opportunities for the featured section (Hand-Picked Opportunities)
$result       = supabaseRequest('opportunities?status=eq.active&order=created_at.desc&limit=6', 'GET');
$opportunities = ($result['code'] === 200 && !empty($result['data'])) ? $result['data'] : [];

$pageTitle   = 'Home';
$currentPage = 'home';
include 'partials/head.php';
include 'partials/header.php';
?>

<!-- HERO -->
<style>
.hero-bubbles {
    position: absolute;
    top: 0; right: 0;
    width: 55%;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
    z-index: 0;
}
.bubble {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    border: 1.5px solid rgba(255,255,255,0.10);
    animation: bubbleFloat linear infinite;
    backdrop-filter: blur(1px);
}
.bubble:nth-child(1)  { width:110px;height:110px; right:8%;  bottom:-120px; animation-duration:9s;  animation-delay:0s;   background:rgba(99,179,255,0.07); }
.bubble:nth-child(2)  { width:70px; height:70px;  right:22%; bottom:-80px;  animation-duration:11s; animation-delay:1.5s; background:rgba(255,255,255,0.05); }
.bubble:nth-child(3)  { width:150px;height:150px; right:35%; bottom:-170px; animation-duration:13s; animation-delay:0.8s; background:rgba(100,160,255,0.06); }
.bubble:nth-child(4)  { width:45px; height:45px;  right:50%; bottom:-60px;  animation-duration:8s;  animation-delay:2s;   background:rgba(255,255,255,0.07); }
.bubble:nth-child(5)  { width:90px; height:90px;  right:14%; bottom:-100px; animation-duration:12s; animation-delay:3s;   background:rgba(120,180,255,0.06); }
.bubble:nth-child(6)  { width:55px; height:55px;  right:42%; bottom:-70px;  animation-duration:10s; animation-delay:0.3s; background:rgba(255,255,255,0.04); }
.bubble:nth-child(7)  { width:130px;height:130px; right:28%; bottom:-150px; animation-duration:15s; animation-delay:1s;   background:rgba(80,140,255,0.05); }
.bubble:nth-child(8)  { width:35px; height:35px;  right:5%;  bottom:-50px;  animation-duration:7s;  animation-delay:4s;   background:rgba(255,255,255,0.08); }
.bubble:nth-child(9)  { width:80px; height:80px;  right:60%; bottom:-90px;  animation-duration:14s; animation-delay:2.5s; background:rgba(140,200,255,0.05); }
.bubble:nth-child(10) { width:60px; height:60px;  right:18%; bottom:-75px;  animation-duration:10s; animation-delay:5s;   background:rgba(255,255,255,0.06); }

@keyframes bubbleFloat {
    0%   { transform: translateY(0)   scale(1);   opacity: 0; }
    10%  { opacity: 1; }
    90%  { opacity: 0.7; }
    100% { transform: translateY(-110vh) scale(1.08); opacity: 0; }
}
</style>
<section class="hero" style="position:relative;overflow:hidden">
    <div class="hero-bg"></div>
    <div class="hero-circle"></div>
    <div class="hero-circle-2"></div>
    <div class="hero-bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>
    <div class="container">
        <div class="hero-content">
            <div>
                <div class="hero-chip hero-enter"><i class="fas fa-rocket"></i> Malaysia's #1 Volunteer Platform</div>
                <h1 class="hero-enter-1">Connect. Volunteer.<br><span class="accent">Transform Lives.</span></h1>
                <p class="hero-lead hero-enter-1">Bridge the gap between passionate volunteers and non-profit organisations. Find paid or unpaid opportunities, grow your skills, and create real impact across Malaysia.</p>
                <div class="hero-btns hero-enter-2">
                    <a href="opportunity.php" class="btn btn-white btn-lg"><i class="fas fa-magnifying-glass"></i> Explore Opportunities</a>
                    <a href="register.php"    class="btn btn-ghost-white btn-lg"><i class="fas fa-user-plus"></i> Join For Free</a>
                </div>
                <div class="avatar-row hero-enter-2">
                    <div class="av-stack">
                        <div class="av-item av-a">T</div>
                        <div class="av-item av-b">F</div>
                        <div class="av-item av-c">K</div>
                        <div class="av-item av-d">Y</div>
                    </div>
                    <div class="av-label">Trusted by <strong>3,300+</strong> volunteers across Malaysia</div>
                </div>
            </div>
            <div class="hero-cards">
                <div class="h-card">
                    <div class="hc-chip"><i class="fas fa-star"></i> Featured Role</div>
                    <div class="hc-title">Community Tech Educator</div>
                    <div class="hc-meta"><i class="fas fa-location-dot"></i> Kuala Lumpur</div>
                    <div class="hc-meta" style="margin-top:3px"><i class="fas fa-clock"></i> 10 hrs/week</div>
                    <span class="hc-badge hc-paid"><i class="fas fa-circle-dollar-to-slot"></i> Paid · RM25/hr</span>
                </div>
                <div class="h-card">
                    <div class="hc-chip"><i class="fas fa-leaf"></i> New Listing</div>
                    <div class="hc-title">Wildlife Conservation Guide</div>
                    <div class="hc-meta"><i class="fas fa-location-dot"></i> Sabah</div>
                    <span class="hc-badge hc-vol"><i class="fas fa-heart"></i> Volunteer</span>
                </div>
                <div class="h-card">
                    <div class="hc-chip"><i class="fas fa-graduation-cap"></i> Resource</div>
                    <div class="hc-title">Leadership in Non-Profits</div>
                    <div class="hc-meta">Free Certification Course</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<style>
.step-circle {
    transition: background 0.4s ease, color 0.4s ease, border-color 0.4s ease,
                transform 0.4s ease, box-shadow 0.4s ease !important;
}
.step-card.step-lit .step-circle {
    background: var(--blue-600) !important;
    color: #fff !important;
    border-color: var(--blue-600) !important;
    transform: scale(1.15) !important;
    box-shadow: 0 0 0 6px rgba(37,99,235,0.15), 0 4px 20px rgba(37,99,235,0.35) !important;
}
</style>

<section class="section">
    <div class="container">
        <div class="section-head centered" data-reveal>
            <div class="section-chip"><i class="fas fa-map"></i> How It Works</div>
            <h2 class="section-title">Start Volunteering in <span class="t-blue">4 Simple Steps</span></h2>
            <p class="section-sub">Getting started is quick and completely free.</p>
        </div>
        <div class="steps-grid" style="margin-top:48px">
            <div class="step-card" data-reveal data-d="1" data-step="1"><div class="step-circle">1</div><h4>Create Your Profile</h4><p>Sign up in seconds and tell us about your skills, interests, and availability.</p></div>
            <div class="step-card" data-reveal data-d="2" data-step="2"><div class="step-circle">2</div><h4>Explore Opportunities</h4><p>Browse hundreds of verified volunteer and paid positions from trusted NGOs.</p></div>
            <div class="step-card" data-reveal data-d="3" data-step="3"><div class="step-circle">3</div><h4>Submit Application</h4><p>Apply with a personalised cover letter and wait for the organisation's response.</p></div>
            <div class="step-card" data-reveal data-d="4" data-step="4"><div class="step-circle">4</div><h4>Create Impact</h4><p>Start volunteering, build real skills, and earn certificates that boost your career.</p></div>
        </div>
    </div>
</section>

<script>
(function () {
    var cards = document.querySelectorAll('.step-card[data-step]');
    if (!cards.length) return;

    var current = 0;
    var litTimer = null;
    var seqTimer = null;

    function lightStep(idx) {
        cards.forEach(function (c) { c.classList.remove('step-lit'); });
        cards[idx].classList.add('step-lit');
        clearTimeout(litTimer);
        litTimer = setTimeout(function () {
            cards[idx].classList.remove('step-lit');
        }, 700);
    }

    function runSequence() {
        clearTimeout(seqTimer);
        current = 0;

        function next() {
            if (current < cards.length) {
                lightStep(current);
                current++;
                seqTimer = setTimeout(next, 800);
            } else {
                seqTimer = setTimeout(runSequence, 1500);
            }
        }
        next();
    }

    var section = document.querySelector('.steps-grid');
    if (!section) return;

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                runSequence();
                observer.disconnect();
            }
        });
    }, { threshold: 0.4 });

    observer.observe(section);
})();
</script>

<!-- WHY VOLUNET -->
<section class="section section-alt">
    <div class="container">
        <div class="section-head centered" data-reveal>
            <div class="section-chip"><i class="fas fa-sparkles"></i> Why VoluNet</div>
            <h2 class="section-title">Join Us in Creating <span class="t-orange">Better Lives</span></h2>
            <p class="section-sub">Effortlessly discover meaningful opportunities and connect with causes aligned with your values, skills, and schedule.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card" data-reveal data-d="1">
                <div class="feature-card-img">
                    <img src="png_vd/Curated_Opportunities.png" alt="Curated Opportunities" loading="lazy">
                </div>
                <div class="fi-wrap fi-blue"><i class="fas fa-bullseye"></i></div>
                <h3>Curated Opportunities</h3>
                <p>Discover positions tailored to your skills, interests, and availability from trusted Malaysian organisations.</p>
            </div>
            <div class="feature-card" data-reveal data-d="2">
                <div class="feature-card-img">
                    <img src="png_vd/Skill_Development.png" alt="Skill Development" loading="lazy">
                </div>
                <div class="fi-wrap fi-orange"><i class="fas fa-graduation-cap"></i></div>
                <h3>Skill Development</h3>
                <p>Access free resources, courses, and certifications to build your professional skills while making a difference.</p>
            </div>
            <div class="feature-card" data-reveal data-d="3">
                <div class="feature-card-img">
                    <img src="png_vd/Verified_Organizations.png" alt="Verified Organizations" loading="lazy">
                </div>
                <div class="fi-wrap fi-green"><i class="fas fa-handshake"></i></div>
                <h3>Verified Organizations</h3>
                <p>All non-profits go through a verification process to ensure safe and legitimate volunteering experiences.</p>
            </div>
        </div>

        <style>
        .feature-card {
            overflow: hidden;
            padding: 0 !important;
            display: flex;
            flex-direction: column;
        }
        .feature-card-img {
            width: 100%;
            height: 190px;
            overflow: hidden;
            border-radius: 16px 16px 0 0;
            flex-shrink: 0;
        }
        .feature-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }
        .feature-card:hover .feature-card-img img {
            transform: scale(1.05);
        }
        .feature-card .fi-wrap,
        .feature-card h3,
        .feature-card p {
            margin-left: 24px;
            margin-right: 24px;
        }
        .feature-card .fi-wrap {
            margin-top: 24px;
        }
        .feature-card p {
            margin-bottom: 24px;
        }
        </style>
    </div>
</section>

<!-- FEATURED OPPORTUNITIES -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header-row" data-reveal>
            <div>
                <div class="section-chip"><i class="fas fa-fire"></i> Featured Roles</div>
                <h2 class="section-title" style="margin-bottom:0">Hand-Picked <span class="t-blue">Opportunities</span></h2>
            </div>
            <a href="opportunity.php" class="btn btn-secondary">View All <i class="fas fa-arrow-right"></i></a>
        </div>

        <?php
        $placeholders = !empty($opportunities) ? array_slice($opportunities, 0, 6) : [
            ['id'=>'','sector'=>'Technology',      'title'=>'Web Developer for NGO Website',          'location'=>'Kuala Lumpur',     'time_commitment'=>'12 hrs/week','is_paid'=>true, 'rate'=>30,'rate_type'=>'hourly','description'=>'Design and develop a responsive website for a non-profit supporting underprivileged youth using modern web technologies.'],
            ['id'=>'','sector'=>'Education',       'title'=>'English Tutor for Underprivileged Kids', 'location'=>'Petaling Jaya',    'time_commitment'=>'6 hrs/week', 'is_paid'=>false,'rate'=>0, 'rate_type'=>'hourly','description'=>'Provide weekly English tutoring sessions to primary-school children from low-income families through fun, interactive lessons.'],
            ['id'=>'','sector'=>'Marketing',       'title'=>'Social Media Content Creator',           'location'=>'Remote / Selangor','time_commitment'=>'8 hrs/week', 'is_paid'=>true, 'rate'=>20,'rate_type'=>'hourly','description'=>'Create compelling social media content for a Malaysian environmental NGO across Instagram and Facebook.'],
            ['id'=>'','sector'=>'Environment',     'title'=>'Community Garden Coordinator',           'location'=>'Shah Alam',        'time_commitment'=>'10 hrs/week','is_paid'=>false,'rate'=>0, 'rate_type'=>'hourly','description'=>'Oversee a growing urban community garden, coordinating volunteers and running composting workshops.'],
            ['id'=>'','sector'=>'Animal Welfare',  'title'=>'Animal Shelter Care Assistant',          'location'=>'Subang Jaya',      'time_commitment'=>'8 hrs/week', 'is_paid'=>false,'rate'=>0, 'rate_type'=>'hourly','description'=>'Assist at a local animal rescue shelter by feeding, grooming, and socialising rescued cats and dogs.'],
            ['id'=>'','sector'=>'Disaster Relief', 'title'=>'Flood Relief Logistics Coordinator',     'location'=>'Kuantan, Pahang',  'time_commitment'=>'20 hrs/week','is_paid'=>true, 'rate'=>25,'rate_type'=>'hourly','description'=>'Coordinate flood relief operations and manage supply inventories to ensure efficient aid distribution.'],
        ];

        $titleToImage = [
            'Web Developer for NGO Website'          => 'png_vd/Web_Developer_for_NGO_Website.png',
            'English Tutor for Underprivileged Kids' => 'png_vd/English_Tutor_for_Underprivileged_Kids.png',
            'Social Media Content Creator'           => 'png_vd/Social_Media_Content_Creator.png',
            'Community Garden Coordinator'           => 'png_vd/Community_Garden_Coordinator.png',
            'Animal Shelter Care Assistant'          => 'png_vd/Animal_Shelter_Care_Assistant.png',
            'Flood Relief Logistics Coordinator'     => 'png_vd/Flood_Relief_Logistics_Coordinator.png',
        ];
        ?>
        <div class="opp-grid">
            <?php foreach ($placeholders as $k => $opp): ?>
            <?php $imgSrc = $titleToImage[$opp['title']] ?? oppImage($k); ?>
            <div class="opp-card">
                <div class="opp-card-img">
                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($opp['title']) ?>" loading="lazy">
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
                    <div class="opp-rate"><i class="fas fa-circle-dollar-to-slot"></i>RM<?= number_format($opp['rate'],2) ?>/<?= $opp['rate_type'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="opp-card-footer">
                    <?php if (!empty($opp['id'])): ?>
                        <a href="opportunity_details.php?id=<?= $opp['id'] ?>" class="btn btn-primary">View Details <i class="fas fa-arrow-right"></i></a>
                    <?php else: ?>
                        <a href="opportunity.php" class="btn btn-primary">Browse Roles <i class="fas fa-arrow-right"></i></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- INTERACTIVE IMPACT MAP -->
<section class="section impact-map-section">
    <div class="container">
        <div class="section-head centered" data-reveal>
            <div class="section-chip"><i class="fas fa-map-location-dot"></i> National Reach</div>
            <h2 class="section-title">Impact Across <span class="t-blue">the Nation</span></h2>
            <p class="section-sub">Volunteering is happening everywhere — from the heart of KL to the rainforests of Sabah. </p>
        </div>

        <div class="impact-map-wrapper" data-reveal>
            <!-- Static Map Image -->
            <div class="map-container">
                <div class="map-img-wrap">
                    <img src="png_vd/Malaysia_Map.png" alt="Map of Malaysia" class="map-real-img">
                </div>
            </div>

            <!-- Right panel: region bar chart -->
            <div class="impact-sidebar">
                <div class="impact-sidebar-title"><i class="fas fa-location-dot"></i> Top 7 Regional States</div>
                <?php
                $regions = [
                    ['city'=>'Kuala Lumpur','pct'=>98,'color'=>'#2563eb','icon'=>'fa-city'],
                    ['city'=>'Selangor',    'pct'=>79,'color'=>'#db2777','icon'=>'fa-house-flag'],
                    ['city'=>'Johor',       'pct'=>61,'color'=>'#ea580c','icon'=>'fa-water'],
                    ['city'=>'Penang',      'pct'=>55,'color'=>'#7c3aed','icon'=>'fa-landmark'],
                    ['city'=>'Sarawak',     'pct'=>45,'color'=>'#d97706','icon'=>'fa-tree'],
                    ['city'=>'Sabah',       'pct'=>32, 'color'=>'#10a031','icon'=>'fa-mountain'],
                    ['city'=>'Pahang',      'pct'=>23, 'color'=>'#07591f','icon'=>'fa-leaf'],
                ];
                foreach ($regions as $r):
                ?>
                <div class="region-row">
                    <div class="region-row-top">
                        <div class="region-icon" style="background:<?= $r['color'] ?>18;color:<?= $r['color'] ?>">
                            <i class="fas <?= $r['icon'] ?>"></i>
                        </div>
                        <div class="region-name"><?= $r['city'] ?></div>
                        <div class="region-count" style="color:<?= $r['color'] ?>"><?= $r['pct'] ?>%</div>
                    </div>
                    <div class="region-bar-track">
                        <div class="region-bar-fill"
                             data-pct="<?= $r['pct'] ?>"
                             style="width:0%;background:<?= $r['color'] ?>;transition:width 1s cubic-bezier(.4,0,.2,1)">
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <div class="sidebar-cta-wrap">
                    <a href="opportunity.php" class="btn btn-primary" style="width:100%;justify-content:center;font-size:13.5px">
                        <i class="fas fa-magnifying-glass"></i> Find Roles Near You
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    var sidebar = document.querySelector('.impact-sidebar');
    if (!sidebar) return;

    var bars   = sidebar.querySelectorAll('.region-bar-fill');
    var counts = sidebar.querySelectorAll('.region-count');
    var animated = false;

    function animateBars() {
        if (animated) return;
        animated = true;

        bars.forEach(function (bar, i) {
            var pct = parseFloat(bar.getAttribute('data-pct')) || 0;
            setTimeout(function () {
                bar.style.width = pct + '%';
            }, i * 120);
        });

        counts.forEach(function (el, i) {
            var target = parseInt(el.textContent, 10) || 0;
            el.textContent = '0%';
            setTimeout(function () {
                var start   = null;
                var dur     = 900;
                function step(ts) {
                    if (!start) start = ts;
                    var p = Math.min((ts - start) / dur, 1);
                    var ease = 1 - (1 - p) * (1 - p);
                    el.textContent = Math.round(ease * target) + '%';
                    if (p < 1) requestAnimationFrame(step);
                }
                requestAnimationFrame(step);
            }, i * 120);
        });
    }

    if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateBars();
                    obs.disconnect();
                }
            });
        }, { threshold: 0.25 });
        obs.observe(sidebar);
    } else {
        animateBars();
    }
})();
</script>

<!-- STATS -->
<div class="stats-strip">
    <div class="container">
        <div class="stats-inner">
            <div class="stat-item"><span class="stat-num" data-count="3300">0</span><span class="stat-lbl"><i class="fas fa-users" style="color:var(--blue-400);margin-right:5px"></i>Active Volunteers</span></div>
            <div class="stat-item"><span class="stat-num" data-count="150">0</span><span class="stat-lbl"><i class="fas fa-briefcase" style="color:var(--blue-400);margin-right:5px"></i>Annual Opportunities</span></div>
            <div class="stat-item"><span class="stat-num" data-count="330">0</span><span class="stat-lbl"><i class="fas fa-building" style="color:var(--blue-400);margin-right:5px"></i>Partner Organisations</span></div>
            <div class="stat-item"><span class="stat-num" data-count="55000">0</span><span class="stat-lbl"><i class="fas fa-clock" style="color:var(--blue-400);margin-right:5px"></i>Hours Volunteered</span></div>
        </div>
    </div>
</div>

<style>

.impact-map-section {
    background: linear-gradient(180deg,#f8fafc 0%,#ffffff 100%);
}

.impact-kpi-row {
    display: flex;
    align-items: center;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(15,23,42,.06);
    padding: 24px 32px;
    margin: 32px 0 36px;
    flex-wrap: wrap;
}
.impact-kpi {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 0 32px;
    flex: 1;
    min-width: 170px;
}
.impact-kpi-div {
    width: 1px; height: 48px;
    background: #e2e8f0;
    flex-shrink: 0;
}
.impact-kpi-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 18px; flex-shrink: 0;
}
.impact-kpi-num { font-size: 22px; font-weight: 800; color: #0f172a; line-height: 1.1; }
.impact-kpi-lbl { font-size: 12px; color: #64748b; margin-top: 2px; font-weight: 500; }
@media(max-width:860px) {
    .impact-kpi-row { padding: 18px 16px; }
    .impact-kpi { padding: 10px 16px; min-width: 140px; }
    .impact-kpi-div { display: none; }
}
@media(max-width:560px) {
    .impact-kpi-row { flex-direction: column; align-items: flex-start; }
    .impact-kpi { width: 100%; border-bottom: 1px solid #f1f5f9; padding: 12px 8px; }
    .impact-kpi:last-child { border-bottom: none; }
}

.impact-map-wrapper {
    display: grid;
    grid-template-columns: 1fr 240px;
    gap: 24px;
    align-items: start;
}
@media(max-width:900px) { .impact-map-wrapper { grid-template-columns: 1fr; } }

.map-container {
    position: relative;
    background: #0d2a3a;
    border-radius: 20px;
    box-shadow: 0 4px 28px rgba(15,23,42,.15);
    border: 1.5px solid #1e3a5f;
    padding: 10px;
    overflow: hidden;
}

.map-img-wrap {
    position: relative;
    width: 100%;
    line-height: 0;
    border-radius: 14px;
    overflow: hidden;
}
.map-real-img {
    width: 100%; height: auto;
    display: block;
    border-radius: 14px;
}

.impact-sidebar {
    background: #fff; border-radius: 20px;
    border: 1.5px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(15,23,42,.07);
    padding: 22px 20px 18px;
    display: flex; flex-direction: column; gap: 14px;
}
.impact-sidebar-title {
    font-size: 12.5px; font-weight: 700; color: #64748b;
    text-transform: uppercase; letter-spacing: .08em;
    display: flex; align-items: center; gap: 7px;
    padding-bottom: 10px; border-bottom: 1.5px solid #f1f5f9;
}
.region-row { display: flex; flex-direction: column; gap: 5px; }
.region-row-top { display: flex; align-items: center; gap: 9px; }
.region-icon {
    width: 28px; height: 28px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; flex-shrink: 0;
}
.region-name { font-size: 13px; font-weight: 600; color: #1e293b; flex: 1; }
.region-count { font-size: 13px; font-weight: 800; }
.region-bar-track { height: 4px; background: #f1f5f9; border-radius: 99px; overflow: hidden; }
.region-bar-fill { height: 100%; border-radius: 99px; }
.sidebar-cta-wrap { margin-top: 4px; padding-top: 14px; border-top: 1.5px solid #f1f5f9; }

@media(max-width:900px) {
    .impact-sidebar { flex-direction: row; flex-wrap: wrap; gap: 12px; }
    .impact-sidebar-title { width: 100%; }
    .region-row { width: calc(50% - 6px); }
    .sidebar-cta-wrap { width: 100%; }
}
@media(max-width:560px) { .region-row { width: 100%; } }
</style>

<!-- PLATFORM TRUST & HIGHLIGHTS -->
<section class="section trust-section" style="background:#ffffff">
    <div class="container">

        <!-- Section Header -->
        <div class="section-head centered" data-reveal>
            <div class="section-chip"><i class="fas fa-shield-halved"></i> Trusted Platform</div>
            <h2 class="section-title">Why Organisations <span class="t-blue">Choose VoluNet</span></h2>
            <p class="section-sub">Powering Malaysia's volunteer ecosystem with transparency, security, and measurable impact.</p>
        </div>

        <!-- Trust Pillars -->
        <div class="trust-pillars" data-reveal>
            <div class="trust-pillar" data-d="1">
                <div class="trust-pillar-icon" style="background:linear-gradient(135deg,#1d4ed8,#3b82f6)">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <div class="trust-pillar-body">
                    <div class="trust-pillar-title">Verified NGO Partners</div>
                    <div class="trust-pillar-desc">Every organisation is screened by our team before listing. Zero unverified listings — ever.</div>
                </div>
                <div class="trust-pillar-badge"><i class="fas fa-check"></i> Active</div>
            </div>
            <div class="trust-pillar" data-d="2">
                <div class="trust-pillar-icon" style="background:linear-gradient(135deg,#059669,#10b981)">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="trust-pillar-body">
                    <div class="trust-pillar-title">Data Privacy First</div>
                    <div class="trust-pillar-desc">PDPA-compliant infrastructure. Your data is never sold or shared with third parties.</div>
                </div>
                <div class="trust-pillar-badge"><i class="fas fa-check"></i> PDPA</div>
            </div>
            <div class="trust-pillar" data-d="3">
                <div class="trust-pillar-icon" style="background:linear-gradient(135deg,#7c3aed,#8b5cf6)">
                    <i class="fas fa-certificate"></i>
                </div>
                <div class="trust-pillar-body">
                    <div class="trust-pillar-title">Recognised Credentials</div>
                    <div class="trust-pillar-desc">Earn verifiable volunteer certificates accepted by Malaysian employers and universities.</div>
                </div>
                <div class="trust-pillar-badge"><i class="fas fa-check"></i> Accredited</div>
            </div>
            <div class="trust-pillar" data-d="4">
                <div class="trust-pillar-icon" style="background:linear-gradient(135deg,#ea580c,#f97316)">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="trust-pillar-body">
                    <div class="trust-pillar-title">Dedicated Support</div>
                    <div class="trust-pillar-desc">Our volunteer coordinators are available Mon–Fri to resolve placement issues within 24 hours.</div>
                </div>
                <div class="trust-pillar-badge"><i class="fas fa-check"></i> 24hr SLA</div>
            </div>
        </div>

        <!-- Divider -->
        <div class="trust-divider"></div>

        <!-- Bottom: Recognition Badges -->
        <div class="trust-press-row" data-reveal>
            <div class="trust-press-badge">
                <i class="fas fa-newspaper"></i>
                <div>
                    <div class="tpb-label">Featured In</div>
                    <div class="tpb-name">The Star Online</div>
                </div>
            </div>
            <div class="trust-press-div"></div>
            <div class="trust-press-badge">
                <i class="fas fa-award"></i>
                <div>
                    <div class="tpb-label">Winner</div>
                    <div class="tpb-name">MyDIGITAL Social Impact Award 2024</div>
                </div>
            </div>
            <div class="trust-press-div"></div>
            <div class="trust-press-badge">
                <i class="fas fa-handshake-angle"></i>
                <div>
                    <div class="tpb-label">Official Partner</div>
                    <div class="tpb-name">Ministry of Youth &amp; Sports Malaysia</div>
                </div>
            </div>
            <div class="trust-press-div"></div>
            <div class="trust-press-badge">
                <i class="fas fa-globe"></i>
                <div>
                    <div class="tpb-label">Recognised by</div>
                    <div class="tpb-name">UN Volunteers Programme</div>
                </div>
            </div>
        </div>

    </div>
</section>

<style>

.trust-section { background: #ffffff; }

.trust-pillars {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-top: 44px;
}
@media(max-width:1000px) { .trust-pillars { grid-template-columns: repeat(2,1fr); } }
@media(max-width:560px)  { .trust-pillars { grid-template-columns: 1fr; } }

.trust-pillar {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 18px;
    padding: 24px 20px 20px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    box-shadow: 0 2px 12px rgba(15,23,42,.05);
    transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    position: relative;
    cursor: default;
}
.trust-pillar[data-d="1"]:hover { transform: translateY(-6px); box-shadow: 0 0 0 3px rgba(29,78,216,0.12), 0 12px 36px rgba(29,78,216,0.22); border-color: #93c5fd; }
.trust-pillar[data-d="2"]:hover { transform: translateY(-6px); box-shadow: 0 0 0 3px rgba(5,150,105,0.12),  0 12px 36px rgba(5,150,105,0.22);  border-color: #6ee7b7; }
.trust-pillar[data-d="3"]:hover { transform: translateY(-6px); box-shadow: 0 0 0 3px rgba(124,58,237,0.12), 0 12px 36px rgba(124,58,237,0.22); border-color: #c4b5fd; }
.trust-pillar[data-d="4"]:hover { transform: translateY(-6px); box-shadow: 0 0 0 3px rgba(234,88,12,0.12),  0 12px 36px rgba(234,88,12,0.22);  border-color: #fdba74; }
.trust-pillar .trust-pillar-icon {
    transition: transform .3s ease, box-shadow .3s ease;
}
.trust-pillar:hover .trust-pillar-icon {
    transform: scale(1.12);
    box-shadow: 0 6px 18px rgba(0,0,0,0.18);
}
.trust-pillar-icon {
    width: 48px; height: 48px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 20px; flex-shrink: 0;
}
.trust-pillar-title {
    font-size: 15px; font-weight: 800; color: #0f172a;
    margin-bottom: 5px;
}
.trust-pillar-desc {
    font-size: 13px; color: #64748b; line-height: 1.6;
}
.trust-pillar-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 11px; font-weight: 700; color: #059669;
    background: #ecfdf5; border: 1px solid #a7f3d0;
    border-radius: 99px; padding: 3px 10px;
    align-self: flex-start; margin-top: auto;
}

.trust-divider {
    height: 1.5px; background: #e2e8f0;
    margin: 44px 0 36px; border-radius: 99px;
}

.trust-logos-wrap { text-align: center; }
.trust-logos-label {
    font-size: 12px; font-weight: 700; color: #94a3b8;
    text-transform: uppercase; letter-spacing: .1em;
    margin-bottom: 18px;
}
.trust-logos-row {
    display: flex; flex-wrap: wrap;
    gap: 12px; justify-content: center;
}
.trust-logo-chip {
    display: flex; align-items: center; gap: 8px;
    padding: 9px 18px;
    background: #fff; border: 1.5px solid #e2e8f0;
    border-radius: 99px;
    font-size: 13px; font-weight: 700; color: #334155;
    box-shadow: 0 1px 6px rgba(15,23,42,.04);
    transition: border-color .2s, box-shadow .2s;
}
.trust-logo-chip:hover {
    border-color: #93c5fd;
    box-shadow: 0 3px 14px rgba(37,99,235,.10);
}

.trust-press-row {
    display: flex; align-items: center;
    flex-wrap: wrap; gap: 0;
    background: #fff; border: 1.5px solid #e2e8f0;
    border-radius: 18px; padding: 20px 32px;
    margin-top: 36px;
    box-shadow: 0 2px 10px rgba(15,23,42,.04);
    justify-content: space-around;
}
.trust-press-badge {
    display: flex; align-items: center; gap: 12px;
    padding: 8px 16px;
    flex: 1; min-width: 180px;
}
.trust-press-badge > i {
    font-size: 22px; color: #2563eb; flex-shrink: 0;
}
.tpb-label {
    font-size: 11px; color: #94a3b8;
    text-transform: uppercase; letter-spacing: .08em; font-weight: 600;
}
.tpb-name {
    font-size: 13px; font-weight: 800; color: #0f172a; margin-top: 2px;
}
.trust-press-div {
    width: 1px; height: 48px; background: #e2e8f0; flex-shrink: 0;
}
@media(max-width:860px) {
    .trust-press-row { padding: 16px; gap: 8px; }
    .trust-press-div { display: none; }
    .trust-press-badge { min-width: calc(50% - 16px); }
}
@media(max-width:480px) {
    .trust-press-badge { min-width: 100%; border-bottom: 1px solid #f1f5f9; padding: 12px 8px; }
    .trust-press-badge:last-child { border-bottom: none; }
}
</style>

<!-- WE ARE SDG 8 -->
<section class="section sdg8-section" style="background:#ffffff">
    <div class="container">
        <div class="sdg8-grid">
            <div class="sdg8-image-wrapper" data-reveal>
                <img src="png_vd/sdg8.png" alt="UN SDG 8 - Decent Work and Economic Growth" class="sdg8-image">
                <div class="sdg8-image-badge">
                    <i class="fas fa-check-circle"></i> UN Global Compact Signatory
                </div>
            </div>
            <div class="sdg8-content" data-reveal data-d="2">
                <div class="section-chip sdg8-chip">
                    <i class="fas fa-leaf"></i> UN Sustainable Development Goal
                </div>
                <h2 class="sdg8-title">
                    We Support <span class="t-orange">SDG 8</span>
                </h2>
                <p class="sdg8-text">
                    <strong>Decent Work and Economic Growth</strong> — promoting sustained, inclusive economic growth, full and productive employment, and decent work for all.
                </p>
                <p class="sdg8-text">
                    Through VoluNet, we create meaningful volunteer opportunities that build skills, employability, and economic empowerment across Malaysian communities.
                </p>
                <div class="sdg8-impact">
                    <div class="sdg8-impact-item">
                        <i class="fas fa-briefcase"></i>
                        <span><strong>1,200+</strong> jobs skills training</span>
                    </div>
                    <div class="sdg8-impact-item">
                        <i class="fas fa-hand-holding-heart"></i>
                        <span><strong>98%</strong> gain new employable skills</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section cta-section" style="background:#f8faff">
    <div class="container">
        <div class="cta-block">
            <div>
                <h2>Ready to Make a Difference?</h2>
                <p>Create your free profile, showcase your skills, and connect with non-profits that genuinely need your expertise today.</p>
            </div>
            <div class="cta-actions">
                <a href="register.php"    class="btn btn-white btn-lg"><i class="fas fa-user-plus"></i> Create Free Account</a>
                <a href="opportunity.php" class="btn btn-ghost-white btn-lg"><i class="fas fa-magnifying-glass"></i> Browse Roles</a>
            </div>
        </div>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
<style>
@media(max-width:768px){
  .section-header-row{flex-direction:column;align-items:flex-start}
}
@media(max-width:640px){
  .feature-card-img{height:160px}
}
</style>