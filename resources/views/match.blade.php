<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matches | SkillFocus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ==========================================================
           SKILLFOCUS — DESIGN TOKENS
           (mesmos tokens usados em /jobs, /reports e nas telas de auth)
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
            --color-shield-danger: #B91C1C;
            --color-shield-danger-soft: #FDEAEA;

            --color-ink: #17152A;
            --color-body: #47435C;
            --color-muted: #77738F;
            --color-border: #E9E5F3;
            --color-surface: #FFFFFF;
            --color-bg: #FAF9FD;

            --level-senior-bg: #E9F1FE;   --level-senior-fg: #1D4ED8;

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
        }

        h1, h2, h3, h4, .font-display { font-family: var(--font-display); }
        a { text-decoration: none; }

        /* ---------------- Navbar (idêntica às demais views) ---------------- */
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
        .navbar-toggler:focus { box-shadow: none; }
        .navbar-toggler-icon {
            width: 18px; height: 18px;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%237C3AED' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2.5' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .avatar-badge {
            width: 36px; height: 36px; border-radius: 100%;
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff; font-weight: 700; font-size: 0.8rem;
            display: flex; align-items: center; justify-content: center;
        }

        .dropdown-menu { border: 1px solid var(--color-border); box-shadow: var(--shadow-pop); }

        @media (max-width: 991.98px) {
            .navbar-collapse.show {
                margin-top: 0.85rem; padding-top: 0.85rem; padding-bottom: 0.5rem;
                border-top: 1px solid var(--color-border);
                max-height: 75vh; overflow-y: auto;
            }
            .navbar-nav { width: 100%; gap: 0.35rem; }
            .nav-link-custom { width: 100%; }
            .navbar-actions {
                width: 100%; justify-content: flex-start;
                margin-top: 0.75rem; padding-top: 0.75rem;
                border-top: 1px dashed var(--color-border);
            }
        }

        /* ---------------- Page header ---------------- */
        .page-heading .eyebrow {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--color-primary);
        }
        .page-heading h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--color-ink);
            letter-spacing: -0.02em;
        }
        .page-heading p {
            color: var(--color-muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Alerta de sucesso (tom Bias Shield) */
        .alert-shield {
            background-color: var(--color-shield-soft);
            color: var(--color-shield);
            border: 1px solid rgba(13,148,136,.18);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
        }

        /* ---------------- Card principal (container dos matches) ---------------- */
        .main-card {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 2rem;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--color-ink);
        }
        .section-title i { color: var(--color-primary); }

        /* Botões */
        .btn-purple {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            border-radius: var(--radius-sm);
            font-weight: 600;
            padding: 0.6rem 1.35rem;
            border: none;
            box-shadow: 0 10px 22px -10px rgba(124,58,237,.6);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .btn-purple:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 14px 26px -10px rgba(124,58,237,.7);
        }

        .btn-purple:disabled {
            background: #E5E2F0;
            color: #9C97B5;
            box-shadow: none;
            cursor: not-allowed;
        }

        .btn-shield {
            background-color: var(--color-shield);
            color: #fff;
            border-radius: var(--radius-sm);
            font-weight: 600;
            padding: 0.6rem 1.25rem;
            border: none;
            transition: opacity .2s ease, transform .15s ease;
        }
        .btn-shield:hover {
            opacity: .92;
            color: #fff;
            transform: translateY(-1px);
        }

        /* ---------------- Estado vazio ---------------- */
        .empty-state-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: var(--color-primary-soft);
            color: var(--color-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        /* ---------------- Match card ---------------- */
        .match-item-card {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
            position: relative;
            overflow: hidden;
        }

        .match-item-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-shield));
            opacity: 0;
            transition: opacity .2s ease;
        }

        .match-item-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-card-hover);
            border-color: rgba(124,58,237,.25);
        }
        .match-item-card:hover::before { opacity: 1; }

        .match-item-card.selected {
            border-color: rgba(13,148,136,.35);
            background-color: var(--color-shield-soft);
        }
        .match-item-card.selected::before { opacity: 1; }

        .candidate-name {
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--color-ink);
            font-size: 1.1rem;
            letter-spacing: -0.01em;
        }

        /* Badges */
        .badge-match {
            background-color: var(--color-primary-soft);
            color: var(--color-primary);
            font-weight: 700;
            font-size: 0.75rem;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
        }
        .badge-diversity {
            background-color: var(--level-senior-bg);
            color: var(--level-senior-fg);
            font-weight: 700;
            font-size: 0.75rem;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
        }

        .seniority-line {
            color: var(--color-muted);
            font-size: 0.87rem;
            display: flex;
            align-items: center;
            gap: 0.45rem;
        }
        .seniority-line i { color: #B7B2CF; }

        .skill-badge {
            background-color: var(--color-primary-softer);
            color: var(--color-body);
            border: 1px solid var(--color-border);
            font-size: 0.76rem;
            font-weight: 600;
            padding: 0.3rem 0.75rem;
            border-radius: var(--radius-sm);
        }

        /* Recomendação da IA */
        .ai-recommendation-box {
            background-color: var(--color-primary-softer);
            border-left: 3px solid var(--color-primary);
            padding: 0.85rem 1.1rem;
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            font-size: 0.88rem;
            color: var(--color-body);
            margin: 1rem 0;
        }
        .ai-recommendation-box strong { color: var(--color-ink); }

        /* Painel de ações à direita do card */
        .match-actions {
            border-left: 1px dashed var(--color-border);
        }
        @media (max-width: 767.98px) {
            .match-actions { border-left: none; border-top: 1px dashed var(--color-border); padding-top: 1rem; }
        }

        .btn-select {
            background-color: var(--color-shield);
            color: #fff;
            border-radius: var(--radius-sm);
            font-weight: 600;
            padding: 0.55rem 1rem;
            border: none;
            transition: opacity .2s ease, transform .15s ease;
        }
        .btn-select:hover {
            opacity: .92;
            color: #fff;
            transform: translateY(-1px);
        }

        .badge-notified {
            background-color: var(--color-shield-soft);
            color: var(--color-shield);
            border: 1px solid rgba(13,148,136,.2);
            padding: 0.5rem 1rem;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.85rem;
        }

        .helper-note {
            color: var(--color-muted);
            font-size: 0.75rem;
        }

        /* ---------------- Footer ---------------- */
        footer {
            border-top: 1px solid var(--color-border);
            color: var(--color-muted);
            font-size: 0.78rem;
        }
        footer .shield-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: var(--color-shield);
            font-weight: 600;
        }
    </style>
