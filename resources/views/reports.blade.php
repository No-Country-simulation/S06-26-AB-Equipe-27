<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios | SkillFocus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ==========================================================
           SKILLFOCUS — DESIGN TOKENS
           (mesmos tokens usados em /jobs, para manter consistência
           visual entre todas as views do produto)
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

            --level-junior-bg: #E7F8EF;   --level-junior-fg: #157A47;
            --level-pleno-bg: #F3EEFE;    --level-pleno-fg: #6D28D9;
            --level-senior-bg: #E9F1FE;   --level-senior-fg: #1D4ED8;
            --level-gestao-bg: #FDF1DF;   --level-gestao-fg: #B45309;

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

        /* ---------------- Navbar (idêntica à de /jobs) ---------------- */
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
            font-size: 1.85rem;
            font-weight: 700;
            color: var(--color-ink);
            letter-spacing: -0.02em;
        }
        .page-heading p { color: var(--color-muted); font-size: 0.95rem; }

        .btn-download {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: var(--radius-sm);
            padding: 0.65rem 1.35rem;
            border: none;
            box-shadow: 0 10px 22px -10px rgba(124,58,237,.6);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .btn-download:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 14px 26px -10px rgba(124,58,237,.7);
        }

        /* ---------------- Report cards ---------------- */
        .report-card {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 1.75rem;
            height: 100%;
            position: relative;
            overflow: hidden;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        .report-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-shield));
            opacity: 0;
            transition: opacity .2s ease;
        }

        .report-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-card-hover);
            border-color: rgba(124,58,237,.25);
        }
        .report-card:hover::before { opacity: 1; }

        .card-header-custom {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin-bottom: 1.4rem;
        }
        .card-header-custom .icon-wrap {
            width: 36px; height: 36px;
            border-radius: 10px;
            display: inline-flex; align-items: center; justify-content: center;
            background-color: var(--color-primary-soft);
            color: var(--color-primary);
            font-size: 1rem;
            flex-shrink: 0;
        }
        .card-header-custom h3 {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--color-ink);
            margin: 0;
            letter-spacing: -0.01em;
        }

        /* Barra de progresso, no mesmo tom da marca */
        .progress-bar-custom {
            background-color: var(--color-primary-softer);
            border: 1px solid var(--color-border);
            border-radius: 99px;
            height: 9px;
            overflow: hidden;
        }
        .progress-fill-custom {
            height: 100%;
            background: linear-gradient(90deg, var(--color-primary), var(--color-shield));
            border-radius: 99px;
        }

        /* Selo grande de pontuação — reaproveita a linguagem visual
           do "shield-score" da tela de vagas, em versão ampliada */
        .big-stat {
            font-family: var(--font-display);
            font-size: 3rem;
            font-weight: 800;
            color: var(--color-ink);
            line-height: 1;
            letter-spacing: -0.02em;
        }

        .shield-score {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 0.3rem 0.65rem 0.3rem 0.55rem;
            border-radius: 999px;
        }
        .shield-score.is-high { background-color: var(--color-shield-soft); color: var(--color-shield); }
        .shield-score.is-mid  { background-color: var(--color-shield-warn-soft); color: var(--color-shield-warn); }
        .shield-score i { font-size: 0.85rem; }

        /* Badges de status/prioridade — paleta consistente com os
           badges de nível de vaga (mesma família de cores) */
        .badge-nivel {
            padding: 0.32rem 0.8rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }
        .badge-status-done       { background: var(--level-junior-bg); color: var(--level-junior-fg); }
        .badge-status-progress   { background: var(--level-pleno-bg);  color: var(--level-pleno-fg); }
        .badge-status-todo       { background: #F3F4F6; color: var(--color-muted); }

        .badge-priority-low    { background: var(--level-junior-bg); color: var(--level-junior-fg); }
        .badge-priority-medium { background: var(--level-gestao-bg); color: var(--level-gestao-fg); }
        .badge-priority-high   { background: var(--color-shield-danger-soft); color: var(--color-shield-danger); }

        .goal-row + .goal-row { margin-top: 1.15rem; }
        .goal-row .goal-title { font-size: 0.87rem; font-weight: 600; color: var(--color-ink); }

        .priority-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .priority-row + .priority-row {
            margin-top: 0.9rem;
            padding-top: 0.9rem;
            border-top: 1px dashed var(--color-border);
        }
        .priority-row .priority-label { font-size: 0.87rem; color: var(--color-body); font-weight: 500; }

        .empty-note { color: var(--color-muted); font-size: 0.87rem; }

        /* ---------------- Card de destaque (matching + regiões) ---------------- */
        .highlight-card {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 1.75rem;
            display: flex;
            align-items: center;
            gap: 1.75rem;
        }

        .highlight-stat-box {
            text-align: center;
            padding: 1.1rem 1.5rem;
            border-radius: var(--radius-md);
            min-width: 160px;
            flex-shrink: 0;
        }
        .highlight-stat-box.is-high { background-color: var(--color-shield-soft); }
        .highlight-stat-box.is-low  { background-color: var(--color-shield-warn-soft); }

        .highlight-stat-box .stat-number {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 2.1rem;
            line-height: 1;
        }
        .highlight-stat-box.is-high .stat-number { color: var(--color-shield); }
        .highlight-stat-box.is-low .stat-number  { color: var(--color-shield-warn); }

        .highlight-stat-box .stat-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--color-muted);
        }

        .region-pill {
            background-color: var(--color-primary-softer);
            border: 1px solid var(--color-border);
            color: var(--color-body);
            font-weight: 600;
            font-size: 0.82rem;
            padding: 0.45rem 0.95rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .region-pill i { color: var(--color-shield); }

        /* ---------------- Footer (idêntico à de /jobs) ---------------- */
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
                        <a class="nav-link-custom" href="{{ url('/jobs/matches') }}">
                            <i class="bi bi-people"></i> Matches
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ url('/mapa-talentos') }}">
                            <i class="bi bi-map"></i> Mapa de Calor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom active" href="#">
                            <i class="bi bi-bar-chart"></i> Relatórios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ route('esg-progress.index') }}">
                            <i class="bi bi-shield-check"></i> Progresso
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom text-danger" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right me-2"></i> Sair
                        </a>
                    </li>
                </ul>

                <div class="navbar-actions">
                    <a class="d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                        <div class="avatar-badge">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- CONTEÚDO PRINCIPAL --}}
    <main class="container my-5">

        <div class="page-heading d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
            <div>
                <div class="eyebrow mb-2">Diversidade &amp; ESG</div>
                <h1 class="mb-1">Relatórios Analíticos</h1>
                <p class="mb-0">Visão consolidada de diversidade, metas e métricas ESG</p>
            </div>
            <a href="{{ route('reports.download-pdf') }}" class="btn btn-download d-inline-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-pdf"></i> Baixar PDF
            </a>
        </div>

        <div class="row g-4">

            {{-- Pontuação Diversity --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="report-card d-flex flex-column">
                    <div class="card-header-custom">
                        <span class="icon-wrap"><i class="bi bi-star-fill"></i></span>
                        <h3>Pontuação Diversity</h3>
                    </div>
                    <div class="big-stat mb-3">{{ $diversityScore ?? 0 }}<span class="fs-5 text-muted fw-semibold">/100</span></div>
                    <div class="progress-bar-custom mt-auto">
                        <div class="progress-fill-custom" style="width: {{ $diversityScore ?? 0 }}%"></div>
                    </div>
                </div>
            </div>

            {{-- Metas ESG --}}
            <div class="col-12 col-md-6 col-lg-5">
                <div class="report-card">
                    <div class="card-header-custom">
                        <span class="icon-wrap"><i class="bi bi-bullseye"></i></span>
                        <h3>Metas ESG</h3>
                    </div>

                    @if($esgGoals->count() > 0)
                        @foreach($esgGoals as $goal)
                            <div class="goal-row">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="goal-title">{{ $goal->title }}</span>
                                    @if($goal->tracking_type == 'status')
                                        <span class="badge-nivel
                                            @if($goal->status == 'completed') badge-status-done
                                            @elseif($goal->status == 'in_progress') badge-status-progress
                                            @else badge-status-todo
                                            @endif">
                                            {{ $goal->status == 'completed' ? 'Concluído' : ($goal->status == 'in_progress' ? 'Em andamento' : 'Não iniciado') }}
                                        </span>
                                    @endif
                                </div>
                                @if($goal->tracking_type != 'status')
                                    <div class="progress-bar-custom">
                                        <div class="progress-fill-custom" style="width: {{ min(($goal->current_value / ($goal->target_value ?? 1)) * 100, 100) }}%"></div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p class="empty-note mb-0">Nenhuma meta definida.</p>
                    @endif
                </div>
            </div>

            {{-- Prioridades --}}
            <div class="col-12 col-lg-4">
                <div class="report-card">
                    <div class="card-header-custom">
                        <span class="icon-wrap"><i class="bi bi-list-check"></i></span>
                        <h3>Prioridades</h3>
                    </div>

                    @forelse($diversityGoals as $goal)
                        <div class="priority-row">
                            <span class="priority-label">{{ ucwords(str_replace('_', ' ', $goal->group)) }}</span>
                            <span class="badge-nivel badge-priority-{{ $goal->priority }}">{{ strtoupper($goal->priority) }}</span>
                        </div>
                    @empty
                        <p class="empty-note mb-0">Nenhuma prioridade definida.</p>
                    @endforelse
                </div>
            </div>

            {{-- Recomendação IA / Regiões mapeadas --}}
            <div class="col-12">
                <div class="highlight-card flex-column flex-md-row">
                    <div class="highlight-stat-box {{ $highScoreMatchings > 50 ? 'is-high' : 'is-low' }}">
                        <div class="stat-number">{{ $highScoreMatchings }}</div>
                        <span class="stat-label">
                            @if($highScoreMatchings > 50)
                                Alta compatibilidade
                            @else
                                Baixa compatibilidade
                            @endif
                        </span>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-3" style="color: var(--color-ink);">Regiões Mapeadas</h4>
                        <div class="d-flex flex-wrap gap-2">
                            @forelse($topRegions as $region)
                                <span class="region-pill"><i class="bi bi-geo-alt-fill"></i> {{ $region }}</span>
                            @empty
                                <p class="empty-note mb-0">Nenhuma região mapeada ainda.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

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
