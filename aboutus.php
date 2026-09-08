<?php
require_once 'config.php';

$pageTitle   = 'About Us';
$currentPage = 'about';
include 'partials/head.php';
include 'partials/header.php';
?>

<div class="page-band">
    <div class="container">
        <div class="breadcrumb">
            <a href="index.php">Home</a><i class="fas fa-chevron-right"></i> About Us
        </div>
        <h1><i class="fas fa-circle-info" style="color:var(--orange-400);margin-right:10px"></i>About VoluNet</h1>
        <p>Bridging the gap between passionate volunteers and non-profit organisations across Malaysia.</p>
    </div>
</div>

<!-- AUTO-SCROLL IMAGE SLIDER -->
<section class="img-slider-section">
    <style>
    .img-slider-section {
        padding: 56px 0 52px;
        background: #f8faff;
        overflow: hidden;
    }
    .slider-track-wrap {
        overflow: hidden;
        position: relative;
        -webkit-mask-image: linear-gradient(to right, transparent 0%, #000 8%, #000 92%, transparent 100%);
        mask-image: linear-gradient(to right, transparent 0%, #000 8%, #000 92%, transparent 100%);
    }
    .slider-track {
        display: flex;
        gap: 20px;
        width: max-content;
        animation: sliderScroll 28s linear infinite;
    }
    .slider-track:hover { animation-play-state: paused; }
    .slider-slide {
        flex-shrink: 0;
        width: 300px;
        height: 220px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(15,23,42,0.10);
        border: 1.5px solid rgba(15,23,42,0.06);
        background: #f1f5f9;
        transition: transform 0.35s ease, box-shadow 0.35s ease;
    }
    .slider-slide:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 16px 40px rgba(15,23,42,0.16);
    }
    .slider-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        pointer-events: none;
    }
    @keyframes sliderScroll {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    </style>

    <div class="slider-track-wrap">
        <div class="slider-track">
            <div class="slider-slide"><img src="png_vd/slide1.png" alt="Slide 1"></div>
            <div class="slider-slide"><img src="png_vd/slide2.png" alt="Slide 2"></div>
            <div class="slider-slide"><img src="png_vd/slide3.png" alt="Slide 3"></div>
            <div class="slider-slide"><img src="png_vd/slide4.png" alt="Slide 4"></div>
            <div class="slider-slide"><img src="png_vd/slide5.png" alt="Slide 5"></div>
            <div class="slider-slide"><img src="png_vd/slide6.png" alt="Slide 6"></div>
            <div class="slider-slide"><img src="png_vd/slide7.png" alt="Slide 7"></div>
            <div class="slider-slide"><img src="png_vd/slide8.png" alt="Slide 8"></div>

            <div class="slider-slide"><img src="png_vd/slide1.png" alt="Slide 1"></div>
            <div class="slider-slide"><img src="png_vd/slide2.png" alt="Slide 2"></div>
            <div class="slider-slide"><img src="png_vd/slide3.png" alt="Slide 3"></div>
            <div class="slider-slide"><img src="png_vd/slide4.png" alt="Slide 4"></div>
            <div class="slider-slide"><img src="png_vd/slide5.png" alt="Slide 5"></div>
            <div class="slider-slide"><img src="png_vd/slide6.png" alt="Slide 6"></div>
            <div class="slider-slide"><img src="png_vd/slide7.png" alt="Slide 7"></div>
            <div class="slider-slide"><img src="png_vd/slide8.png" alt="Slide 8"></div>
        </div>
    </div>
</section>

<!-- WHAT IS VOLUNET? SECTION -->
<section class="whatisvolnet-section">
    <div class="wiv-bg-orb wiv-orb1"></div>
    <div class="wiv-bg-orb wiv-orb2"></div>
    <div class="container">
        <div class="wiv-grid">

            <div class="wiv-img-col" data-reveal>
                <div class="wiv-img-frame">
                    <img src="png_vd/VoluNetCompany.png" alt="VoluNet Headquarters" class="wiv-building-img">
                    <div class="wiv-img-glow"></div>
                    <div class="wiv-floating-pill wiv-pill-top">
                        <span class="wiv-pill-dot wiv-dot-blue"></span>
                        <span>Kuala Lumpur</span>
                    </div>
                    <div class="wiv-floating-pill wiv-pill-bottom">
                        <i class="fas fa-location-dot" style="color:var(--orange-400)"></i>
                        <span>Malaysia's #1 Volunteer Platform</span>
                    </div>
                </div>
            </div>

            <div class="wiv-text-col" data-reveal data-d="2">
                <div class="section-chip" style="margin-bottom:18px"><i class="fas fa-circle-question"></i> What is VoluNet?</div>
                <h2 class="wiv-headline">
                    Malaysia's <span class="wiv-hl-blue">Bridge</span> Between<br>
                    Volunteers &amp; <span class="wiv-hl-orange">Organisations</span>
                </h2>
                <p class="wiv-lead">VoluNet is a digital volunteering ecosystem purpose-built for Malaysia — connecting individuals who want to make a difference with non-profit organisations that need their help.</p>

                <div class="wiv-features">
                    <div class="wiv-feature">
                        <div class="wiv-feat-icon wiv-fi-blue"><i class="fas fa-network-wired"></i></div>
                        <div class="wiv-feat-body">
                            <strong>Smart Matching Platform</strong>
                            <p>Our intelligent system pairs volunteers with the right opportunities based on skills, location, and availability.</p>
                        </div>
                    </div>
                    <div class="wiv-feature">
                        <div class="wiv-feat-icon wiv-fi-orange"><i class="fas fa-shield-halved"></i></div>
                        <div class="wiv-feat-body">
                            <strong>Verified Organisations</strong>
                            <p>Every NGO and non-profit on VoluNet is thoroughly vetted — so you can volunteer with complete confidence.</p>
                        </div>
                    </div>
                    <div class="wiv-feature">
                        <div class="wiv-feat-icon wiv-fi-green"><i class="fas fa-chart-line"></i></div>
                        <div class="wiv-feat-body">
                            <strong>Real Impact, Tracked</strong>
                            <p>We measure and celebrate every hour contributed, skill gained, and community strengthened across Malaysia.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.whatisvolnet-section {
    padding: 100px 0 110px;
    background: #ffffff;
    position: relative;
    overflow: hidden;
}
.wiv-bg-orb {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}
.wiv-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: center;
}

