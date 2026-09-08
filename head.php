<!-- /partials/head.php  — include at top of every page -->
<?php if (!isset($pageTitle)) $pageTitle = 'VoluNet'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> — VoluNet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Lora:ital,wght@0,600;0,700;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --blue-50:#eff8ff;--blue-100:#dbeafe;--blue-200:#bfdbfe;--blue-300:#93c5fd;--blue-400:#60a5fa;--blue-500:#3b82f6;--blue-600:#2563eb;--blue-700:#1d4ed8;--blue-hero:#0ea5e9;
            --orange-50:#fff7ed;--orange-100:#ffedd5;--orange-400:#fb923c;--orange-500:#f97316;--orange-600:#ea580c;
            --green-50:#f0fdf4;--green-100:#dcfce7;--green-500:#22c55e;--green-600:#16a34a;--green-700:#15803d;
            --red-50:#fff1f2;--red-600:#dc2626;
            --ink:#0f1923;--ink-soft:#374151;--ink-muted:#6b7280;--ink-faint:#9ca3af;--line:#e5e7eb;--line-soft:#f3f4f6;--surface:#ffffff;--canvas:#f8faff;
            --font-display:'Lora',Georgia,serif;--font-body:'Plus Jakarta Sans',system-ui,sans-serif;
            --r-sm:8px;--r:12px;--r-lg:18px;--r-xl:24px;--r-2xl:32px;
            --shadow-xs:0 1px 2px rgba(0,0,0,.05);--shadow-sm:0 2px 8px rgba(37,99,235,.08);--shadow:0 4px 20px rgba(37,99,235,.10);--shadow-lg:0 12px 40px rgba(37,99,235,.13);--shadow-xl:0 24px 64px rgba(37,99,235,.16);--shadow-blue:0 8px 28px rgba(37,99,235,.28);--shadow-orange:0 8px 24px rgba(249,115,22,.28);
            --ease:cubic-bezier(0.4,0,0.2,1);--spring:cubic-bezier(0.34,1.56,0.64,1);
        }
        html{scroll-behavior:smooth}
        body{font-family:var(--font-body);background:var(--canvas);color:var(--ink);line-height:1.65;font-size:15px;-webkit-font-smoothing:antialiased}
        ::-webkit-scrollbar{width:5px}::-webkit-scrollbar-track{background:var(--blue-50)}::-webkit-scrollbar-thumb{background:var(--blue-400);border-radius:99px}
        .container{max-width:1240px;margin:0 auto;padding:0 24px}

        header{background:rgba(255,255,255,0.95);backdrop-filter:blur(20px) saturate(180%);border-bottom:1px solid rgba(219,234,254,0.8);position:sticky;top:0;z-index:200;transition:box-shadow 0.3s var(--ease)}
        header.scrolled{box-shadow:0 4px 20px rgba(37,99,235,.10)}
        .header-inner{display:flex;align-items:center;justify-content:space-between;height:66px;gap:16px}
        .logo{display:flex;align-items:center;gap:10px;text-decoration:none;flex-shrink:0}
        .logo-mark{width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,var(--blue-500),var(--blue-hero));display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;box-shadow:0 4px 14px rgba(14,165,233,.35);transition:transform 0.3s var(--spring)}
        .logo:hover .logo-mark{transform:rotate(-8deg) scale(1.08)}
        .logo-text{font-family:var(--font-display);font-size:21px;font-weight:700;color:var(--ink)}
        .logo-text em{font-style:normal;color:var(--green-600)}
        nav{display:flex;align-items:center;gap:2px;flex-wrap:nowrap}
        nav a{font-size:13px;font-weight:600;color:var(--ink-muted);text-decoration:none;padding:7px 11px;border-radius:var(--r-sm);transition:all 0.2s var(--ease);display:flex;align-items:center;gap:5px;white-space:nowrap}
        nav a:hover{color:var(--blue-600);background:var(--blue-50)}
        nav a.active{color:var(--blue-600);background:var(--blue-50)}
        nav a.nav-cta{background:var(--blue-600);color:#fff;margin-left:6px;padding:8px 16px;border-radius:var(--r);box-shadow:0 2px 10px rgba(37,99,235,.3)}
        nav a.nav-cta:hover{background:var(--blue-700);transform:translateY(-1px);box-shadow:var(--shadow-blue)}
        nav a.nav-danger{color:#dc2626!important}
        nav a.nav-danger:hover{background:var(--red-50)!important}
        .hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;padding:6px}
        .hamburger span{display:block;width:22px;height:2px;background:var(--ink-soft);border-radius:2px;transition:all 0.3s}
        .hamburger.open span:nth-child(1){transform:translateY(7px) rotate(45deg)}
        .hamburger.open span:nth-child(2){opacity:0;transform:scaleX(0)}
        .hamburger.open span:nth-child(3){transform:translateY(-7px) rotate(-45deg)}
        .mobile-nav{display:none;flex-direction:column;gap:2px;background:var(--surface);border-top:1px solid var(--blue-100);padding:12px 20px 16px;position:absolute;top:66px;left:0;right:0;box-shadow:var(--shadow-lg);z-index:100}
        .mobile-nav.open{display:flex}
        .mobile-nav a{padding:10px 14px;font-size:14px;color:var(--ink-soft);text-decoration:none;border-radius:var(--r-sm);font-weight:600;display:flex;align-items:center;gap:10px}
        .mobile-nav a:hover{background:var(--blue-50);color:var(--blue-600)}
        .mobile-nav a.active{background:var(--blue-50);color:var(--blue-600)}
        .mobile-nav a.mn-cta{background:var(--blue-600);color:#fff;margin-top:6px}
        .mobile-nav a.mn-cta:hover{background:var(--blue-700)}
        .mobile-nav a.mn-danger{color:#dc2626}
        .mobile-nav a.mn-danger:hover{background:var(--red-50)}

        .btn{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:var(--r);font-weight:700;font-size:14px;font-family:var(--font-body);text-decoration:none;border:none;cursor:pointer;transition:all 0.22s var(--ease);white-space:nowrap}
        .btn-lg{padding:13px 26px;font-size:15px;border-radius:var(--r-lg)}
        .btn-sm{padding:6px 14px;font-size:12.5px;border-radius:var(--r-sm)}
        .btn-xs{padding:5px 10px;font-size:12px;border-radius:6px}
        .btn-primary{background:var(--blue-600);color:#fff;box-shadow:0 3px 14px rgba(37,99,235,.3)}
        .btn-primary:hover{background:var(--blue-700);transform:translateY(-2px);box-shadow:var(--shadow-blue)}
        .btn-orange{background:var(--orange-500);color:#fff;box-shadow:0 3px 14px rgba(249,115,22,.3)}
        .btn-orange:hover{background:var(--orange-600);transform:translateY(-2px);box-shadow:var(--shadow-orange)}
        .btn-white{background:#fff;color:var(--blue-700);box-shadow:var(--shadow-sm)}
        .btn-white:hover{box-shadow:var(--shadow);transform:translateY(-1px)}
        .btn-ghost-white{background:rgba(255,255,255,.1);color:#fff;border:1.5px solid rgba(255,255,255,.2)}
        .btn-ghost-white:hover{background:rgba(255,255,255,.18)}
        .btn-secondary{background:var(--surface);color:var(--ink-soft);border:1.5px solid var(--line)}
        .btn-secondary:hover{border-color:var(--blue-400);color:var(--blue-600);background:var(--blue-50)}
        .btn-danger{background:var(--red-50);color:var(--red-600);border:1.5px solid #fecdd3}
        .btn-danger:hover{background:#fecdd3}
        .btn-dark{background:var(--ink);color:#fff}
        .btn-dark:hover{background:#1a2332;transform:translateY(-1px)}
        .btn-success{background:var(--green-50);color:var(--green-700);border:1.5px solid var(--green-100)}
        .btn-success:hover{background:var(--green-100)}

        .alert{display:flex;align-items:flex-start;gap:10px;padding:13px 16px;border-radius:var(--r);margin-bottom:20px;font-size:14px;font-weight:600}
        .alert i{font-size:15px;margin-top:1px;flex-shrink:0}
        .alert-error{background:#fff1f2;color:#be123c;border:1px solid #fecdd3}
        .alert-success{background:var(--green-50);color:var(--green-700);border:1px solid var(--green-100)}

        .form-wrap{max-width:580px;margin:0 auto}
        .form-card{background:var(--surface);border:1.5px solid var(--blue-100);border-radius:var(--r-2xl);padding:44px;box-shadow:var(--shadow-xl)}
        .form-head{text-align:center;margin-bottom:32px}
        .form-head .form-icon{width:60px;height:60px;border-radius:var(--r-lg);background:var(--blue-50);color:var(--blue-600);font-size:24px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
        .form-head h2{font-family:var(--font-display);font-size:26px;font-weight:700;color:var(--ink);margin-bottom:5px}
        .form-head p{color:var(--ink-muted);font-size:14.5px}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .form-group{margin-bottom:16px}
        .form-group label{display:block;margin-bottom:6px;font-size:12.5px;font-weight:700;color:var(--ink-soft);letter-spacing:.01em}
        .form-group label .req{color:var(--orange-500);margin-left:2px}
        .form-group input,.form-group textarea,.form-group select{width:100%;padding:10px 14px;border:1.5px solid var(--line);border-radius:var(--r);font-size:14px;font-family:var(--font-body);color:var(--ink);background:var(--canvas);transition:all 0.2s var(--ease)}
        .form-group input:focus,.form-group textarea:focus,.form-group select:focus{outline:none;border-color:var(--blue-400);box-shadow:0 0 0 3px rgba(59,130,246,.1);background:var(--surface)}
        .form-group input:disabled{background:var(--line-soft);color:var(--ink-faint);cursor:not-allowed}
        .form-group textarea{resize:vertical;min-height:110px}
        .form-hint{font-size:12px;color:var(--ink-faint);margin-top:5px}
        .checkbox-row{display:flex;align-items:center;gap:10px;margin-bottom:16px}
        .checkbox-row input[type="checkbox"]{width:17px;height:17px;accent-color:var(--blue-600);cursor:pointer}
        .checkbox-row label{font-size:14px;font-weight:600;color:var(--ink-soft);margin:0;cursor:pointer}

        .section{padding:80px 0}
        .section-alt{background:var(--surface)}
        .section-light{background:var(--blue-50)}
        .section-chip{display:inline-flex;align-items:center;gap:7px;font-size:11.5px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--orange-500);background:var(--orange-50);border:1px solid var(--orange-100);padding:5px 13px;border-radius:99px;margin-bottom:14px}
        .section-title{font-family:var(--font-display);font-size:clamp(28px,3.2vw,35px);font-weight:700;letter-spacing:-0.025em;line-height:1.15;color:var(--ink);margin-bottom:12px}
        .section-title .t-blue{color:var(--blue-600)}
        .section-title .t-orange{color:var(--orange-500)}
        .section-sub{color:var(--ink-muted);font-size:15px;line-height:1.75}
        .section-head{max-width:560px}
        .section-head.centered{text-align:center;margin:0 auto 52px;max-width:620px}
        .section-header-row{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:36px;flex-wrap:wrap;gap:16px}

        .page-band{background:linear-gradient(135deg,#01091b 20%,#0b3288 50%,#78b6d5 100%);color:#fff;padding:48px 0;position:relative;overflow:hidden}
        .page-band .container{position:relative;z-index:1}
        .page-band h1{font-family:var(--font-display);font-size:32px;font-weight:700;margin-bottom:6px;letter-spacing:-0.02em}
        .page-band p{color:rgba(255,255,255,.58);font-size:15.5px}
        .breadcrumb{display:flex;gap:8px;align-items:center;font-size:12px;color:rgba(255,255,255,.42);margin-bottom:12px}
        .breadcrumb a{color:#7dd3fc;text-decoration:none}
        .breadcrumb i{font-size:9px}

        .page-band-bubbles{position:absolute;top:0;right:0;width:55%;height:100%;pointer-events:none;overflow:hidden;z-index:0}
        .page-band-bubbles .bubble{position:absolute;border-radius:50%;animation:pbBubbleFloat linear infinite;backdrop-filter:blur(1px)}
        .page-band-bubbles .bubble:nth-child(1){width:90px;height:90px;right:8%;bottom:-100px;animation-duration:9s;animation-delay:0s;background:rgba(99,179,255,0.08);border:1.5px solid rgba(255,255,255,0.10)}
        .page-band-bubbles .bubble:nth-child(2){width:55px;height:55px;right:22%;bottom:-65px;animation-duration:11s;animation-delay:1.5s;background:rgba(255,255,255,0.05);border:1.5px solid rgba(255,255,255,0.08)}
        .page-band-bubbles .bubble:nth-child(3){width:120px;height:120px;right:35%;bottom:-140px;animation-duration:13s;animation-delay:0.8s;background:rgba(100,160,255,0.06);border:1.5px solid rgba(255,255,255,0.08)}
        .page-band-bubbles .bubble:nth-child(4){width:38px;height:38px;right:50%;bottom:-50px;animation-duration:8s;animation-delay:2s;background:rgba(255,255,255,0.07);border:1.5px solid rgba(255,255,255,0.10)}
        .page-band-bubbles .bubble:nth-child(5){width:70px;height:70px;right:14%;bottom:-80px;animation-duration:12s;animation-delay:3s;background:rgba(120,180,255,0.06);border:1.5px solid rgba(255,255,255,0.07)}
        .page-band-bubbles .bubble:nth-child(6){width:44px;height:44px;right:42%;bottom:-55px;animation-duration:10s;animation-delay:0.3s;background:rgba(255,255,255,0.04);border:1.5px solid rgba(255,255,255,0.07)}
        .page-band-bubbles .bubble:nth-child(7){width:100px;height:100px;right:28%;bottom:-115px;animation-duration:15s;animation-delay:1s;background:rgba(80,140,255,0.05);border:1.5px solid rgba(255,255,255,0.07)}
        .page-band-bubbles .bubble:nth-child(8){width:28px;height:28px;right:5%;bottom:-40px;animation-duration:7s;animation-delay:4s;background:rgba(255,255,255,0.08);border:1.5px solid rgba(255,255,255,0.12)}
        .page-band-bubbles .bubble:nth-child(9){width:62px;height:62px;right:60%;bottom:-75px;animation-duration:14s;animation-delay:2.5s;background:rgba(140,200,255,0.05);border:1.5px solid rgba(255,255,255,0.07)}
        .page-band-bubbles .bubble:nth-child(10){width:48px;height:48px;right:18%;bottom:-60px;animation-duration:10s;animation-delay:5s;background:rgba(255,255,255,0.06);border:1.5px solid rgba(255,255,255,0.09)}
        @keyframes pbBubbleFloat{0%{transform:translateY(0) scale(1);opacity:0}10%{opacity:1}90%{opacity:0.7}100%{transform:translateY(-220px) scale(1.06);opacity:0}}

        .opp-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}
        .opp-card{background:var(--surface);border:1.5px solid var(--blue-100);border-radius:var(--r-xl);overflow:hidden;transition:all 0.3s var(--ease);display:flex;flex-direction:column}
        .opp-card:hover{border-color:var(--blue-300);box-shadow:var(--shadow-lg);transform:translateY(-5px)}
        .opp-card-img{height:190px;overflow:hidden;background:var(--blue-50);position:relative;flex-shrink:0}
        .opp-card-img img{width:100%;height:100%;object-fit:cover;transition:transform 0.6s var(--ease);display:block}
        .opp-card:hover .opp-card-img img{transform:scale(1.07)}
        .opp-card-img::after{content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(15,25,35,.45) 0%,transparent 55%)}
        .opp-badge{position:absolute;top:12px;left:12px;z-index:2;font-size:11px;font-weight:700;padding:4px 11px;border-radius:99px;backdrop-filter:blur(10px);letter-spacing:.02em;display:inline-flex;align-items:center;gap:5px}
        .badge-paid{background:rgba(22,163,74,.90);color:#fff}
        .badge-unpaid{background:rgba(219,39,119,.88);color:#fff}
        .opp-card-body{padding:20px 20px 10px;flex:1;display:flex;flex-direction:column;gap:8px}
        .opp-sector{font-size:11px;font-weight:700;color:var(--orange-500);text-transform:uppercase;letter-spacing:.08em}
        .opp-title{font-size:16px;font-weight:700;color:var(--ink);line-height:1.3}
        .opp-desc{font-size:13px;color:var(--ink-muted);line-height:1.7;flex:1;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .opp-meta{display:flex;gap:12px;flex-wrap:wrap}
        .opp-meta-i{display:flex;align-items:center;gap:5px;font-size:12px;color:var(--ink-muted);font-weight:500}
        .opp-meta-i i{color:var(--blue-400);font-size:11px}
        .opp-rate{display:flex;align-items:center;gap:5px;font-size:13px;font-weight:700;color:var(--green-600)}
        .opp-rate i{color:var(--green-500)}
        .opp-card-footer{padding:0 20px 20px;margin-top:auto}
        .opp-card-footer .btn{width:100%;justify-content:center}

        .filter-bar{background:var(--surface);border:1.5px solid var(--blue-100);border-radius:var(--r-xl);padding:22px 24px;margin-bottom:28px;box-shadow:var(--shadow-sm)}
        .filter-bar form{display:flex;gap:14px;flex-wrap:wrap;align-items:flex-end}
        .filter-bar .form-group{flex:1;min-width:160px;margin-bottom:0}
        .filter-bar label{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--ink-muted);margin-bottom:6px;display:block}
        .filter-bar .filter-btns{display:flex;gap:8px;flex-shrink:0}

        .stats-strip{background:var(--surface);border-top:1px solid var(--blue-100);border-bottom:1px solid var(--blue-100)}
        .stats-inner{display:grid;grid-template-columns:repeat(4,1fr)}
        .stat-item{padding:36px 20px;text-align:center;border-right:1px solid var(--blue-100);transition:background 0.25s}
        .stat-item:hover{background:var(--blue-50)}
        .stat-item:last-child{border-right:none}
        .stat-num{font-family:var(--font-display);font-size:38px;font-weight:700;color:var(--blue-600);line-height:1;display:block;margin-bottom:6px;letter-spacing:-0.03em}
        .stat-lbl{font-size:13px;font-weight:600;color:var(--ink-muted)}

        .features-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
        .feature-card{background:var(--surface);border:1.5px solid var(--blue-100);border-radius:var(--r-xl);padding:32px 28px;transition:all 0.3s var(--ease);position:relative;overflow:hidden}
        .feature-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--blue-400),var(--blue-hero));transform:scaleX(0);transform-origin:left;transition:transform 0.3s var(--ease)}
        .feature-card:hover{border-color:var(--blue-200);box-shadow:var(--shadow-lg);transform:translateY(-4px)}
        .feature-card:hover::before{transform:scaleX(1)}
        .fi-wrap{width:50px;height:50px;border-radius:var(--r);display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:18px}
        .fi-blue{background:var(--blue-50);color:var(--blue-600)}
        .fi-orange{background:var(--orange-50);color:var(--orange-500)}
        .fi-green{background:var(--green-50);color:var(--green-600)}
        .feature-card h3{font-size:16.5px;font-weight:700;color:var(--ink);margin-bottom:9px}
        .feature-card p{font-size:13.5px;color:var(--ink-muted);line-height:1.75}
        .steps-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:24px;position:relative}
        .steps-grid::before{content:'';position:absolute;top:27px;left:12.5%;right:12.5%;height:2px;background:linear-gradient(90deg,transparent,var(--blue-200) 20%,var(--blue-200) 80%,transparent)}
        .step-card{text-align:center}
        .step-circle{width:52px;height:52px;border-radius:50%;background:var(--surface);border:2px solid var(--blue-200);display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:19px;font-weight:700;color:var(--blue-600);margin:0 auto 18px;position:relative;z-index:1;transition:all 0.3s var(--spring);box-shadow:var(--shadow-sm)}
        .step-card:hover .step-circle{background:var(--blue-600);color:#fff;border-color:var(--blue-600);transform:scale(1.1);box-shadow:var(--shadow-blue)}
        .step-card h4{font-size:14.5px;font-weight:700;color:var(--ink);margin-bottom:7px}
        .step-card p{font-size:13px;color:var(--ink-muted);line-height:1.7}

        .testi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
        .testi-card{background:var(--surface);border:1.5px solid var(--blue-100);border-radius:var(--r-xl);padding:28px;transition:all 0.3s var(--ease);display:flex;flex-direction:column;gap:14px}
        .testi-card:hover{box-shadow:var(--shadow-lg);transform:translateY(-3px);border-color:var(--blue-200)}
        .testi-stars{display:flex;gap:3px}
        .testi-stars i{color:var(--orange-400);font-size:12px}
        .testi-q{font-family:var(--font-display);font-size:15.5px;font-style:italic;color:var(--ink-soft);line-height:1.65;flex:1}
        .testi-foot{display:flex;align-items:center;gap:12px;padding-top:14px;border-top:1px solid var(--blue-100)}
        .testi-av{width:42px;height:42px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;font-size:15px}
        .testi-name{font-size:13.5px;font-weight:700;color:var(--ink)}
        .testi-role{font-size:11.5px;color:var(--ink-muted)}

        .table-wrap{background:var(--surface);border:1.5px solid var(--blue-100);border-radius:var(--r-xl);overflow:hidden;box-shadow:var(--shadow-sm)}
        table{width:100%;border-collapse:collapse}
        thead tr{background:var(--blue-50);border-bottom:1.5px solid var(--blue-100)}
        th{padding:13px 18px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--blue-600);white-space:nowrap}
        td{padding:16px 18px;border-bottom:1px solid var(--line-soft);font-size:13.5px;color:var(--ink-soft);vertical-align:middle}
        tbody tr:last-child td{border-bottom:none}
        tbody tr{transition:background 0.15s}
        tbody tr:hover{background:var(--blue-50)}
        .td-actions{display:flex;gap:6px;align-items:center;flex-wrap:wrap}

        .status-pill{display:inline-flex;align-items:center;gap:5px;font-size:11.5px;font-weight:700;padding:4px 10px;border-radius:99px}
        .status-pill.dot::before{content:'●';font-size:7px}
        .status-pending{background:var(--orange-50);color:var(--orange-600)}
        .status-approved{background:var(--green-50);color:var(--green-700)}
        .status-rejected{background:#fff1f2;color:#be123c}
        .status-active{background:var(--green-50);color:var(--green-700)}
        .status-inactive{background:var(--line-soft);color:var(--ink-muted)}
        .pill{display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:600;padding:4px 11px;border-radius:99px;background:var(--blue-50);color:var(--blue-700)}

        .detail-wrap{max-width:820px;margin:0 auto}
        .detail-card{background:var(--surface);border:1.5px solid var(--blue-100);border-radius:var(--r-2xl);overflow:hidden;box-shadow:var(--shadow-xl)}
        .detail-img-wrap{position:relative}
        .detail-hero-img{width:100%;height:360px;object-fit:cover;display:block}
        .detail-img-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(15,25,35,.45) 0%,transparent 50%)}
        .detail-body{padding:40px 44px}
        .detail-title{font-family:var(--font-display);font-size:30px;font-weight:700;color:var(--ink);line-height:1.2;margin-bottom:20px;letter-spacing:-0.02em}
        .detail-meta{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:32px}
        .detail-sec{margin-bottom:32px}
        .detail-sec h3{font-size:11px;font-weight:700;color:var(--ink-muted);text-transform:uppercase;letter-spacing:.1em;margin-bottom:12px;display:flex;align-items:center;gap:7px}
        .detail-sec p{color:var(--ink-soft);line-height:1.8}
        .skills-wrap{display:flex;flex-wrap:wrap;gap:7px}
        .skill-chip{background:var(--blue-50);color:var(--blue-700);padding:5px 14px;border-radius:99px;font-size:12.5px;font-weight:600;border:1px solid var(--blue-100)}

        .empty-state{text-align:center;padding:72px 24px;background:var(--surface);border:1.5px solid var(--blue-100);border-radius:var(--r-2xl)}
        .empty-icon{font-size:48px;margin-bottom:18px;color:var(--blue-300)}
        .empty-state h3{font-family:var(--font-display);font-size:22px;font-weight:700;color:var(--ink);margin-bottom:9px}
        .empty-state p{color:var(--ink-muted);margin-bottom:24px;font-size:14.5px;max-width:380px;margin-left:auto;margin-right:auto}

        .profile-header{background:linear-gradient(135deg,#0c1a3a,#1e40af);border-radius:var(--r-2xl);padding:38px;display:flex;align-items:center;gap:22px;margin-bottom:28px;position:relative;overflow:hidden}
        .profile-header::after{content:'';position:absolute;right:-40px;top:-40px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.05)}
        .profile-avatar{width:76px;height:76px;border-radius:50%;flex-shrink:0;background:rgba(255,255,255,.14);display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:30px;font-weight:700;color:#fff;border:3px solid rgba(255,255,255,.22)}
        .profile-header h2{font-family:var(--font-display);font-size:22px;font-weight:700;color:#fff}
        .profile-header p{color:rgba(255,255,255,.58);font-size:13.5px;margin-top:3px}

        .admin-tabs{display:flex;gap:4px;margin-bottom:28px;background:var(--surface);border:1.5px solid var(--blue-100);border-radius:var(--r-lg);padding:6px;width:fit-content}
        .admin-tab{padding:9px 20px;border-radius:var(--r);font-size:13.5px;font-weight:700;color:var(--ink-muted);cursor:pointer;transition:all 0.2s;border:none;background:none;font-family:var(--font-body)}
        .admin-tab.active{background:var(--blue-600);color:#fff;box-shadow:0 2px 10px rgba(37,99,235,.3)}
        .admin-panel{display:none}
        .admin-panel.active{display:block}
        .admin-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px}
        .admin-stat{background:var(--surface);border:1.5px solid var(--blue-100);border-radius:var(--r-xl);padding:22px;display:flex;align-items:center;gap:16px}
        .admin-stat-icon{width:48px;height:48px;border-radius:var(--r);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0}
        .admin-stat-num{font-family:var(--font-display);font-size:28px;font-weight:700;color:var(--ink);line-height:1}
        .admin-stat-lbl{font-size:12px;color:var(--ink-muted);font-weight:600;margin-top:3px}

        .cta-block{background:linear-gradient(135deg,#01091b 20%,#0b3288 50%,#78b6d5 100%);border-radius:var(--r-2xl);padding:56px;display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap;position:relative;overflow:hidden}
        .cta-block h2{font-family:var(--font-display);font-size:28px;font-weight:700;color:#fff;margin-bottom:9px;position:relative;z-index:1}
        .cta-block p{color:rgba(255,255,255,.62);font-size:15.5px;max-width:440px;position:relative;z-index:1}
        .cta-actions{display:flex;gap:12px;flex-shrink:0;flex-wrap:wrap;position:relative;z-index:1}

        .res-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px}
        .res-card{background:var(--surface);border:1.5px solid var(--blue-100);border-radius:var(--r-xl);padding:28px;transition:all 0.3s var(--ease)}
        .res-card:hover{border-color:var(--blue-300);box-shadow:var(--shadow-lg);transform:translateY(-3px)}
        .res-badge{display:inline-flex;align-items:center;gap:6px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;padding:4px 11px;border-radius:99px;margin-bottom:14px}
        .rb-course{background:var(--blue-50);color:var(--blue-600)}
        .rb-tutorial{background:#fdf4ff;color:#7c3aed}
        .rb-cert{background:var(--orange-50);color:var(--orange-600)}
        .res-card h3{font-size:15.5px;font-weight:700;color:var(--ink);margin-bottom:8px}
        .res-card p{font-size:13.5px;color:var(--ink-muted);line-height:1.7;margin-bottom:18px}

        .mission-grid{text-align:right;display:grid;grid-template-columns:1fr 1fr;gap:52px;align-items:center}
        .mission-text{display:flex;flex-direction:column;align-items:flex-end}
        .mission-text h2{text-align:right;font-family:var(--font-display);font-size:clamp(28px,3.2vw,35px);font-weight:700;letter-spacing:-0.025em;line-height:1.15;color:var(--ink);margin-bottom:14px}
        .mission-text p{text-align:justify;color:var(--ink-muted);font-size:15px;line-height:1.8;margin-bottom:14px}
        .mission-btns{display:flex;gap:12px;justify-content:flex-end;flex-wrap:wrap;margin-top:6px}
        .mission-img{border-radius:var(--r-xl);overflow:hidden;box-shadow:var(--shadow-xl);position:relative}
        .mission-img img{width:100%;display:block}
        .mission-img-badge{position:absolute;bottom:16px;left:16px;right:16px;background:rgba(255,255,255,.94);border-radius:var(--r);padding:12px 16px;backdrop-filter:blur(10px);display:flex;align-items:center;gap:10px}
        .mib-icon{font-size:22px}
        .mib-text strong{display:block;font-size:13.5px;font-weight:700;color:var(--ink)}
        .mib-text span{font-size:12px;color:var(--ink-muted)}
        .values-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
        .value-card{background:var(--surface);border:1.5px solid var(--blue-100);border-radius:var(--r-xl);padding:30px 26px;text-align:center;transition:all 0.3s var(--ease)}
        .value-card:hover{border-color:var(--blue-300);box-shadow:var(--shadow-lg);transform:translateY(-3px)}
        .value-icon{width:60px;height:60px;border-radius:var(--r-lg);display:flex;align-items:center;justify-content:center;font-size:24px;margin:0 auto 16px}
        .vi-blue{background:var(--blue-50);color:var(--blue-600)}
        .vi-orange{background:var(--orange-50);color:var(--orange-500)}
        .vi-green{background:var(--green-50);color:var(--green-600)}
        .value-card h3{font-size:16px;font-weight:700;color:var(--ink);margin-bottom:8px}
        .value-card p{font-size:13.5px;color:var(--ink-muted);line-height:1.7}
        .team-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
        .team-card{background:var(--surface);border:1.5px solid var(--blue-100);border-radius:var(--r-xl);padding:26px 20px;text-align:center;transition:all 0.3s var(--ease)}
        .team-card:hover{border-color:var(--blue-300);box-shadow:var(--shadow-lg);transform:translateY(-3px)}
        .team-avatar{width:68px;height:68px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:26px;color:#fff;margin:0 auto 12px;border:3px solid var(--blue-100)}
        .team-card h4{font-size:14.5px;font-weight:700;color:var(--ink);margin-bottom:4px}
        .team-card span{font-size:12px;color:var(--ink-muted);font-weight:500}

        .sdg8-section{padding:60px 0;background:linear-gradient(135deg,#ffffff 0%,#f8faff 100%)}
        .sdg8-grid{display:grid;grid-template-columns:.8fr 1.2fr;gap:40px;align-items:center}
        .sdg8-image-wrapper{position:relative;text-align:center}
        .sdg8-image{width:100%;max-width:280px;display:block;margin:0 auto;border-radius:var(--r-lg);box-shadow:0 20px 40px rgba(0,0,0,.08);transition:transform 0.3s ease}
        .sdg8-image:hover{transform:scale(1.02)}
        .sdg8-image-badge{margin-top:16px;display:inline-flex;align-items:center;gap:6px;background:var(--orange-50);padding:6px 16px;border-radius:99px;font-size:12px;font-weight:600;color:var(--orange-600);border:1px solid #fed7aa}
        .sdg8-chip{display:inline-flex;align-items:center;gap:8px;font-size:11px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--orange-500);background:var(--orange-50);border:1px solid var(--orange-100);padding:5px 12px;border-radius:99px;margin-bottom:12px}
        .sdg8-title{font-family:var(--font-display);font-size:clamp(20px,5.5vw,32px);font-weight:700;line-height:1.2;margin-bottom:16px;color:var(--ink)}
        .sdg8-title .t-orange{color:var(--orange-500)}
        .sdg8-text{font-size:15px;color:var(--ink-muted);line-height:1.6;margin-bottom:12px;text-align:justify}
        .sdg8-text strong{color:var(--ink-soft);font-weight:700}
        .sdg8-impact{display:flex;gap:20px;margin:20px 0 0;flex-wrap:wrap}
        .sdg8-impact-item{display:flex;align-items:center;gap:8px;background:var(--surface);padding:8px 14px;border-radius:99px;border:1px solid var(--orange-100);box-shadow:0 2px 8px rgba(249,115,22,.05)}
        .sdg8-impact-item i{color:var(--orange-500);font-size:14px}
        .sdg8-impact-item span{font-size:13px;color:var(--ink-soft);font-weight:500}
        .sdg8-impact-item strong{color:var(--orange-600);font-weight:700;margin-right:3px}

        .modal-overlay{display:none;position:fixed;inset:0;z-index:500;background:rgba(12,26,58,.6);backdrop-filter:blur(6px);align-items:center;justify-content:center;padding:20px}
        .modal-overlay.open{display:flex}
        .modal-box{background:var(--surface);border-radius:var(--r-2xl);width:100%;max-width:520px;box-shadow:var(--shadow-xl);overflow:hidden;animation:modalIn 0.26s var(--spring)}
        @keyframes modalIn{from{opacity:0;transform:scale(.93) translateY(14px)}to{opacity:1;transform:none}}
        .modal-head{background:linear-gradient(135deg,#01091b 20%,#0b3288 50%,#78b6d5 100%);color:#fff;padding:26px 30px;position:relative}
        .modal-head h2{font-family:var(--font-display);font-size:20px;font-weight:700}
        .modal-head p{font-size:13.5px;color:rgba(255,255,255,.58);margin-top:4px}
        .modal-close{position:absolute;top:16px;right:16px;width:30px;height:30px;border-radius:var(--r-sm);background:rgba(255,255,255,.13);color:#fff;border:none;cursor:pointer;font-size:15px;display:flex;align-items:center;justify-content:center;transition:background 0.2s}
        .modal-close:hover{background:rgba(255,255,255,.22)}
        .modal-body{padding:30px}
        .modal-box.danger .modal-head{background:linear-gradient(135deg,#7f1d1d,#dc2626)}
        .delete-warning{text-align:center;padding:8px 0 16px}
        .delete-warning .dw-icon{font-size:44px;color:var(--red-600);margin-bottom:12px}
        .delete-warning h3{font-family:var(--font-display);font-size:20px;font-weight:700;color:var(--ink);margin-bottom:8px}
        .delete-warning p{color:var(--ink-muted);font-size:14px;line-height:1.6}
        .delete-actions{display:flex;gap:10px;margin-top:20px}
        .delete-actions .btn{flex:1;justify-content:center}

        .agency-video{position:relative;width:100%;overflow:hidden;background-color:#000}
        .video-frame{position:relative;width:100%;height:auto;overflow:hidden;border-radius:8px}
        .video-frame video{width:100%;height:100%;object-fit:cover;border-radius:8px}
        .video-blob{position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.39);border-radius:8px;pointer-events:none}

        .divider{height:1px;background:var(--blue-100);margin:28px 0}
        #backToTop{display:none;position:fixed;bottom:24px;right:24px;z-index:300;width:42px;height:42px;border-radius:var(--r);background:var(--blue-600);color:#fff;border:none;cursor:pointer;font-size:14px;box-shadow:var(--shadow-blue);transition:all 0.3s var(--spring)}
        #backToTop:hover{background:var(--blue-700);transform:translateY(-3px)}
        #backToTop.visible{display:flex;align-items:center;justify-content:center}
        #pageLoader{display:none;position:fixed;inset:0;z-index:9999;background:rgba(248,250,255,.9);backdrop-filter:blur(8px);align-items:center;justify-content:center;flex-direction:column;gap:14px}
        #pageLoader.visible{display:flex}
        .loader-ring{width:38px;height:38px;border:3px solid var(--blue-100);border-top-color:var(--blue-600);border-radius:50%;animation:spin .75s linear infinite}
        @keyframes spin{to{transform:rotate(360deg)}}

        [data-reveal]{opacity:0;transform:translateY(20px);transition:opacity 0.5s var(--ease),transform 0.5s var(--ease)}
        [data-reveal].revealed{opacity:1;transform:none}
        [data-reveal][data-d="1"]{transition-delay:.07s}
        [data-reveal][data-d="2"]{transition-delay:.14s}
        [data-reveal][data-d="3"]{transition-delay:.21s}
        [data-reveal][data-d="4"]{transition-delay:.28s}
        .hero-enter{animation:heroIn .8s var(--ease) both}
        .hero-enter-1{animation:heroIn .8s .15s var(--ease) both}
        .hero-enter-2{animation:heroIn .8s .28s var(--ease) both}
        @keyframes heroIn{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:none}}

        .hero{position:relative;overflow:hidden;background:linear-gradient(135deg,#01091b 20%,#0b3288 50%,#78b6d5 100%);color:#fff;min-height:80vh;display:flex;align-items:center;justify-content:center}
        .hero-bg{position:absolute;inset:0;z-index:0;background:radial-gradient(ellipse 70% 80% at 15% 50%,rgba(14,165,233,.28) 0%,transparent 65%),radial-gradient(ellipse 50% 60% at 85% 20%,rgba(59,130,246,.22) 0%,transparent 55%),radial-gradient(ellipse 40% 50% at 70% 85%,rgba(96,165,250,.12) 0%,transparent 50%)}
        .hero-circle,.hero-circle-2{position:absolute;z-index:1;border-radius:50%;border:1px solid rgba(255,255,255,.05)}
        .hero-circle{right:-100px;top:-100px;width:700px;height:700px}
        .hero-circle-2{right:60px;top:60px;width:480px;height:480px}
        .hero-content{position:relative;z-index:10;display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;width:100%;padding:50px 20px;max-width:1200px}
        .hero-content>div{display:flex;flex-direction:column;align-items:flex-start}
        .hero-chip{display:inline-flex;align-items:center;gap:8px;font-size:11.5px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:#7dd3fc;background:rgba(125,211,252,.1);border:1px solid rgba(125,211,252,.22);padding:6px 14px;border-radius:99px;margin-bottom:20px}
        .hero h1{font-family:var(--font-display);font-size:clamp(36px,4.5vw,60px);font-weight:700;line-height:1;letter-spacing:-.025em;margin-bottom:20px;color:#fff}
        .hero h1 .accent{color:var(--orange-400);position:relative;display:inline-block}
        .hero h1 .accent::after{content:'';position:absolute;bottom:-3px;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--orange-100),var(--orange-600));border-radius:2px;animation:lineGrow 1s .7s both}
        @keyframes lineGrow{from{transform:scaleX(0);transform-origin:left}to{transform:scaleX(1)}}
        .hero-lead{font-size:13px;color:rgba(255,255,255,.65);line-height:1.75;margin-bottom:36px;max-width:480px}
        .hero-btns{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:40px;align-self:flex-start;margin-left:0}
        .avatar-row{display:flex;align-items:center;gap:12px}
        .av-stack{display:flex}
        .av-item{width:30px;height:30px;border-radius:50%;border:2.5px solid rgba(255,255,255,.18);margin-left:-9px;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff}
        .av-item:first-child{margin-left:0}
        .av-a{background:linear-gradient(135deg,#3b82f6,#8b5cf6)}
        .av-b{background:linear-gradient(135deg,#10b981,#059669)}
        .av-c{background:linear-gradient(135deg,#f97316,#ef4444)}
        .av-d{background:linear-gradient(135deg,#ec4899,#8b5cf6)}
        .av-label{font-size:13px;color:rgba(255,255,255,.62)}
        .av-label strong{color:#fff}
        .hero-cards{position:relative;height:380px;display:flex;justify-content:space-between}
        .h-card{position:absolute;border-radius:var(--r-lg);background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.13);backdrop-filter:blur(16px);padding:18px 20px;animation:floatY 4s ease-in-out infinite}
        .h-card:nth-child(1){top:0;left:0;width:256px;animation-delay:0s}
        .h-card:nth-child(2){top:140px;right:0;width:220px;animation-delay:-1.8s}
        .h-card:nth-child(3){bottom:0;left:24px;width:240px;animation-delay:-3.2s}
        @keyframes floatY{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
        .hc-chip{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:rgba(255,255,255,.42);margin-bottom:5px}
        .hc-title{font-size:14.5px;font-weight:700;color:#fff;margin-bottom:5px;line-height:1.3}
        .hc-meta{font-size:12px;color:rgba(255,255,255,.48);display:flex;align-items:center;gap:5px}
        .hc-badge{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:700;padding:4px 10px;border-radius:99px;margin-top:10px}
        .hc-paid{background:rgba(34,197,94,.18);color:#86efac;border:1px solid rgba(34,197,94,.25)}
        .hc-vol{background:rgba(239,68,68,.18);color:#fca5a5;border:1px solid rgba(239,68,68,.25)}

        footer{background:#0c1a3a;color:rgba(255,255,255,.42);padding:64px 0 32px;position:relative;overflow:hidden}
        footer::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--blue-600),var(--blue-hero),var(--orange-400))}
        .footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:48px;margin-bottom:48px}
        .footer-brand p{font-size:13.5px;line-height:1.75;margin-top:12px;max-width:240px}
        .footer-col h4{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.72);margin-bottom:16px}
        .footer-col ul{list-style:none;display:flex;flex-direction:column;gap:9px}
        .footer-col ul li a{font-size:13.5px;color:rgba(255,255,255,.4);text-decoration:none;transition:color 0.2s;display:flex;align-items:center;gap:7px}
        .footer-col ul li a:hover{color:rgba(255,255,255,.86)}
        .footer-col ul li a i{font-size:11px;color:var(--blue-400)}
        .footer-bottom{border-top:1px solid rgba(255,255,255,.07);padding-top:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px}
        .footer-bottom p{font-size:12.5px}
        .social-links{display:flex;gap:8px}
        .social-links a{width:40px;height:40px;border-radius:var(--r-sm);background:rgba(255,255,255,.06);color:rgba(255,255,255,.42);font-size:13px;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all 0.2s;border:1px solid rgba(255,255,255,.08)}
        .social-links a:hover{background:var(--blue-600);color:#fff;border-color:var(--blue-600);transform:translateY(-2px)}


        @media(max-width:1100px){
            .opp-grid{grid-template-columns:repeat(2,1fr)}
            .res-grid{grid-template-columns:repeat(2,1fr)}
            .features-grid{grid-template-columns:repeat(2,1fr)}
            .testi-grid{grid-template-columns:repeat(2,1fr)}
            .trust-pillars{grid-template-columns:repeat(2,1fr)}
        }

        @media(max-width:1024px){
            .hero-content{grid-template-columns:1fr}
            .hero-cards{display:none}
            .hero-btns{align-self:auto;margin-left:0}
            .stats-inner{grid-template-columns:repeat(2,1fr)}
            .stat-item:nth-child(2){border-right:none}
            .footer-grid{grid-template-columns:1fr 1fr;gap:32px}
            .steps-grid{grid-template-columns:repeat(2,1fr)}
            .steps-grid::before{display:none}
            .mission-grid{grid-template-columns:1fr}
            .mission-text{align-items:flex-start}
            .mission-text h2{text-align:left}
            .mission-btns{justify-content:flex-start}
            .team-grid{grid-template-columns:repeat(2,1fr)}
            .values-grid{grid-template-columns:repeat(2,1fr)}
            .admin-stats{grid-template-columns:repeat(2,1fr)}
            .sdg8-grid{grid-template-columns:1fr;gap:30px}
            .sdg8-image-wrapper{text-align:center}
            .sdg8-image{max-width:220px}
            .profile-stats-row{grid-template-columns:repeat(2,1fr)}
        }

        @media(max-width:768px){
            .container{padding:0 16px}
            .section{padding:52px 0}
            .page-band{padding:32px 0}
            .page-band h1{font-size:clamp(20px,5vw,26px)}
            .page-band p{font-size:14px}

            nav{display:none}
            .hamburger{display:flex}

            .features-grid,.testi-grid,.values-grid,
            .admin-stats:not(.res-summary-strip),
            .res-grid,.opp-grid{grid-template-columns:1fr}

            .trust-pillars{grid-template-columns:1fr}

            .form-card{padding:28px 20px}
            .form-row{grid-template-columns:1fr}
            .form-wrap{max-width:100%}

            .filter-bar{padding:18px}
            .filter-bar form{flex-direction:column;gap:10px}
            .filter-bar .form-group{min-width:100%;width:100%}
            .filter-bar .filter-btns{width:100%;flex-direction:row}
            .filter-bar .filter-btns .btn{flex:1;justify-content:center;min-height:44px}

            .btn{min-height:44px}
            nav a,
            .mobile-nav a{min-height:44px}

            .table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch}
            table{min-width:600px}
            .td-actions{flex-wrap:nowrap}

            .detail-hero-img{height:240px}
            .detail-body{padding:24px 20px}
            .detail-meta{gap:6px;flex-wrap:wrap}
            .detail-meta .pill{font-size:11px;padding:3px 9px}
            .detail-title{font-size:clamp(18px,4vw,26px)}
            .detail-wrap{padding:0}

            .profile-header{flex-direction:column;text-align:center;padding:28px 20px}
            .profile-avatar-wrap{margin:0 auto}
            .avatar-btns{justify-content:center}
            .profile-stats-row{grid-template-columns:repeat(2,1fr)}

            .cta-block{padding:36px 24px;flex-direction:column}
            .cta-actions{width:100%}
            .cta-actions .btn{flex:1;justify-content:center;text-align:center}

            .footer-grid{grid-template-columns:1fr;gap:28px}

            .admin-tabs{width:100%;overflow-x:auto;flex-wrap:nowrap;-webkit-overflow-scrolling:touch}
            .admin-stats:not(.res-summary-strip){grid-template-columns:1fr 1fr}

            #panel-add>div{max-width:100% !important}

            .res-summary-strip{grid-template-columns:repeat(2,1fr) !important;max-width:520px;margin-left:auto !important;margin-right:auto !important}

            .hero{min-height:auto;padding:60px 0 40px}
            .hero-btns{align-self:auto;margin-left:0}

            .sdg8-grid{grid-template-columns:1fr;text-align:center}
            .sdg8-image-wrapper{text-align:center}
            .sdg8-image{max-width:200px}
            .sdg8-impact{justify-content:center}
            .sdg8-text{text-align:left}

            .section-header-row{flex-direction:column;align-items:flex-start;gap:12px}
        }

        @media(max-width:480px){
            .section{padding:40px 0}
            .container{padding:0 14px}

            .stats-inner{grid-template-columns:1fr}
            .stat-item{border-right:none;border-bottom:1px solid var(--blue-100)}
            .stat-item:last-child{border-bottom:none}

            .steps-grid{grid-template-columns:1fr}

            .team-grid{grid-template-columns:repeat(2,1fr)}

            .hero-btns{flex-direction:column;align-self:auto;margin-left:0}
            .hero-btns .btn{width:100%;justify-content:center}
            .hero-chip{font-size:11px}
            .hero-lead{font-size:13px}

            .mission-text h2{font-size:clamp(22px,6vw,28px)}

            .opp-card-img{height:160px}
            .opp-sector{font-size:10.5px}
            .opp-title{font-size:14.5px}

            .form-card{padding:22px 16px}
            .form-head h2{font-size:20px}
            .form-head p{font-size:13px}

            .modal-overlay{padding:12px}
            .modal-box{margin:0;border-radius:16px;max-height:90vh;overflow-y:auto}
            .modal-head{padding:20px 18px}
            .modal-body{padding:18px}

            .detail-body{padding:18px 16px}
            .detail-hero-img{height:200px}
            .skills-wrap{gap:6px}
            .skill-chip{font-size:12px;padding:4px 10px}

            .delete-actions{flex-direction:column}
            .delete-actions .btn{width:100%;justify-content:center}

            .footer-grid{grid-template-columns:1fr}
            .footer-bottom{flex-direction:column;text-align:center;gap:12px}
            .footer-brand p{max-width:100%}

            .admin-tabs .admin-tab{padding:8px 12px;font-size:12px;white-space:nowrap}
            .admin-stats:not(.res-summary-strip){grid-template-columns:1fr}

            .filter-bar{padding:14px}

            .section-title{font-size:clamp(20px,5vw,26px)}
            .hero h1{font-size:clamp(28px,8vw,42px)}

            .res-summary-strip{grid-template-columns:repeat(2,1fr) !important;max-width:420px;margin-left:auto !important;margin-right:auto !important}

            .profile-stats-row{grid-template-columns:repeat(2,1fr)}
            .hours-breakdown{margin-left:0;width:100%}
            .hours-inner{flex-direction:column;align-items:flex-start;gap:12px}

            .alert{font-size:13px}

            .detail-meta{gap:5px}
        }

        @media(max-width:360px){
            .team-grid{grid-template-columns:1fr}
            .profile-stats-row{grid-template-columns:repeat(2,1fr)}
            .avatar-btns{flex-direction:column}
            .btn-avatar-action{width:100%;justify-content:center}
            .opp-meta{flex-direction:column;gap:6px}
            .hero-btns .btn{font-size:13px}
        }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var bands = document.querySelectorAll('.page-band');
        var bubbleHTML = '<div class="page-band-bubbles">'
            + '<div class="bubble"></div>'
            + '<div class="bubble"></div>'
            + '<div class="bubble"></div>'
            + '<div class="bubble"></div>'
            + '<div class="bubble"></div>'
            + '<div class="bubble"></div>'
            + '<div class="bubble"></div>'
            + '<div class="bubble"></div>'
            + '<div class="bubble"></div>'
            + '<div class="bubble"></div>'
            + '</div>';
        bands.forEach(function (band) {
            band.insertAdjacentHTML('afterbegin', bubbleHTML);
        });
    });
    </script>
</head>
<body>