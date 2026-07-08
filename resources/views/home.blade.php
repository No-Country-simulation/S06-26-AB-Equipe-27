<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillFocus | Recrutamento sem viés, orientado por competências</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ==========================================================
           SKILLFOCUS — DESIGN TOKENS
           Idênticos a jobs, dashboard, reports, login e register.
        ========================================================== */
        :root {
            --color-primary: #7C3AED;
            --color-primary-dark: #5B21B6;
            --color-primary-hover: #6D28D9;
            --color-primary-soft: #F3EEFE;
            --color-primary-softer: #FBFAFF;

            --color-shield: #0D9488;
            --color-shield-soft: #E8F8F6;
            --color-shield-warn: #B45309;
            --color-shield-warn-soft: #FEF6E7;

            --color-ink: #17152A;
            --color-body: #47435C;
            --color-muted: #77738F;
            --color-border: #E9E5F3;
            --color-surface: #FFFFFF;
            --color-bg: #FAF9FD;

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            --radius-xl: 28px;
            --shadow-card: 0 1px 2px rgba(23,21,42,.04), 0 10px 28px -14px rgba(23,21,42,.14);
            --shadow-card-hover: 0 18px 36px -14px rgba(124,58,237,.28);
            --shadow-pop: 0 12px 32px -8px rgba(23,21,42,.16);

            --font-display: 'Sora', 'Inter', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        * { -webkit-font-smoothing: antialiased; }
        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-body);
            color: var(--color-body);
            background-color: var(--color-surface);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .font-display { font-family: var(--font-display); }
        a { text-decoration: none; }

        ::selection { background-color: var(--color-primary-soft); color: var(--color-primary-dark); }

        /* ==========================================================
           NAVBAR
        ========================================================== */
        .navbar {
            background-color: rgba(255,255,255,.85);
            backdrop-filter: saturate(180%) blur(14px);
            -webkit-backdrop-filter: saturate(180%) blur(14px);
            border-bottom: 1px solid transparent;
            transition: border-color .2s ease;
            padding: 0.9rem 0;
        }

        .navbar.is-scrolled { border-bottom-color: var(--color-border); }

        .navbar-brand {
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--color-ink) !important;
            font-size: 1.2rem;
            letter-spacing: -0.01em;
            display: flex;
            align-items: center;
        }

        .brand-icon {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            border-radius: 9px;
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 1.05rem;
            box-shadow: 0 4px 10px -3px rgba(124,58,237,.55);
        }

        .nav-link {
            color: var(--color-body) !important;
            font-weight: 600;
            font-size: 0.9rem;
            margin-left: 0.5rem;
            padding: 0.5rem 0.9rem !important;
            border-radius: 999px;
            transition: color .18s ease, background-color .18s ease;
        }

        .nav-link:hover { color: var(--color-ink) !important; background-color: var(--color-primary-softer); }

        .nav-link.nav-cta {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff !important;
            box-shadow: 0 8px 18px -8px rgba(124,58,237,.55);
            margin-left: 0.9rem;
        }
        .nav-link.nav-cta:hover { color: #fff !important; box-shadow: 0 10px 20px -8px rgba(124,58,237,.65); }

        .navbar-toggler { border: none; box-shadow: none !important; }

        /* ==========================================================
           HERO
        ========================================================== */
        .hero {
            position: relative;
            padding: 7.5rem 0 6rem;
            background:
                radial-gradient(circle at 12% 20%, rgba(124,58,237,.5), transparent 42%),
                radial-gradient(circle at 88% 78%, rgba(13,148,136,.4), transparent 45%),
                linear-gradient(165deg, var(--color-ink) 0%, #241F3D 55%, #1B1830 100%);
            color: #fff;
            overflow: hidden;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,.07) 1px, transparent 1px);
            background-size: 24px 24px;
            mask-image: radial-gradient(ellipse 80% 60% at 50% 30%, black 40%, transparent 80%);
            pointer-events: none;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.16);
            color: #C4B5FD;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 0.45rem 1rem;
            border-radius: 999px;
            margin-bottom: 1.5rem;
        }

        .hero-eyebrow .dot {
            width: 6px; height: 6px; border-radius: 50%;
            background-color: #5EEAD4;
            box-shadow: 0 0 0 0 rgba(94,234,212,.6);
            animation: pulse-dot 1.8s infinite;
        }
        @keyframes pulse-dot {
            0% { box-shadow: 0 0 0 0 rgba(94,234,212,.55); }
            70% { box-shadow: 0 0 0 7px rgba(94,234,212,0); }
            100% { box-shadow: 0 0 0 0 rgba(94,234,212,0); }
        }

        .hero h1 {
            font-weight: 800;
            font-size: clamp(2.2rem, 4.2vw, 3.4rem);
            letter-spacing: -0.03em;
            line-height: 1.12;
            margin-bottom: 1.4rem;
        }

        .hero h1 .accent { color: #C4B5FD; }

        .hero .lede {
            font-size: 1.1rem;
            color: #D6D3E6;
            line-height: 1.65;
            max-width: 480px;
            margin-bottom: 2.1rem;
        }

        .hero-cta { display: flex; flex-wrap: wrap; gap: 0.85rem; margin-bottom: 2.5rem; }

        .btn-hero-primary {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.85rem 1.65rem;
            border-radius: var(--radius-sm);
            box-shadow: 0 12px 26px -10px rgba(124,58,237,.7);
            transition: transform .15s ease, box-shadow .15s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-hero-primary:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 16px 30px -10px rgba(124,58,237,.8); }

        .btn-hero-ghost {
            background-color: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.2);
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.85rem 1.5rem;
            border-radius: var(--radius-sm);
            transition: background-color .15s ease, border-color .15s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-hero-ghost:hover { color: #fff; background-color: rgba(255,255,255,.12); border-color: rgba(255,255,255,.35); }

        .hero-trust {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            color: #B7B2CF;
            font-size: 0.83rem;
        }
        .hero-trust i { color: #5EEAD4; }

        /* ---- Mockup flutuante do Bias Shield no hero ---- */
        .hero-visual { position: relative; min-height: 380px; }

        .mock-card {
            position: absolute;
            background-color: rgba(255,255,255,.06);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,.14);
            border-radius: var(--radius-lg);
            box-shadow: 0 25px 50px -20px rgba(0,0,0,.5);
            padding: 1.4rem;
            color: #fff;
        }

        .mock-card-main {
            width: 100%;
            max-width: 340px;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .mock-card-main .mock-title {
            font-size: 0.78rem;
            color: #B7B2CF;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.9rem;
        }

        .mock-job-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .mock-job-row:last-child { border-bottom: none; }

        .mock-job-row .job-name { font-size: 0.87rem; font-weight: 600; }
        .mock-job-row .job-sub { font-size: 0.74rem; color: #B7B2CF; }

        .mock-shield-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.74rem;
            font-weight: 700;
            padding: 0.25rem 0.6rem;
            border-radius: 999px;
        }
        .mock-shield-pill.high { background-color: rgba(94,234,212,.16); color: #5EEAD4; }
        .mock-shield-pill.mid { background-color: rgba(251,191,110,.18); color: #FBBF6E; }

        .mock-card-float {
            width: 168px;
            bottom: 10px;
            right: -10px;
            text-align: center;
        }

        .mock-card-float .mini-ring {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            margin: 0 auto 0.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: conic-gradient(#5EEAD4 306deg, rgba(255,255,255,.14) 0deg);
        }

        .mock-card-float .mini-ring-inner {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background-color: #1B1830;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.15rem;
        }

        .mock-card-float .mini-caption {
            font-size: 0.74rem;
            color: #D6D3E6;
            line-height: 1.4;
        }

        @media (max-width: 991.98px) {
            .hero-visual { min-height: 300px; margin-top: 1rem; }
            .mock-card-main { max-width: 300px; }
        }

        /* ==========================================================
           SEÇÕES GERAIS
        ========================================================== */
        .section-pad { padding: 5.5rem 0; }

        .subtitle-badge {
            color: var(--color-primary);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.8rem;
            display: inline-block;
            margin-bottom: 0.75rem;
        }

        .subtitle-badge.is-shield { color: var(--color-shield); }

        .section-title {
            color: var(--color-ink);
            font-weight: 700;
            font-size: clamp(1.7rem, 2.6vw, 2.3rem);
            margin-bottom: 1.1rem;
            letter-spacing: -0.02em;
        }

        .section-text {
            color: var(--color-muted);
            font-size: 1.05rem;
            line-height: 1.7;
            margin-bottom: 1.75rem;
        }

        /* ---- Como funciona ---- */
        .steps-strip { background-color: var(--color-bg); }

        .step-card {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 2rem 1.75rem;
            height: 100%;
            position: relative;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .step-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-card-hover); }

        .step-number {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 0.8rem;
            color: var(--color-primary);
            background-color: var(--color-primary-soft);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
        }

        .step-card h4 {
            font-size: 1.08rem;
            font-weight: 700;
            color: var(--color-ink);
            margin-bottom: 0.6rem;
        }

        .step-card p {
            font-size: 0.92rem;
            color: var(--color-muted);
            line-height: 1.6;
            margin: 0;
        }

        /* ---- Bloco de competências (ícone/gauge) ---- */
        .feature-visual-box {
            border-radius: var(--radius-xl);
            background: linear-gradient(155deg, var(--color-primary-soft), var(--color-shield-soft));
            border: 1px solid var(--color-border);
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 1.1rem;
        }

        .feature-visual-box .ring-demo {
            width: 132px;
            height: 132px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: conic-gradient(var(--color-primary) 295deg, var(--color-border) 0deg);
        }

        .feature-visual-box .ring-demo-inner {
            width: 104px;
            height: 104px;
            border-radius: 50%;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .ring-demo-inner .ring-value {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.65rem;
            color: var(--color-ink);
            line-height: 1;
        }

        .ring-demo-inner .ring-max { font-size: 0.68rem; color: var(--color-muted); margin-top: 0.1rem; }

        .feature-visual-box .ring-caption {
            font-size: 0.85rem;
            color: var(--color-body);
            font-weight: 600;
        }

        .feature-visual-box .ring-subcaption { font-size: 0.78rem; color: var(--color-muted); }

        .btn-section-link {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            border-radius: var(--radius-sm);
            font-weight: 600;
            padding: 0.75rem 1.6rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 10px 22px -10px rgba(124,58,237,.6);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .btn-section-link:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 14px 26px -10px rgba(124,58,237,.7); }

        /* ---- Imagem + lista de benefícios ---- */
        .img-box {
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--color-border);
        }
        .img-box img {
            width: 100%;
            height: 380px;
            object-fit: cover;
            display: block;
            transition: transform .5s ease;
        }
        .img-box:hover img { transform: scale(1.03); }

        .benefit-list { list-style: none; padding: 0; margin: 0 0 2rem; display: flex; flex-direction: column; gap: 1.1rem; }

        .benefit-list li { display: flex; align-items: flex-start; gap: 0.85rem; }

        .benefit-list .feat-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background-color: var(--color-shield-soft);
            color: var(--color-shield);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.95rem;
        }

        .benefit-list .feat-text strong {
            display: block;
            color: var(--color-ink);
            font-size: 0.95rem;
            margin-bottom: 0.1rem;
        }
        .benefit-list .feat-text span { font-size: 0.86rem; color: var(--color-muted); }

        /* ==========================================================
           CTA + LOGIN
        ========================================================== */
        .cta-section {
            background:
                radial-gradient(circle at 90% 10%, rgba(124,58,237,.06), transparent 45%),
                var(--color-bg);
        }

        .cta-login-panel {
            background-color: var(--color-ink);
            background-image: radial-gradient(circle at 20% 20%, rgba(124,58,237,.45), transparent 45%),
                               radial-gradient(circle at 85% 85%, rgba(13,148,136,.35), transparent 50%);
            padding: 3.5rem 3rem;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .cta-login-panel h2 { font-size: clamp(1.8rem, 3vw, 2.4rem); font-weight: 700; letter-spacing: -0.02em; margin-bottom: 0.9rem; }
        .cta-login-panel .lede { color: #D6D3E6; font-size: 1.05rem; }

        .login-box {
            background: var(--color-surface);
            border-radius: var(--radius-lg);
            padding: 2.25rem;
            box-shadow: var(--shadow-pop);
        }

        .login-box h3 {
            color: var(--color-ink);
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 1.4rem;
        }

        .field-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--color-ink);
            margin-bottom: 0.4rem;
            display: block;
        }

        .input-group-custom {
            background-color: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            padding: 0 0.9rem;
            margin-bottom: 1.1rem;
            transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
        }
        .input-group-custom:focus-within {
            border-color: var(--color-primary);
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(124,58,237,.12);
        }
        .input-group-custom i { color: var(--color-primary); font-size: 1rem; }
        .input-group-custom input {
            border: none; background: transparent; padding: 0.75rem 0.7rem; width: 100%;
            outline: none; color: var(--color-ink); font-size: 0.92rem;
        }
        .input-group-custom input::placeholder { color: #ACA8C2; }

        .alert-soft-danger {
            background-color: #FDEEEE;
            border: 1px solid #F6D4D4;
            color: #B42318;
            border-radius: var(--radius-sm);
            padding: 0.8rem 1rem;
            font-size: 0.83rem;
            margin-bottom: 1.1rem;
        }

        .btn-submit {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: 0.85rem;
            font-size: 0.95rem;
            font-weight: 600;
            width: 100%;
            box-shadow: 0 10px 22px -10px rgba(124,58,237,.6);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .btn-submit:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 14px 26px -10px rgba(124,58,237,.7); }

        .login-box .signup-hint { text-align: center; font-size: 0.85rem; color: var(--color-muted); margin-top: 1.1rem; }
        .login-box .signup-hint a { color: var(--color-primary); font-weight: 700; }
        .login-box .signup-hint a:hover { color: var(--color-primary-hover); text-decoration: underline; }

        /* ==========================================================
           FOOTER
        ========================================================== */
        footer {
            background-color: var(--color-ink);
            color: #B7B2CF;
            padding: 3.5rem 0 1.75rem;
            font-size: 0.88rem;
        }

        footer .footer-brand {
            display: flex;
            align-items: center;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.1rem;
            color: #fff;
            margin-bottom: 0.9rem;
        }

        footer p.footer-lede { max-width: 320px; line-height: 1.6; color: #9C97B5; }

        footer h6 {
            color: #fff;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1.1rem;
        }

        footer ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.65rem; }
        footer ul a { color: #B7B2CF; transition: color .15s ease; }
        footer ul a:hover { color: #fff; }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,.1);
            margin-top: 2.75rem;
            padding-top: 1.5rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 0.75rem;
            font-size: 0.8rem;
            color: #8D88A6;
        }

        .footer-bottom .shield-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: #5EEAD4;
            font-weight: 600;
        }

        @media (max-width: 767.98px) {
            .cta-login-panel { padding: 2.25rem 1.5rem; }
        }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg sticky-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <span class="brand-icon"><i class="bi bi-graph-up-arrow"></i></span>
                Skill<span style="color: var(--color-primary);">Focus</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link active" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Entrar</a></li>
                    <li class="nav-item"><a class="nav-link nav-cta" href="{{ url('/register') }}">Criar conta</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <header class="hero">
        <div class="container position-relative">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="hero-eyebrow"><span class="dot"></span> Recrutamento sem viés</span>
                    <h1>Contrate por <span class="accent">competência</span>, não por semelhança.</h1>
                    <p class="lede">O SkillFocus usa dados para mapear talentos, reduzir viés inconsciente e mostrar — vaga a vaga — o quanto sua triagem está sendo justa.</p>

                    <div class="hero-cta">
                        <a href="{{ url('/register') }}" class="btn-hero-primary">
                            Começar agora <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="#como-funciona" class="btn-hero-ghost">
                            <i class="bi bi-play-circle"></i> Ver como funciona
                        </a>
                    </div>

                    <div class="hero-trust">
                        <i class="bi bi-lock-fill"></i> Dados de candidatos protegidos, sempre.
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="hero-visual">
                        <div class="mock-card mock-card-main">
                            <div class="mock-title">Vagas com Bias Shield ativo</div>

                            <div class="mock-job-row">
                                <div>
                                    <div class="job-name">Analista de Dados Pleno</div>
                                    <div class="job-sub">São Paulo, SP</div>
                                </div>
                                <span class="mock-shield-pill high"><i class="bi bi-shield-check"></i> 92%</span>
                            </div>
                            <div class="mock-job-row">
                                <div>
                                    <div class="job-name">UX Designer Sênior</div>
                                    <div class="job-sub">Remoto</div>
                                </div>
                                <span class="mock-shield-pill high"><i class="bi bi-shield-check"></i> 87%</span>
                            </div>
                            <div class="mock-job-row">
                                <div>
                                    <div class="job-name">Coordenador Comercial</div>
                                    <div class="job-sub">Belo Horizonte, MG</div>
                                </div>
                                <span class="mock-shield-pill mid"><i class="bi bi-shield-exclamation"></i> 74%</span>
                            </div>
                        </div>

                        <div class="mock-card mock-card-float">
                            <div class="mini-ring">
                                <div class="mini-ring-inner">85</div>
                            </div>
                            <div class="mini-caption">Pontuação Diversity da sua empresa</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- COMO FUNCIONA --}}
    <section class="section-pad steps-strip" id="como-funciona">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 620px;">
                <span class="subtitle-badge">Do zero à contratação</span>
                <h2 class="section-title">Como o SkillFocus funciona</h2>
                <p class="section-text mb-0">Três passos entre publicar uma vaga e enxergar, com clareza, a equidade do seu processo seletivo.</p>
            </div>

            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <h4>Publique a vaga</h4>
                        <p>Descreva o cargo, nível e competências desejadas — sem depender de critérios subjetivos de "fit cultural".</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <h4>A IA mapeia competências</h4>
                        <p>Candidatos são avaliados pelo que sabem fazer, cruzando dados de forma consistente para todos os perfis.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <h4>Acompanhe o Bias Shield</h4>
                        <p>Cada vaga recebe uma pontuação de equidade em tempo real, junto com métricas de diversidade do processo.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- COMPETÊNCIAS --}}
    <section class="section-pad">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="subtitle-badge">Inteligência aplicada</span>
                    <h2 class="section-title">Contrate com base em competências</h2>
                    <p class="section-text">
                        O SkillFocus interpreta dados de currículos e vagas para gerar recomendações objetivas — reduzindo o peso de vieses inconscientes que costumam definir quem chega à entrevista.
                    </p>
                    <a href="{{ url('/register') }}" class="btn-section-link">
                        Começar agora <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="col-lg-6">
                    <div class="feature-visual-box">
                        <div class="ring-demo">
                            <div class="ring-demo-inner">
                                <span class="ring-value">82</span>
                                <span class="ring-max">de 100</span>
                            </div>
                        </div>
                        <div class="ring-caption">Exemplo de Pontuação Diversity</div>
                        <div class="ring-subcaption">Calculada automaticamente a cada novo processo seletivo</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA + LOGIN --}}
    <section class="cta-login-panel section-pad cta-section">
        <div class="container">
            <div class="">
                <div class="row align-items-center g-5">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h2>Aqui você contrata sem viés.</h2>
                        <p class="lede mb-0">Processos mais justos, inteligentes e eficientes — desde a primeira vaga publicada.</p>
                    </div>

                    <div class="col-lg-6">
                        <div class="login-box">
                            <h3>Entrar na plataforma</h3>

                            @if ($errors->any())
                            <div class="alert-soft-danger">
                                @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                                @endforeach
                            </div>
                            @endif

                            <form method="POST" action="/login">
                                @csrf

                                <label class="field-label" for="home_email">E-mail</label>
                                <div class="input-group-custom">
                                    <i class="bi bi-envelope"></i>
                                    <input type="email" id="home_email" name="email" placeholder="Seu e-mail cadastrado" required>
                                </div>

                                <label class="field-label" for="home_password">Senha</label>
                                <div class="input-group-custom">
                                    <i class="bi bi-key"></i>
                                    <input type="password" id="home_password" name="password" placeholder="Sua senha de acesso" required>
                                </div>

                                <button type="submit" class="btn-submit">Entrar</button>
                            </form>

                            <p class="signup-hint">Ainda não tem conta? <a href="{{ url('/register') }}">Criar agora</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BIAS SHIELD / BENEFÍCIOS --}}
    <section class="section-pad" style="background-color: var(--color-bg);" id="bias-shield">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="img-box">
                        <img src="https://cdn.pixabay.com/photo/2018/03/10/12/00/teamwork-3213924_1280.jpg" alt="Equipe diversa colaborando">
                    </div>
                </div>

                <div class="col-lg-6 order-1 order-lg-2">
                    <span class="subtitle-badge is-shield">Decisões mais justas</span>
                    <h2 class="section-title">Para recrutadores e empresas que levam diversidade a sério</h2>
                    <p class="section-text mb-4">
                        Mais do que um selo, o Bias Shield é um acompanhamento contínuo: cada vaga aberta ganha visibilidade real sobre quem está sendo alcançado — e onde ainda há espaço pra melhorar.
                    </p>

                    <ul class="benefit-list">
                        <li>
                            <span class="feat-icon"><i class="bi bi-shield-check"></i></span>
                            <span class="feat-text"><strong>Pontuação por vaga</strong><span>Cada processo seletivo recebe seu próprio índice de equidade.</span></span>
                        </li>
                        <li>
                            <span class="feat-icon"><i class="bi bi-graph-up"></i></span>
                            <span class="feat-text"><strong>Métricas acompanhadas de perto</strong><span>Painéis mostram a evolução da diversidade ao longo do tempo.</span></span>
                        </li>
                        <li>
                            <span class="feat-icon"><i class="bi bi-lock"></i></span>
                            <span class="feat-text"><strong>Dados protegidos</strong><span>Informações de candidatos tratadas com o devido cuidado.</span></span>
                        </li>
                    </ul>

                    <a href="{{ url('/register') }}" class="btn-section-link">
                        Conhecer o Bias Shield <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-lg-4">
                    <div class="footer-brand">
                        <span class="brand-icon"><i class="bi bi-graph-up-arrow"></i></span>
                        Skill<span style="color: #C4B5FD;">Focus</span>
                    </div>
                    <p class="footer-lede">Potencializando a diversidade através da tecnologia corporativa — uma vaga de cada vez.</p>
                </div>

                <div class="col-6 col-lg-2 offset-lg-2">
                    <h6>Produto</h6>
                    <ul>
                        <li><a href="#como-funciona">Como funciona</a></li>
                        <li><a href="#bias-shield">Bias Shield</a></li>
                        <li><a href="{{ url('/register') }}">Criar conta</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h6>Conta</h6>
                    <ul>
                        <li><a href="{{ url('/login') }}">Entrar</a></li>
                        <li><a href="{{ url('/register') }}">Cadastro</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h6>Legal</h6>
                    <ul>
                        <li><a href="#">Termos de Serviço</a></li>
                        <li><a href="#">Privacidade</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <span>&copy; 2026 SkillFocus. Todos os direitos reservados.</span>
                <span class="shield-pill"><i class="bi bi-lock-fill"></i> Dados protegidos · Bias Shield ativo</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sombra sutil na navbar só depois de rolar a página — mantém o
        // hero limpo no topo sem perder a separação visual ao navegar.
        const nav = document.getElementById('mainNavbar');
        window.addEventListener('scroll', function () {
            nav.classList.toggle('is-scrolled', window.scrollY > 12);
        });
    </script>
</body>
</html>