.wiv-img-col { position: relative; }
.wiv-img-frame {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(15,23,42,0.13), 0 4px 16px rgba(15,23,42,0.06);
}
.wiv-building-img {
    width: 100%;
    height: 480px;
    object-fit: cover;
    display: block;
    transition: transform 0.7s ease;
}
.wiv-img-frame:hover .wiv-building-img { transform: scale(1.03); }
.wiv-img-glow {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom,
        transparent 50%,
        rgba(15,23,42,0.45) 100%
    );
    pointer-events: none;
}
.wiv-floating-pill {
    position: absolute;
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.96);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.7);
    padding: 9px 16px;
    border-radius: 100px;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--ink, #0f172a);
    box-shadow: 0 4px 16px rgba(15,23,42,0.12);
    white-space: nowrap;
}
.wiv-pill-top  { top: 18px; left: 18px; }
.wiv-pill-bottom { bottom: 18px; right: 18px; }
.wiv-pill-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    display: inline-block;
    flex-shrink: 0;
}
.wiv-dot-blue { background: var(--blue-600, #2563eb); box-shadow: 0 0 0 3px rgba(37,99,235,0.2); }

.wiv-headline {
    font-family: var(--font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: clamp(28px, 3.2vw, 35px);
    font-weight: 700;
    letter-spacing: -0.025em;
    line-height: 1.15;
    color: var(--ink, #0f172a);
    margin-bottom: 18px;
}
.wiv-hl-blue   { color: var(--blue-600, #2563eb); }
.wiv-hl-orange { color: var(--orange-500, #f97316); }
.wiv-lead {
    color: var(--ink-muted, #64748b);
    font-size: 15px;
    line-height: 1.75;
    margin-bottom: 32px;
    text-align: justify;
}

.wiv-features { display: flex; flex-direction: column; gap: 20px; margin-bottom: 36px; }
.wiv-feature {
    display: flex;
    gap: 16px;
    align-items: flex-start;
}
.wiv-feat-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px;
    flex-shrink: 0;
}
.wiv-fi-blue   { background: rgba(37,99,235,0.1);  color: var(--blue-600,  #2563eb); }
.wiv-fi-orange { background: rgba(249,115,22,0.1);  color: var(--orange-400,#fb923c); }
.wiv-fi-green  { background: rgba(22,163,74,0.1);   color: #16a34a; }
.wiv-feat-body strong {
    display: block;
    font-size: 14.5px;
    font-weight: 700;
    color: var(--ink, #0f172a);
    margin-bottom: 3px;
}
.wiv-feat-body p {
    font-size: 13.5px;
    color: var(--ink-muted, #64748b);
    line-height: 1.6;
    margin: 0;
    text-align: justify;
}

@media (max-width: 860px) {
    .wiv-grid { grid-template-columns: 1fr; gap: 40px; }
    .wiv-building-img { height: 300px; }
}
</style>

<!-- MISSION SECTION -->
<section class="section" style="background:#ffffff !important;">
    <div class="container">
        <div class="mission-grid">
            <div class="mission-text" data-reveal>
                <div class="section-chip" style="margin-bottom:16px"><i class="fas fa-heart"></i> Our Mission</div>
                <h2>Empowering <span style="color:var(--blue-600)">Volunteers</span>, Strengthening <span style="color:var(--orange-600)">Communities</span></h2>
                <p>VoluNet was founded with a simple but powerful belief: every Malaysian has something valuable to contribute, and every non-profit deserves access to skilled, passionate people.</p>
                <p>We built a platform that removes friction between wanting to help and actually helping — making it easy to discover opportunities, apply with confidence, and grow your skills along the way.</p>
                <p>Whether you're a fresh graduate, a professional wanting to give back, or an NGO in need of reliable talent, VoluNet is your bridge to a more connected, impactful Malaysia.</p>
                <div class="mission-btns">
                <a href="..." class="btn btn-primary">Find Opportunities</a>
                <a href="..." class="btn btn-secondary">Join VoluNet</a>
                </div>
            </div>

            <div class="mission-img-col" data-reveal data-d="2">
                <div class="mission-img-frame">
                    <img src="png_vd/VolunetTeam.png" alt="Volunteers working together" class="mission-team-img">
                    <div class="mission-img-glow"></div>
                    <div class="mission-floating-badge">
                        <div class="mib-icon"><i class="fas fa-handshake"></i></div>
                        <div class="mib-text">
                            <strong>Building Connections Since 2022</strong>
                            <span>3,300+ volunteers · 330+ organisations</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.mission-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: center;
}

.mission-img-col { position: relative; }

.mission-img-frame {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(15,23,42,0.13), 0 4px 16px rgba(15,23,42,0.06);
}

.mission-team-img {
    width: 100%;
    height: 480px;
    object-fit: cover;
    object-position: center top;
    display: block;
    transition: transform 0.7s ease;
}
.mission-img-frame:hover .mission-team-img { transform: scale(1.03); }

.mission-img-glow {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom,
        transparent 50%,
        rgba(15,23,42,0.55) 100%
    );
    pointer-events: none;
}

.mission-floating-badge {
    position: absolute;
    bottom: 18px;
    left: 18px;
    right: 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    background: rgba(255,255,255,0.96);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.7);
    padding: 12px 16px;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(15,23,42,0.12);
}
.mib-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: var(--blue-600, #2563eb);
    display: flex; align-items: center; justify-content: center;
    color: white;
    font-size: 16px;
    flex-shrink: 0;
}
.mib-text {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.mib-text strong {
    font-size: 13px;
    font-weight: 700;
    color: var(--ink, #0f172a);
    line-height: 1.3;
}
.mib-text span {
    font-size: 12px;
    color: var(--ink-muted, #64748b);
}

@media (max-width: 860px) {
    .mission-grid { grid-template-columns: 1fr; gap: 40px; }
    .mission-team-img { height: 300px; }
}
</style>

<section class="section section-alt">
    <div class="container">
        <div class="section-head centered" data-reveal>
            <div class="section-chip"><i class="fas fa-star"></i> Our Values</div>
            <h2 class="section-title">What We <span class="t-orange">Stand For</span></h2>
            <p class="section-sub">Our values guide every decision we make and every feature we build for our community.</p>
        </div>
        <div class="values-grid">
            <div class="value-card" data-reveal data-d="1"><div class="value-icon vi-blue"><i class="fas fa-handshake"></i></div><h3>Trust &amp; Transparency</h3><p>We verify all partner organisations and opportunities to ensure our volunteers always have safe, legitimate, and rewarding experiences.</p></div>
            <div class="value-card" data-reveal data-d="2"><div class="value-icon vi-orange"><i class="fas fa-seedling"></i></div><h3>Growth for All</h3><p>We believe volunteering should be a two-way street — organisations get help, volunteers gain skills, experience, and meaningful connections.</p></div>
            <div class="value-card" data-reveal data-d="3"><div class="value-icon vi-green"><i class="fas fa-people-group"></i></div><h3>Inclusive Community</h3><p>We welcome volunteers of all backgrounds, skills, and experience levels. Every contribution matters, big or small.</p></div>
        </div>
    </div>
</section>

<div class="agency-video">
    <div class="video-frame">
        <video autoplay muted loop playsinline poster="png_vd/VoluNetTeam.png">
            <source src="png_vd/volunet.mp4" type="video/mp4">
            <p style="text-align:center;padding:40px;color:var(--ink-muted)">Your browser does not support HTML5 video.</p>
        </video>
        <div class="video-blob"></div>
    </div>
</div>

<style>
.story-section {
    padding: 100px 0 120px;
    background: var(--white, #ffffff);
    position: relative;
    overflow: hidden;
}
.story-section::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(37,99,235,0.06) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.story-section::after {
    content: '';
    position: absolute;
    bottom: -60px; left: -60px;
    width: 300px; height: 300px;
    border-radius: 50%;
    pointer-events: none;
}
.story-header { text-align: center; margin-bottom: 72px; }

.story-mosaic {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    grid-template-rows: repeat(3, 200px);
    gap: 12px;
    margin-bottom: 80px;
}
.mosaic-item {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
}
.mosaic-item img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    display: block;
}
.mosaic-item:hover img { transform: scale(1.06); }
.mosaic-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(15,23,42,0.78) 0%, transparent 55%);
    opacity: 0;
    transition: opacity 0.35s ease;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    padding: 16px;
}
.mosaic-item:hover .mosaic-overlay { opacity: 1; }
.mosaic-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: white;
    color: var(--ink, #0f172a);
    font-size: 12px;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 100px;
}
.mosaic-zoom {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px; height: 34px;
    background: rgba(255,255,255,0.15);
    border: 1.5px solid rgba(255,255,255,0.45);
    border-radius: 50%;
    color: white;
    font-size: 14px;
    backdrop-filter: blur(4px);
    transition: background 0.2s, transform 0.2s;
    flex-shrink: 0;
}
.mosaic-item:hover .mosaic-zoom {
    background: rgba(255,255,255,0.3);
    transform: scale(1.1);
}
.sm1 { grid-column: 1 / 6;  grid-row: 1 / 3; }
.sm2 { grid-column: 6 / 9;  grid-row: 1 / 2; }
.sm3 { grid-column: 9 / 13; grid-row: 1 / 2; }
.sm4 { grid-column: 6 / 10; grid-row: 2 / 3; }
.sm5 { grid-column: 10 / 13;grid-row: 2 / 3; }
.sm6 { grid-column: 1 / 5;  grid-row: 3 / 4; }
.sm7 { grid-column: 5 / 9;  grid-row: 3 / 4; }
.sm8 { grid-column: 9 / 13; grid-row: 3 / 4; }

#vn-lightbox {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(7, 12, 25, 0.9);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    align-items: center;
    justify-content: center;
    padding: 24px;
}
#vn-lightbox.lb-open {
    display: flex;
    animation: lb-fadein 0.22s ease;
}
@keyframes lb-fadein {
    from { opacity: 0; }
    to   { opacity: 1; }
}
.lb-inner {
    position: relative;
    max-width: 1000px;
    width: 100%;
    animation: lb-scalein 0.28s cubic-bezier(0.34, 1.4, 0.64, 1);
}
@keyframes lb-scalein {
    from { opacity: 0; transform: scale(0.88); }
    to   { opacity: 1; transform: scale(1); }
}
.lb-close {
    position: absolute;
    top: -48px;
    right: 0;
    width: 38px; height: 38px;
    border-radius: 50%;
    background: rgba(255,255,255,0.12);
    border: 1.5px solid rgba(255,255,255,0.35);
    color: white;
    font-size: 24px;
    line-height: 1;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, transform 0.25s;
    z-index: 2;
    padding: 0;
}
.lb-close:hover {
    background: rgba(255,255,255,0.25);
    transform: scale(1.12) rotate(90deg);
}
.lb-img-wrap {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,0.65);
    line-height: 0;
}
.lb-img-wrap img {
    width: 100%;
    height: auto;
    max-height: 78vh;
    object-fit: contain;
    display: block;
    background: #0d1626;
}
.lb-caption {
    margin-top: 14px;
    text-align: center;
}
.lb-caption-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    color: white;
    font-size: 13px;
    font-weight: 600;
    padding: 7px 18px;
    border-radius: 100px;
    backdrop-filter: blur(4px);
}

.story-timeline-wrap {
    position: relative;
    padding-bottom: 40px;
}
.story-timeline-line {
    position: absolute;
    left: 50%;
    top: 0; bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom,
        rgba(37,99,235,0) 0%,
        var(--blue-600, #2563eb) 12%,
        var(--orange-500, #f97316) 88%,
        rgba(249,115,22,0) 100%);
    transform: translateX(-50%);
    border-radius: 100px;
    box-shadow: 0 0 10px rgba(37,99,235,0.22), 0 0 4px rgba(37,99,235,0.12);
}

.story-timeline-line::after {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    width: 10px; height: 10px;
    background: #ffffff;
    border: 2.5px solid var(--blue-600, #2563eb);
    border-radius: 50%;
    transform: translateX(-50%);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.18), 0 2px 8px rgba(37,99,235,0.3);
    animation: line-dot-travel 5s ease-in-out infinite;
}
@keyframes line-dot-travel {
    0%   { top: 0%;   opacity: 0; }
    6%   { opacity: 1; }
    94%  { opacity: 1; }
    100% { top: 100%; opacity: 0; }
}
.story-timeline-events {
    display: flex;
    flex-direction: column;
    gap: 52px;
}
.st-event {
    display: grid;
    grid-template-columns: 1fr 60px 1fr;
    align-items: center;
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}
.st-event.st-visible { opacity: 1; transform: translateY(0); }
.st-event:nth-child(odd)  .st-content { grid-column: 3; text-align: left; }
.st-event:nth-child(odd)  .st-dot     { grid-column: 2; }
.st-event:nth-child(odd)  .st-empty   { grid-column: 1; }
.st-event:nth-child(even) .st-content { grid-column: 1; text-align: right; }
.st-event:nth-child(even) .st-dot     { grid-column: 2; }
.st-event:nth-child(even) .st-empty   { grid-column: 3; }
.st-dot {
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
}
.st-dot-inner {
    width: 48px; height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: white;
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    flex-shrink: 0;
    position: relative;
}

.st-event.st-visible .st-dot-inner {
    animation: dot-pop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) both;
}
@keyframes dot-pop {
    from { transform: scale(0.4); opacity: 0; }
    to   { transform: scale(1);   opacity: 1; }
}

.st-dot-inner::after {
    content: '';
    position: absolute;
    inset: -5px;
    border-radius: 50%;
    border: 2px solid currentColor;
    opacity: 0;
    animation: dot-ring 2.8s ease-out infinite;
}
@keyframes dot-ring {
    0%   { opacity: 0.55; transform: scale(1); }
    100% { opacity: 0;    transform: scale(1.75); }
}
.sdt-blue   { background: var(--blue-600, #2563eb);   color: var(--blue-600,  #2563eb); }
.sdt-orange { background: var(--orange-500, #f97316); color: var(--orange-500,#f97316); }
.sdt-green  { background: #16a34a;                    color: #16a34a; }
.sdt-purple { background: #7c3aed;                    color: #7c3aed; }

.st-dot-inner i { color: white; position: relative; z-index: 1; }
.st-content { padding: 0 28px; }
.st-year {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--blue-600, #2563eb);
    margin-bottom: 6px;
}
.st-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 22px 24px;
    box-shadow: 0 2px 12px rgba(15,23,42,0.06);
    transition: box-shadow 0.25s, transform 0.25s;
}
.st-card:hover {
    box-shadow: 0 8px 32px rgba(15,23,42,0.12);
    transform: translateY(-2px);
}
.st-card h4 {
    font-size: 18px;
    font-weight: 700;
    color: var(--ink, #0f172a);
    margin-bottom: 8px;
}
.st-card p {
    font-size: 14px;
    color: var(--ink-muted, #64748b);
    line-height: 1.65;
    margin-bottom: 12px;
}
.st-tags { display: flex; flex-wrap: wrap; gap: 6px; }
.st-event:nth-child(even) .st-tags { justify-content: flex-end; }
.st-tag {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 100px;
    background: #f8fafc;
    color: #64748b;
    border: 1px solid #e2e8f0;
}
.st-tag i { font-size: 10px; }

@media (max-width: 900px) {
    .story-mosaic {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: repeat(4, 180px);
    }
    .sm1 { grid-column:1/2; grid-row:1/3; }
    .sm2 { grid-column:2/3; grid-row:1/2; }
    .sm3 { grid-column:2/3; grid-row:2/3; }
    .sm4 { grid-column:1/2; grid-row:3/4; }
    .sm5 { grid-column:2/3; grid-row:3/4; }
    .sm6 { grid-column:1/2; grid-row:4/5; }
    .sm7 { grid-column:2/3; grid-row:4/5; }
    .sm8 { display:none; }
    .story-timeline-line { display:none; }
    .st-event { grid-template-columns: 1fr; }
    .st-event:nth-child(odd)  .st-content,
    .st-event:nth-child(even) .st-content { grid-column:1; text-align:left; padding:0; }
    .st-event:nth-child(odd)  .st-dot,
    .st-event:nth-child(even) .st-dot,
    .st-event:nth-child(odd)  .st-empty,
    .st-event:nth-child(even) .st-empty { display:none; }
    .st-event:nth-child(even) .st-tags { justify-content:flex-start; }
}
@media (max-width: 600px) {
    .story-mosaic { grid-template-columns:1fr; grid-template-rows:repeat(5,160px); }
    .sm1,.sm2,.sm3,.sm4,.sm5 { grid-column:1; grid-row:auto; }
    .sm6,.sm7,.sm8 { display:none; }
    .lb-close { top: -52px; }
}
</style>

<section class="story-section">
    <div class="container">

        <!-- HEADER -->
        <div class="story-header section-head centered" data-reveal>
            <div class="section-chip"><i class="fas fa-camera-retro"></i> Our Journey</div>
            <h2 class="section-title">The VoluNet <span class="t-orange">Story</span> — Built <span class="t-blue">Together</span></h2>
            <p class="section-sub">From a bold idea to a thriving community — every milestone, every event, every moment of growth. This is us.</p>
        </div>

        <!-- MOSAIC PHOTO GRID -->
        <div class="story-mosaic">
            <div class="mosaic-item sm1" onclick="openLightbox('png_vd/Corporate_Launch_2023.png','Corporate Launch 2023','fas fa-flag')">
                <img src="png_vd/Corporate_Launch_2023.png" alt="Corporate Launch 2023">
                <div class="mosaic-overlay">
                    <span class="mosaic-tag"><i class="fas fa-flag"></i> Corporate Launch 2023</span>
                    <span class="mosaic-zoom"><i class="fas fa-magnifying-glass-plus"></i></span>
                </div>
            </div>
            <div class="mosaic-item sm2" onclick="openLightbox('png_vd/Learn_Together.png','Learn Together','fas fa-graduation-cap')">
                <img src="png_vd/Learn_Together.png" alt="Learn Together">
                <div class="mosaic-overlay">
                    <span class="mosaic-tag"><i class="fas fa-graduation-cap"></i> Learn Together</span>
                    <span class="mosaic-zoom"><i class="fas fa-magnifying-glass-plus"></i></span>
                </div>
            </div>
            <div class="mosaic-item sm3" onclick="openLightbox('png_vd/Community_Event.png','Community Event','fas fa-calendar-star')">
                <img src="png_vd/Community_Event.png" alt="Community Event">
                <div class="mosaic-overlay">
                    <span class="mosaic-tag"><i class="fas fa-calendar-star"></i> Community Event</span>
                    <span class="mosaic-zoom"><i class="fas fa-magnifying-glass-plus"></i></span>
                </div>
            </div>
            <div class="mosaic-item sm4" onclick="openLightbox('png_vd/Team_Activities.png','Team Activities','fas fa-people-group')">
                <img src="png_vd/Team_Activities.png" alt="Team Activities">
                <div class="mosaic-overlay">
                    <span class="mosaic-tag"><i class="fas fa-people-group"></i> Team Activities</span>
                    <span class="mosaic-zoom"><i class="fas fa-magnifying-glass-plus"></i></span>
                </div>
            </div>
            <div class="mosaic-item sm5" onclick="openLightbox('png_vd/Gain_Together.png','Gain Together','fas fa-chart-line')">
                <img src="png_vd/Gain_Together.png" alt="Gain Together">
                <div class="mosaic-overlay">
                    <span class="mosaic-tag"><i class="fas fa-chart-line"></i> Gain Together</span>
                    <span class="mosaic-zoom"><i class="fas fa-magnifying-glass-plus"></i></span>
                </div>
            </div>
            <div class="mosaic-item sm6" onclick="openLightbox('png_vd/Volunteer_Day.png','Volunteer Day','fas fa-hands-holding-heart')">
                <img src="png_vd/Volunteer_Day.png" alt="Volunteer Day">
                <div class="mosaic-overlay">
                    <span class="mosaic-tag"><i class="fas fa-hands-holding-heart"></i> Volunteer Day</span>
                    <span class="mosaic-zoom"><i class="fas fa-magnifying-glass-plus"></i></span>
                </div>
            </div>
            <div class="mosaic-item sm7" onclick="openLightbox('png_vd/Awards_Night.png','Awards Night','fas fa-trophy')">
                <img src="png_vd/Awards_Night.png" alt="Awards Night">
                <div class="mosaic-overlay">
                    <span class="mosaic-tag"><i class="fas fa-trophy"></i> Awards Night</span>
                    <span class="mosaic-zoom"><i class="fas fa-magnifying-glass-plus"></i></span>
                </div>
            </div>
            <div class="mosaic-item sm8" onclick="openLightbox('png_vd/Our_Culture.png','Our Culture','fas fa-building')">
                <img src="png_vd/Our_Culture.png" alt="Our Culture">
                <div class="mosaic-overlay">
                    <span class="mosaic-tag"><i class="fas fa-building"></i> Our Culture</span>
                    <span class="mosaic-zoom"><i class="fas fa-magnifying-glass-plus"></i></span>
                </div>
            </div>
        </div>

        <!-- TIMELINE -->
        <div class="story-timeline-wrap">
            <div class="story-timeline-line"></div>
            <div class="story-timeline-events">

                <div class="st-event">
                    <div class="st-empty"></div>
                    <div class="st-dot"><div class="st-dot-inner sdt-blue"><i class="fas fa-rocket"></i></div></div>
                    <div class="st-content">
                        <div class="st-year">August 2022</div>
                        <div class="st-card">
                            <h4>The Beginning — VoluNet is Born</h4>
                            <p>Our founder Tiffany gathered a small team with a big dream: connect passionate Malaysians to NGOs that need them. The first lines of code were written in a co-working space in PJ.</p>
                            <div class="st-tags">
                                <span class="st-tag"><i class="fas fa-flag"></i> Founding</span>
                                <span class="st-tag"><i class="fas fa-laptop-code"></i> Corporate</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="st-event">
                    <div class="st-content">
                        <div class="st-year">January 2023</div>
                        <div class="st-card">
                            <h4>First Community Clean-Up Drive</h4>
                            <p>89 volunteers, 3 neighbourhoods, 1 unforgettable Saturday. Our first real-world event proved that VoluNet wasn't just an app — it was a movement.</p>
                            <div class="st-tags">
                                <span class="st-tag"><i class="fas fa-leaf"></i> Activity</span>
                                <span class="st-tag"><i class="fas fa-people-group"></i> Community</span>
                            </div>
                        </div>
                    </div>
                    <div class="st-dot"><div class="st-dot-inner sdt-green"><i class="fas fa-seedling"></i></div></div>
                    <div class="st-empty"></div>
                </div>

                <div class="st-event">
                    <div class="st-empty"></div>
                    <div class="st-dot"><div class="st-dot-inner sdt-orange"><i class="fas fa-graduation-cap"></i></div></div>
                    <div class="st-content">
                        <div class="st-year">May 2023</div>
                        <div class="st-card">
                            <h4>Learn Together — Skills Bootcamp Series</h4>
                            <p>We launched our first free workshop series — CV writing, public speaking, and digital skills — open to all volunteers. Over 780 attendees across three cities.</p>
                            <div class="st-tags">
                                <span class="st-tag"><i class="fas fa-graduation-cap"></i> Learn Together</span>
                                <span class="st-tag"><i class="fas fa-chalkboard-teacher"></i> Workshop</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="st-event">
                    <div class="st-content">
                        <div class="st-year">October 2023</div>
                        <div class="st-card">
                            <h4>VoluNet Gala — Gain Together Awards Night</h4>
                            <p>We celebrated our top volunteers, partner NGOs, and a year of impact at our first Gala. 2,200 volunteer hours recognised. Tears, laughs, and a standing ovation.</p>
                            <div class="st-tags">
                                <span class="st-tag"><i class="fas fa-trophy"></i> Event</span>
                                <span class="st-tag"><i class="fas fa-chart-line"></i> Gain Together</span>
                            </div>
                        </div>
                    </div>
                    <div class="st-dot"><div class="st-dot-inner sdt-purple"><i class="fas fa-trophy"></i></div></div>
                    <div class="st-empty"></div>
                </div>

                <div class="st-event">
                    <div class="st-empty"></div>
                    <div class="st-dot"><div class="st-dot-inner sdt-blue"><i class="fas fa-handshake"></i></div></div>
                    <div class="st-content">
                        <div class="st-year">March 2024</div>
                        <div class="st-card">
                            <h4>Corporate Partnership Programme Launched</h4>
                            <p>Top Malaysian companies joined VoluNet to build CSR volunteering programmes. 30+ corporate partners signed in Year 1, unlocking 300+ new opportunities for volunteers.</p>
                            <div class="st-tags">
                                <span class="st-tag"><i class="fas fa-building"></i> Corporate</span>
                                <span class="st-tag"><i class="fas fa-handshake"></i> Partnership</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="st-event">
                    <div class="st-content">
                        <div class="st-year">Present — 2025 & Beyond</div>
                        <div class="st-card">
                            <h4>3,300+ Volunteers. Still Growing.</h4>
                            <p>Today, VoluNet connects thousands of Malaysians with 330+ verified NGOs. We continue to learn, give, and grow — together. The best chapters are still ahead.</p>
                            <div class="st-tags">
                                <span class="st-tag"><i class="fas fa-star"></i> Milestone</span>
                                <span class="st-tag"><i class="fas fa-heart"></i> Community</span>
                                <span class="st-tag"><i class="fas fa-infinity"></i> Growing</span>
                            </div>
                        </div>
                    </div>
                    <div class="st-dot"><div class="st-dot-inner sdt-orange"><i class="fas fa-star"></i></div></div>
                    <div class="st-empty"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── CERTIFICATES & AWARDS SECTION ── -->
<section class="section section-alt">
    <div class="container">
        <div class="section-head centered" data-reveal>
            <div class="section-chip"><i class="fas fa-award"></i> Recognition</div>
            <h2 class="section-title">Certificates &amp; <span class="t-orange">Awards</span></h2>
            <p class="section-sub">Proud milestones that reflect the dedication of our volunteers, partners, and team in making a difference across Malaysia.</p>
        </div>

        <style>
        .awards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-top: 48px;
        }
        @media (max-width: 1024px) { .awards-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 560px)  { .awards-grid { grid-template-columns: 1fr; } }

        .award-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(15,23,42,0.06);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            position: relative;
        }
        .award-card:hover {
            box-shadow: 0 12px 40px rgba(15,23,42,0.14);
            transform: translateY(-4px);
        }
        .award-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 20px;
            border: 2px solid transparent;
            background: linear-gradient(135deg, var(--blue-600,#2563eb), var(--orange-500,#f97316)) border-box;
            -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: destination-out;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .award-card:hover::before { opacity: 1; }

        .award-img-wrap {
            width: 100%;
            aspect-ratio: 3/2;
            overflow: hidden;
            background: #f8fafc;
            position: relative;
        }
        .award-img-wrap img {
            width: 100%; height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            transition: transform 0.5s cubic-bezier(0.25,0.46,0.45,0.94);
        }
        .award-card:hover .award-img-wrap img { transform: scale(1.07); }
        .award-img-badge {
            position: absolute;
            top: 10px; right: 10px;
            width: 36px; height: 36px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .aib-blue   { background: var(--blue-600, #2563eb); }
        .aib-orange { background: var(--orange-500, #f97316); }
        .aib-green  { background: #16a34a; }
        .aib-purple { background: #7c3aed; }

        .award-body {
            padding: 18px 18px 20px;
        }
        .award-year {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--blue-600, #2563eb);
            margin-bottom: 6px;
        }
        .award-body h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--ink, #0f172a);
            margin-bottom: 6px;
            line-height: 1.4;
        }
        .award-body p {
            font-size: 13px;
            color: var(--ink-muted, #64748b);
            line-height: 1.6;
            margin-bottom: 12px;
        }
        .award-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 100px;
            background: #f8fafc;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }
        .award-tag i { font-size: 10px; }
        </style>

        <div class="awards-grid">

            <div class="award-card" data-reveal data-d="1">
                <div class="award-img-wrap">
                    <img src="png_vd/cert1.png" alt="Best Volunteer Platform Award">
                    <div class="award-img-badge aib-blue"><i class="fas fa-trophy"></i></div>
                </div>
                <div class="award-body">
                    <div class="award-year">2023</div>
                    <h4>Best Volunteer Platform — Malaysia Digital Awards</h4>
                    <p>Recognised as the top emerging platform connecting Malaysians with meaningful volunteer opportunities.</p>
                    <span class="award-tag"><i class="fas fa-medal"></i> National Award</span>
                </div>
            </div>

            <div class="award-card" data-reveal data-d="2">
                <div class="award-img-wrap">
                    <img src="png_vd/cert2.png" alt="Community Impact Certificate">
                    <div class="award-img-badge aib-green"><i class="fas fa-certificate"></i></div>
                </div>
                <div class="award-body">
                    <div class="award-year">2023</div>
                    <h4>Community Impact Certificate — MCMC Social Innovation</h4>
                    <p>Awarded for driving measurable community outcomes through technology-enabled volunteering across three states.</p>
                    <span class="award-tag"><i class="fas fa-certificate"></i> Certificate</span>
                </div>
            </div>

            <div class="award-card" data-reveal data-d="3">
                <div class="award-img-wrap">
                    <img src="png_vd/cert3.png" alt="Top NGO Partnership Award">
                    <div class="award-img-badge aib-orange"><i class="fas fa-handshake"></i></div>
                </div>
                <div class="award-body">
                    <div class="award-year">2024</div>
                    <h4>Top NGO Partnership Excellence — Yayasan Volunteers Malaysia</h4>
                    <p>Honoured for building the most active and trusted network of NGO partnerships in Peninsular Malaysia.</p>
                    <span class="award-tag"><i class="fas fa-handshake"></i> Partnership</span>
                </div>
            </div>

            <div class="award-card" data-reveal data-d="4">
                <div class="award-img-wrap">
                    <img src="png_vd/cert4.png" alt="Social Entrepreneur of the Year">
                    <div class="award-img-badge aib-purple"><i class="fas fa-star"></i></div>
                </div>
                <div class="award-body">
                    <div class="award-year">2024</div>
                    <h4>Social Entrepreneur of the Year — Khazanah Nasional</h4>
                    <p>Founder Tiffany Fam recognised for outstanding leadership and social impact at the national level.</p>
                    <span class="award-tag"><i class="fas fa-star"></i> Leadership</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ── LIGHBOX ── -->
<div id="vn-lightbox" onclick="closeLightbox(event)">
    <div class="lb-inner">
        <button class="lb-close" onclick="closeLightboxBtn()" title="Close (Esc)">&times;</button>
        <div class="lb-img-wrap">
            <img id="lb-img" src="" alt="">
        </div>
        <div class="lb-caption">
            <span class="lb-caption-tag">
                <i id="lb-icon"></i>
                <span id="lb-label"></span>
            </span>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="section-head centered" data-reveal>
            <div class="section-chip"><i class="fas fa-users"></i> Our Team</div>
            <h2 class="section-title">Meet The <span class="t-orange">Excellent</span> People <br> Behind <span class="t-blue">VoluNet</span></h2>
            <p class="section-sub">A passionate team of Malaysians committed to building stronger communities through technology.</p>
        </div>
        <style>
        .team-card { overflow: hidden; padding: 0 !important; }
        .team-photo {
            width: 100%; aspect-ratio: 1/1;
            overflow: hidden; display: block;
        }
        .team-photo img {
            width: 100%; height: 100%;
            object-fit: cover; object-position: center top;
            display: block;
            transition: transform 0.45s ease;
        }
        .team-card:hover .team-photo img { transform: scale(1.06); }
        .team-info {
            padding: 18px 16px 20px;
            text-align: center;
        }
        .team-info h4 { font-size: 15px; font-weight: 700; color: var(--ink); margin-bottom: 4px; }
        .team-info span { font-size: 12.5px; color: var(--ink-muted); font-weight: 500; }
        </style>

        <div class="team-grid">
            <div class="team-card" data-reveal data-d="1">
                <div class="team-photo">
                    <img src="png_vd/CEO.png" alt="Tiffany Fam — Founder & CEO">
                </div>
                <div class="team-info">
                    <h4>Tiffany Fam</h4>
                    <span>Founder &amp; CEO</span>
                </div>
            </div>
            <div class="team-card" data-reveal data-d="2">
                <div class="team-photo">
                    <img src="png_vd/Head_of_Partnerships.png" alt="Ahmad Farhan — Head of Partnerships">
                </div>
                <div class="team-info">
                    <h4>Ahmad Farhan</h4>
                    <span>Head of Partnerships</span>
                </div>
            </div>
            <div class="team-card" data-reveal data-d="3">
                <div class="team-photo">
                    <img src="png_vd/UX_and_Design_Lead.png" alt="Mei Lin Chin — UX & Design Lead">
                </div>
                <div class="team-info">
                    <h4>Mei Lin Chin</h4>
                    <span>UX &amp; Design Lead</span>
                </div>
            </div>
            <div class="team-card" data-reveal data-d="4">
                <div class="team-photo">
                    <img src="png_vd/Technology_Lead.png" alt="Rajan Kumar — Technology Lead">
                </div>
                <div class="team-info">
                    <h4>Rajan Kumar</h4>
                    <span>Technology Lead</span>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function() {
    // Timeline scroll reveal
    var targets = document.querySelectorAll('.st-event');
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry, i) {
            if (entry.isIntersecting) {
                setTimeout(function() { entry.target.classList.add('st-visible'); }, i * 80);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });
    targets.forEach(function(el) { observer.observe(el); });

    // Lightbox
    var lb      = document.getElementById('vn-lightbox');
    var lbImg   = document.getElementById('lb-img');
    var lbIcon  = document.getElementById('lb-icon');
    var lbLabel = document.getElementById('lb-label');

    window.openLightbox = function(src, label, iconClass) {
        lbImg.src            = src;
        lbImg.alt            = label;
        lbIcon.className     = iconClass;
        lbLabel.textContent  = label;
        lb.classList.add('lb-open');
        document.body.style.overflow = 'hidden';
    };

    window.closeLightbox = function(e) {
        if (e.target === lb) closeLightboxBtn();
    };

    window.closeLightboxBtn = function() {
        lb.classList.remove('lb-open');
        document.body.style.overflow = '';
        setTimeout(function() { lbImg.src = ''; }, 300);
    };

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && lb.classList.contains('lb-open')) closeLightboxBtn();
    });
})();
</script>

<style>
@media(max-width:768px){
  .mission-grid{grid-template-columns:1fr !important}
  .mission-text{align-items:flex-start !important}
  .mission-text h2{text-align:left !important}
  .mission-btns{justify-content:flex-start !important}
  .wiv-grid{grid-template-columns:1fr !important;gap:32px}
  .wiv-building-img{height:260px}
  .team-grid{grid-template-columns:repeat(2,1fr)}
  .values-grid{grid-template-columns:repeat(2,1fr)}
  .slider-slide{width:240px;height:180px}
}
@media(max-width:480px){
  .team-grid{grid-template-columns:repeat(2,1fr)}
  .values-grid{grid-template-columns:1fr}
  .wiv-building-img{height:220px}
  .wiv-headline{font-size:clamp(22px,6vw,28px)}
  .slider-slide{width:200px;height:155px}
}
</style>
<?php include 'partials/footer.php'; ?>