</head>
<body>

    {{-- NAVBAR SUPERIOR --}}
    <nav class="navbar navbar-expand-lg sticky-top py-2">
        <div class="container px-4">

            <a class="navbar-brand d-flex align-items-center" href="{{ url('/dashboard') }}">
                <span class="brand-icon"><i class="bi bi-graph-up-arrow"></i></span>
                Skill<span style="color: var(--color-primary);">Focus</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-lg-row gap-lg-1 gap-1">
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ route('dashboard') }}">
                            <i class="bi bi-grid-1x2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ url('/jobs') }}">
                            <i class="bi bi-briefcase"></i> Vagas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom active" href="#">
                            <i class="bi bi-people"></i> Matches
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ url('/jobs/reports') }}">
                            <i class="bi bi-bar-chart"></i> Relatórios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ route('esg-progress.index') }}">
                            <i class="bi bi-shield-check"></i> Bias Shield
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom text-danger" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right me-2"></i> Sair
                        </a>
                    </li>
                </ul>

                <div class="navbar-actions">
                    <div class="dropdown">
                        <a class="d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                            <div class="avatar-badge">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 mt-2" style="border-radius: 12px;">
                            @auth
                            <li class="px-3 py-2 text-muted small border-bottom mb-1">
                                Logado como:<br><strong class="text-dark">{{ auth()->user()->name }}</strong>
                            </li>
                            @endauth
                            <li><a class="dropdown-item py-2" href="{{ url('/jobs/create') }}"><i class="bi bi-plus-circle me-2"></i>Criar vaga</a></li>
                            <li><a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- CONTEÚDO PRINCIPAL --}}
    <main class="container my-5">

        <div class="page-heading mb-4">
            <div class="eyebrow mb-2">Triagem inteligente</div>
            <h1 class="mb-2">{{ $job->title }}</h1>
            <p class="clamp-3 mb-0">{{ $job->description }}</p>
        </div>

        @if(session('success'))
        <div class="alert alert-shield alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="main-card">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-4 gap-3" style="border-bottom: 1px solid var(--color-border);">
                <div>
                    <h3 class="section-title mb-1">
                        <i class="bi bi-stars me-2"></i>Candidatos Compatíveis
                    </h3>
                    <p class="text-muted mb-0 small">Nossa IA filtrou os melhores talentos para esta posição baseada no seu Bias Shield.</p>
                </div>

                <div class="text-md-end">
                    @if($job->matches_generated)
                    <button class="btn btn-purple px-4" disabled>
                        <i class="bi bi-check-all me-2"></i>Matches Gerados
                    </button>
                    @else
                    <form action="{{ route('match.generate', $job->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-purple px-4">
                            <i class="bi bi-lightning-charge-fill me-2"></i> Gerar Matches com IA
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            @if($matches->isEmpty())
            <div class="text-center py-5">
                <div class="empty-state-icon mb-3">
                    <i class="bi bi-search"></i>
                </div>
                <h5 class="fw-bold" style="color: var(--color-ink);">Nenhum talento encontrado ainda</h5>
                <p class="text-muted mb-0">Clique em "Gerar Matches com IA" para processar o banco de currículos.</p>
            </div>
            @else
            <div class="row g-4">
                @foreach ($matches as $match)
                <div class="col-12">
                    <div class="match-item-card p-4 {{ $match->status === 'selecionado' ? 'selected' : '' }}">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-4">

                            <div class="flex-grow-1 w-100">
                                <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                                    <span class="candidate-name me-2">
                                        Candidato Mascarado #{{ $loop->iteration }}
                                    </span>
                                    <span class="badge-match">
                                        <i class="bi bi-star-fill me-1" style="color:#F59E0B;"></i> {{ $match->score_match }}% Match
                                    </span>
                                    <span class="badge-diversity">
                                        <i class="bi bi-award-fill me-1"></i> {{ $match->badge_diversidade }}
                                    </span>
                                </div>

                                <div class="seniority-line mb-2">
                                    <i class="bi bi-person-badge"></i> <strong style="color: var(--color-ink);">Senioridade:</strong> {{ $match->seniority }}
                                </div>

                                <div class="ai-recommendation-box">
                                    <strong>Resumo da IA:</strong> {{ $match->recomendacao }}
                                </div>

                                <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                                    <span class="text-muted small fw-medium me-1">Skills detectadas:</span>
                                    @if(!empty($match->skills))
                                        @foreach($match->skills as $skill)
                                        <span class="skill-badge">{{ $skill }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">Nenhuma skill mapeada.</span>
                                    @endif
                                </div>
                            </div>

                            <div class="match-actions d-flex flex-column align-items-md-end justify-content-center ps-md-4 mt-3 mt-md-0 w-100 w-md-auto text-center text-md-end" style="min-width: 200px;">
                                @if($match->status === 'pendente')
                                <form action="{{ route('match.select', $match->id) }}" method="POST" class="w-100">
                                    @csrf
                                    <button type="submit" class="btn btn-select w-100 mb-2">
                                        <i class="bi bi-person-plus-fill me-2"></i> Selecionar
                                    </button>
                                </form>
                                <span class="helper-note">O candidato será notificado.</span>
                                @else
                                <div class="d-flex flex-column align-items-center align-items-md-end w-100">
                                    <div class="badge-notified w-100 text-center mb-2">
                                        <i class="bi bi-check-circle-fill me-1"></i> Notificado
                                    </div>
                                    <span class="helper-note">Aguardando aceite do candidato.</span>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </main>

    <footer class="container pb-4 pt-2">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 pt-3">
            <span>© 2026 SkillFocus — Plataforma de RH com foco em diversidade</span>
            <span class="shield-pill"><i class="bi bi-lock-fill"></i> Dados protegidos · Bias Shield ativo</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
