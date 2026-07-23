<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Candidato | SkillFocus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* ==========================================================
           SKILLFOCUS — DESIGN TOKENS
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
            --color-danger: #DC2626;
            --color-danger-soft: #FDEDEC;
            
            --color-info: #0284C7;
            --color-info-soft: #E0F2FE;

            --color-ink: #17152A;
            --color-body: #47435C;
            --color-muted: #77738F;
            --color-border: #E9E5F3;
            --color-surface: #FFFFFF;
            --color-bg: #FAF9FD;

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            --shadow-card: 0 1px 2px rgba(23,21,42,.04), 0 10px 28px -14px rgba(23,21,42,.14);
            --shadow-card-hover: 0 18px 36px -14px rgba(124,58,237,.28);
            --shadow-pop: 0 12px 32px -8px rgba(23,21,42,.16);

            --font-display: 'Sora', 'Inter', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        * { -webkit-font-smoothing: antialiased; }
        html, body { height: 100%; }

        body {
            font-family: var(--font-body);
            background-color: var(--color-bg);
            background-image:
                radial-gradient(circle at 100% 0%, rgba(124,58,237,.06), transparent 45%),
                radial-gradient(circle at 0% 20%, rgba(13,148,136,.045), transparent 40%);
            background-attachment: fixed;
            color: var(--color-body);
            overflow-x: hidden;
        }

        h1, h2, h3, .font-display { font-family: var(--font-display); }
        a { text-decoration: none; }

        /* ==========================================================
           NAVBAR
        ========================================================== */
        .navbar {
            background-color: rgba(255,255,255,.85);
            backdrop-filter: saturate(180%) blur(14px);
            -webkit-backdrop-filter: saturate(180%) blur(14px);
            border-bottom: 1px solid var(--color-border);
        }

        .navbar-brand {
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--color-ink);
            font-size: 1.15rem;
            letter-spacing: -0.01em;
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

        .navbar-collapse { gap: 1.5rem; }

        @media (min-width: 992px) {
            .navbar-collapse { align-items: center; justify-content: flex-end; }
        }

        .nav-link-custom {
            color: var(--color-muted);
            font-weight: 600;
            font-size: 0.88rem;
            padding: 0.55rem 1.05rem !important;
            border-radius: 999px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background-color .18s ease, color .18s ease;
            white-space: nowrap;
        }

        .nav-link-custom:hover { color: var(--color-ink); background-color: var(--color-primary-softer); }

        .nav-link-custom.active {
            background-color: var(--color-primary);
            color: #fff;
            box-shadow: 0 6px 14px -6px rgba(124,58,237,.55);
        }

        .navbar-actions { display: flex; align-items: center; gap: 0.9rem; flex-shrink: 0; }

        .navbar-toggler {
            width: 36px; height: 36px;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 10px;
            background-color: var(--color-primary-softer);
        }
        
        .avatar-badge {
            width: 36px; height: 36px;
            border-radius: 100%;
            background: linear-gradient(155deg, var(--color-shield), #0F766E);
            color: #fff;
            font-weight: 700;
            font-size: 0.8rem;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 10px -3px rgba(13,148,136,.55);
        }

        .dropdown-menu {
            border: 1px solid var(--color-border);
            box-shadow: var(--shadow-pop);
            border-radius: var(--radius-sm);
        }

        /* ---------------- Page header ---------------- */
        .page-heading .eyebrow {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--color-primary);
        }
        .page-heading h1 { font-size: 1.85rem; font-weight: 700; color: var(--color-ink); letter-spacing: -0.02em; }
        .page-heading p { color: var(--color-muted); font-size: 0.95rem; }

        /* ---------------- Base de card ---------------- */
        .dash-card {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 1.5rem;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        /* ---------------- Alerta de perfil incompleto ---------------- */
        .setup-alert {
            background-color: var(--color-info-soft);
            border: 1px solid rgba(2,132,199,.22);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 1.35rem 1.5rem;
        }

        .setup-alert .icon-wrap {
            width: 52px; height: 52px;
            border-radius: 15px;
            background-color: #fff;
            color: var(--color-info);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            box-shadow: var(--shadow-card);
        }

        .setup-alert h3 { font-size: 1.05rem; font-weight: 700; color: var(--color-ink); }
        .setup-alert p { color: var(--color-body); font-size: 0.9rem; margin: 0; }

        .btn-setup {
            background: linear-gradient(155deg, var(--color-info), #0369A1);
            color: #fff;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 0.65rem 1.4rem;
            border-radius: var(--radius-sm);
            white-space: nowrap;
            box-shadow: 0 10px 22px -10px rgba(2,132,199,.55);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .btn-setup:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 14px 26px -10px rgba(2,132,199,.65); }

        /* ---------------- Cards de ação rápida ---------------- */
        .action-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-shield));
            opacity: 0;
            transition: opacity .2s ease;
        }

        .action-card:hover {
            box-shadow: var(--shadow-card-hover);
            transform: translateY(-3px);
            border-color: rgba(124,58,237,.25);
        }
        .action-card:hover::before { opacity: 1; }

        .action-card h3 { font-family: var(--font-display); font-size: 1.02rem; font-weight: 600; color: var(--color-ink); margin: 0; }
        .action-card p { font-size: 0.85rem; color: var(--color-muted); margin: 0.2rem 0 0; }

        .action-card .arrow-hint {
            margin-left: auto;
            color: var(--color-border);
            font-size: 1.1rem;
            transition: color .18s ease, transform .18s ease;
        }
        .action-card:hover .arrow-hint { color: var(--color-primary); transform: translateX(3px); }

        .icon-box {
            width: 54px; height: 54px;
            border-radius: 15px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
        .icon-box-sm { width: 44px; height: 44px; border-radius: 12px; font-size: 1.15rem; }

        .icon-purple { background-color: var(--color-primary-soft); color: var(--color-primary); }
        .icon-blue   { background-color: var(--color-info-soft);    color: var(--color-info); }
        .icon-green  { background-color: var(--color-shield-soft);  color: var(--color-shield); }
        .icon-amber  { background-color: var(--color-shield-warn-soft); color: var(--color-shield-warn); }

        /* ---------------- Cabeçalho padrão de widget ---------------- */
        .widget-header {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            margin-bottom: 1.25rem;
        }
        .widget-header h3 {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--color-ink);
            margin: 0;
        }
        .widget-header p {
            font-size: 0.8rem;
            color: var(--color-muted);
            margin: 0.1rem 0 0;
        }

        /* ---------------- Força do Perfil ---------------- */
        .score-card { text-align: center; display: flex; flex-direction: column; }
        .score-value {
            font-family: var(--font-display);
            font-size: 3.1rem;
            font-weight: 800;
            color: var(--color-shield);
            line-height: 1;
        }
        .score-max { font-size: 1.3rem; color: #C9C5DC; font-weight: 700; }
        .score-track {
            background-color: var(--color-shield-soft);
            border-radius: 999px;
            height: 10px;
            overflow: hidden;
            margin: 1rem 0 0.75rem;
        }
        .score-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--color-shield), #0F766E);
        }
        .score-caption { font-size: 0.85rem; color: var(--color-primary); font-weight: 700; }

        /* ---------------- Minhas Habilidades ---------------- */
        .skills-list { display: flex; flex-direction: column; gap: 0.6rem; }
        .skill-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.65rem 0.85rem;
            background-color: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
        }
        .skill-label { font-weight: 600; font-size: 0.85rem; color: var(--color-ink); }
        .skill-level {
            font-size: 0.68rem;
            font-weight: 700;
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
            text-transform: uppercase;
        }
        .level-expert { background-color: var(--color-primary-soft); color: var(--color-primary-dark); }
        .level-advanced { background-color: var(--color-info-soft); color: var(--color-info); }
        .level-intermediate { background-color: var(--color-shield-soft); color: var(--color-shield); }
        
        .empty-mini { text-align: center; color: var(--color-muted); font-size: 0.85rem; padding: 1.5rem 0; }

        /* ---------------- Tabela de Candidaturas ---------------- */
        .table-widget { padding: 1.5rem 1.5rem 0.5rem; }
        .table-skillfocus-wrap { overflow-x: auto; border-radius: var(--radius-md); border: 1px solid var(--color-border); }

        .table-skillfocus { width: 100%; border-collapse: collapse; margin: 0; }
        .table-skillfocus thead th {
            background-color: var(--color-primary-softer);
            color: var(--color-muted);
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-weight: 700;
            border: none;
            padding: 0.9rem 1.1rem;
            text-align: left;
        }
        .table-skillfocus thead th:last-child { text-align: right; }
        .table-skillfocus tbody td {
            padding: 0.9rem 1.1rem;
            border-top: 1px solid var(--color-border);
            font-size: 0.87rem;
            color: var(--color-body);
            vertical-align: middle;
        }
        .table-skillfocus tbody tr:hover { background-color: var(--color-primary-softer); }

        .job-title-chip {
            background-color: var(--color-primary-soft);
            color: var(--color-primary-dark);
            font-weight: 600;
            font-size: 0.83rem;
            padding: 0.35rem 0.85rem;
            border-radius: var(--radius-sm);
            display: inline-block;
        }
        
        .company-name {
            font-weight: 600;
            color: var(--color-ink);
        }

        .badge-status {
            font-weight: 700;
            font-size: 0.72rem;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .status-applied { background-color: var(--color-shield-warn-soft); color: var(--color-shield-warn); }
        .status-review { background-color: var(--color-info-soft); color: var(--color-info); }
        .status-interview { background-color: var(--color-primary-soft); color: var(--color-primary-dark); }
        .status-approved { background-color: var(--color-shield-soft); color: var(--color-shield); }

        .btn-action {
            width: 34px; height: 34px;
            border-radius: 10px;
            background-color: var(--color-bg);
            color: var(--color-muted);
            display: inline-flex; align-items: center; justify-content: center;
            border: 1px solid var(--color-border);
            transition: all .15s ease;
        }
        .btn-action:hover { background-color: var(--color-primary); color: #fff; border-color: var(--color-primary); }

        /* ---------------- Recomendação de IA ---------------- */
        .ai-card { text-align: center; display: flex; flex-direction: column; justify-content: space-between; height: 100%; }
        .ai-value { font-family: var(--font-display); font-size: 2.6rem; font-weight: 800; color: var(--color-primary); line-height: 1; }
        .ai-caption { font-size: 0.85rem; color: var(--color-muted); font-weight: 600; margin: 0.35rem 0 1.35rem; }
        .ai-jobs-box {
            background-color: var(--color-primary-soft);
            border: 1px solid rgba(124,58,237,.16);
            border-radius: var(--radius-md);
            padding: 1rem;
            text-align: left;
        }
        .ai-jobs-title { font-size: 0.82rem; font-weight: 700; color: var(--color-primary-dark); margin-bottom: 0.7rem; text-align: center;}
        
        .match-job {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            padding: 0.6rem 0.8rem;
            border-radius: var(--radius-sm);
            margin-bottom: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .match-job:last-child { margin-bottom: 0; }
        .match-job-info strong { display: block; font-size: 0.8rem; color: var(--color-ink); }
        .match-job-info span { font-size: 0.72rem; color: var(--color-muted); }
        .match-percentage { font-weight: 800; color: var(--color-shield); font-size: 0.85rem; }

        /* ---------------- Footer ---------------- */
        footer { border-top: 1px solid var(--color-border); color: var(--color-muted); font-size: 0.78rem; }
        footer .shield-pill { display: inline-flex; align-items: center; gap: 0.4rem; color: var(--color-shield); font-weight: 600; }
        
        /* Ocultar scrollbar de listas curtas */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background-color: var(--color-border); border-radius: 999px; }
    </style>
</head>
<body>

    {{-- NAVBAR SUPERIOR --}}
    <nav class="navbar navbar-expand-lg sticky-top py-2">
        <div class="container px-4">

            <a class="navbar-brand d-flex align-items-center" href="{{ url('/candidato/dashboard') }}">
                <span class="brand-icon"><i class="bi bi-person-bounding-box"></i></span>
                Skill<span style="color: var(--color-primary);">Focus</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-1 text-primary"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav flex-lg-row gap-lg-1 gap-1">
                    <li class="nav-item">
                        <a class="nav-link-custom active" href="{{ url('/candidato/dashboard') }}">
                            <i class="bi bi-grid-1x2"></i> Meu Painel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ url('/vagas') }}">
                            <i class="bi bi-search"></i> Buscar Vagas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ url('/candidato/candidaturas') }}">
                            <i class="bi bi-briefcase"></i> Minhas Candidaturas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ url('/candidato/perfil') }}">
                            <i class="bi bi-person-vcard"></i> Meu Perfil
                        </a>
                    </li>
                </ul>

                <div class="navbar-actions">
                    <div class="dropdown">
                        <div class="avatar-badge" role="button" data-bs-toggle="dropdown">
                            {{ substr(Auth::user()->name ?? 'C', 0, 1) }}
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end mt-2">
                            <li><a class="dropdown-item py-2" href="{{ url('/candidato/perfil') }}"><i class="bi bi-person-fill me-2 text-muted"></i>Editar Perfil</a></li>
                            <li><a class="dropdown-item py-2" href="{{ url('/candidato/testes') }}"><i class="bi bi-patch-check-fill me-2 text-muted"></i>Meus Testes</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </nav>

    {{-- CONTEÚDO PRINCIPAL --}}
    <main class="container my-5">

        <div class="page-heading mb-4">
            <div class="eyebrow mb-2">Área do Candidato</div>
            <h1 class="mb-1">Olá, {{ explode(' ', Auth::user()->name ?? 'Candidato')[0] }}!</h1>
            <p class="mb-0">Acompanhe suas candidaturas e o desempenho do seu perfil no mercado.</p>
        </div>

        {{-- Alerta de perfil incompleto --}}
        @if((Auth::user()->profile_completion ?? 0) < 100)
        <div class="setup-alert d-flex flex-column flex-md-row align-items-md-center gap-3 mb-4">
            <div class="icon-wrap flex-shrink-0">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <div class="flex-grow-1">
                <h3 class="mb-1">Potencialize suas chances</h3>
                <p>Seu perfil está {{ Auth::user()->profile_completion ?? 60 }}% completo. Preencha suas experiências para que nossa IA encontre as melhores vagas para você de forma anônima.</p>
            </div>
            <a href="{{ url('/candidato/perfil/editar') }}" class="btn-setup text-center flex-shrink-0">Completar Perfil</a>
        </div>
        @endif

        {{-- Cards de ação rápida --}}
        <div class="row g-4 mb-4">
            <div class="col-12 col-md-4">
                <a href="{{ url('/vagas') }}" class="dash-card action-card">
                    <div class="icon-box icon-purple"><i class="bi bi-search"></i></div>
                    <div>
                        <h3>Explorar Vagas</h3>
                        <p>Descubra novas oportunidades</p>
                    </div>
                    <i class="bi bi-arrow-right arrow-hint"></i>
                </a>
            </div>

            <div class="col-12 col-md-4">
                <a href="{{ url('/candidato/testes') }}" class="dash-card action-card">
                    <div class="icon-box icon-blue"><i class="bi bi-controller"></i></div>
                    <div>
                        <h3>Testes de Skills</h3>
                        <p>Comprove suas habilidades</p>
                    </div>
                    <i class="bi bi-arrow-right arrow-hint"></i>
                </a>
            </div>

            <div class="col-12 col-md-4">
                <a href="{{ url('/candidato/curriculo/exportar') }}" class="dash-card action-card">
                    <div class="icon-box icon-green"><i class="bi bi-file-earmark-arrow-down-fill"></i></div>
                    <div>
                        <h3>Baixar Currículo</h3>
                        <p>Exportar PDF SkillFocus</p>
                    </div>
                    <i class="bi bi-arrow-right arrow-hint"></i>
                </a>
            </div>
        </div>

        {{-- Score, Habilidades e Match --}}
        <div class="row g-4 mb-4 align-items-stretch">

            {{-- Força do Perfil --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="dash-card h-100 score-card">
                    <div class="widget-header">
                        <div class="icon-box icon-box-sm icon-green"><i class="bi bi-lightning-charge-fill"></i></div>
                        <div>
                            <h3>Força do Perfil</h3>
                            <p>Completude e relevância</p>
                        </div>
                    </div>
                    <div class="flex-grow-1 d-flex flex-column justify-content-center">
                        @php $profileScore = Auth::user()->profile_completion ?? 85; @endphp
                        <div>
                            <span class="score-value">{{ $profileScore }}</span><span class="score-max">%</span>
                        </div>
                        <div class="score-track">
                            <div class="score-fill" style="width: {{ $profileScore }}%"></div>
                        </div>
                        <span class="score-caption">
                            @if($profileScore >= 90)
                                Perfil Campeão!
                            @elseif($profileScore >= 70)
                                Muito Bom!
                            @else
                                Precisa de melhorias
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Minhas Habilidades em Destaque --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="dash-card h-100">
                    <div class="widget-header">
                        <div class="icon-box icon-box-sm icon-blue"><i class="bi bi-stars"></i></div>
                        <div>
                            <h3>Minhas Habilidades</h3>
                            <p>Principais tags do seu perfil</p>
                        </div>
                    </div>

                    <div class="skills-list">
                        @php
                            $skills = Auth::user()->top_skills ?? [
                                ['name' => 'Liderança', 'level' => 'Avançado', 'class' => 'level-advanced'],
                                ['name' => 'Gestão Ágil', 'level' => 'Especialista', 'class' => 'level-expert'],
                                ['name' => 'Inglês', 'level' => 'Intermediário', 'class' => 'level-intermediate'],
                                ['name' => 'Python', 'level' => 'Avançado', 'class' => 'level-advanced'],
                            ];
                        @endphp
                        
                        @forelse($skills as $skill)
                        <div class="skill-row">
                            <span class="skill-label">{{ $skill['name'] }}</span>
                            <span class="skill-level {{ $skill['class'] ?? 'level-intermediate' }}">
                                {{ $skill['level'] }}
                            </span>
                        </div>
                        @empty
                            <div class="empty-mini">Nenhuma habilidade cadastrada</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Match de Vagas (IA) --}}
            <div class="col-12 col-lg-4">
                <div class="dash-card ai-card">
                    <div>
                        <div class="widget-header justify-content-center">
                            <div class="icon-box icon-box-sm icon-purple"><i class="bi bi-robot"></i></div>
                            <div>
                                <h3>Radar SkillFocus</h3>
                            </div>
                        </div>
                        <div class="ai-value">{{ $newMatchesCount ?? 12 }}</div>
                        <p class="ai-caption">novas vagas com alto fit cultural e técnico</p>

                        <div class="ai-jobs-box">
                            <div class="ai-jobs-title">Sugestões para você</div>
                            
                            @php
                                $suggestedJobs = $suggestedJobs ?? [
                                    ['title' => 'Dev Frontend Pleno', 'company' => 'TechCorp', 'match' => '94%'],
                                    ['title' => 'Tech Lead', 'company' => 'Inova S.A.', 'match' => '88%']
                                ];
                            @endphp

                            @foreach($suggestedJobs as $job)
                            <div class="match-job">
                                <div class="match-job-info">
                                    <strong>{{ $job['title'] }}</strong>
                                    <span>{{ $job['company'] }}</span>
                                </div>
                                <div class="match-percentage">{{ $job['match'] }}</div>
                            </div>
                            @endforeach
                            
                            <div class="text-center mt-2">
                                <a href="{{ url('/vagas/recomendadas') }}" class="text-decoration-none" style="font-size:0.75rem; font-weight:700; color:var(--color-primary-dark);">Ver todas as recomendações <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabela de Candidaturas --}}
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="dash-card table-widget h-100">
                    <div class="widget-header">
                        <div class="icon-box icon-box-sm icon-amber"><i class="bi bi-file-person-fill"></i></div>
                        <div>
                            <h3>Processos Seletivos em Andamento</h3>
                            <p>Acompanhe o status das suas candidaturas ativas</p>
                        </div>
                    </div>

                    <div class="table-skillfocus-wrap mb-4">
                        <table class="table-skillfocus">
                            <thead>
                                <tr>
                                    <th>Vaga</th>
                                    <th>Empresa</th>
                                    <th>Data de Aplicação</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $applications = $applications ?? [
                                        ['title' => 'Product Manager', 'company' => 'FinTech Brasil', 'date' => '12 Mai 2026', 'status' => 'Em Análise', 'class' => 'status-review', 'icon' => 'bi-search'],
                                        ['title' => 'Engenheiro de Dados', 'company' => 'Global Systems', 'date' => '08 Mai 2026', 'status' => 'Entrevista', 'class' => 'status-interview', 'icon' => 'bi-camera-video-fill'],
                                        ['title' => 'UX Designer Sênior', 'company' => 'Creative Studio', 'date' => '01 Mai 2026', 'status' => 'Inscrito', 'class' => 'status-applied', 'icon' => 'bi-check-circle-fill'],
                                    ];
                                @endphp

                                @forelse($applications as $app)
                                <tr>
                                    <td><span class="job-title-chip">{{ $app['title'] }}</span></td>
                                    <td class="company-name">{{ $app['company'] }}</td>
                                    <td>{{ $app['date'] }}</td>
                                    <td>
                                        <span class="badge-status {{ $app['class'] }}">
                                            <i class="bi {{ $app['icon'] }}"></i> {{ $app['status'] }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ url('/candidato/candidaturas/' . ($app['id'] ?? 1)) }}">
                                            <button type="button" class="btn-action" title="Ver Detalhes">
                                                <i class="bi bi-arrow-right-short fs-5"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Você ainda não se candidatou a nenhuma vaga. <a href="{{ url('/vagas') }}">Buscar vagas</a></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="container pb-4 pt-2">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 pt-3">
            <span>© 2026 SkillFocus — Vagas baseadas em habilidades reais</span>
            <span class="shield-pill"><i class="bi bi-shield-fill-check"></i> Bias Shield Ativo: Seu perfil é anônimo na triagem inicial.</span>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
