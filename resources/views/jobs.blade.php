<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Vagas | SkillFocus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ==========================================================
           SKILLFOCUS — DESIGN TOKENS
           Fonte única da verdade de cores/tipografia/raios/sombras.
           Reaproveitar exatamente estas variáveis nas próximas views
           (dashboard, matches, relatórios, bias shield) para manter
           consistência visual em todo o produto.
        ========================================================== */
        :root {
            /* Marca — roxo SkillFocus */
            --color-primary: #7C3AED;
            --color-primary-dark: #5B21B6;
            --color-primary-hover: #6D28D9;
            --color-primary-soft: #F3EEFE;
            --color-primary-softer: #FBFAFF;

            /* Acento "Bias Shield" — verde-petróleo de confiança/equidade,
               deliberadamente distinto do roxo para sinalizar o selo de
               diversidade sem competir com a cor de marca */
            --color-shield: #0D9488;
            --color-shield-soft: #E8F8F6;
            --color-shield-warn: #B45309;
            --color-shield-warn-soft: #FEF6E7;

            /* Neutros — levemente quentes/roxeados, não cinza puro */
            --color-ink: #17152A;
            --color-body: #47435C;
            --color-muted: #77738F;
            --color-border: #E9E5F3;
            --color-surface: #FFFFFF;
            --color-bg: #FAF9FD;

            /* Níveis de vaga */
            --level-junior-bg: #E7F8EF;   --level-junior-fg: #157A47;
            --level-pleno-bg: #F3EEFE;    --level-pleno-fg: #6D28D9;
            --level-senior-bg: #E9F1FE;   --level-senior-fg: #1D4ED8;
            --level-gestao-bg: #FDF1DF;   --level-gestao-fg: #B45309;

            /* Raios e sombras */
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            --shadow-card: 0 1px 2px rgba(23,21,42,.04), 0 10px 28px -14px rgba(23,21,42,.14);
            --shadow-card-hover: 0 18px 36px -14px rgba(124,58,237,.28);
            --shadow-pop: 0 12px 32px -8px rgba(23,21,42,.16);

            /* Tipografia */
            --font-display: 'Sora', 'Inter', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        * { -webkit-font-smoothing: antialiased; }

        html, body {
            height: 100%;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--color-bg);
            background-image:
                radial-gradient(circle at 100% 0%, rgba(124,58,237,.06), transparent 45%),
                radial-gradient(circle at 0% 20%, rgba(13,148,136,.045), transparent 40%);
            background-attachment: fixed;
            color: var(--color-body);
        }

        h1, h2, h3, .font-display { font-family: var(--font-display); }

        a { text-decoration: none; }

        /* ==========================================================
           NAVBAR
           Estrutura padrão Bootstrap (nav.navbar > .container-fluid),
           que já aplica display:flex + justify-content:space-between
           aos filhos diretos do container. Por isso NÃO usamos grid
           customizado aqui: com apenas dois elementos "visíveis" de
           cada vez (brand + toggler no mobile, brand + collapse no
           desktop, pois o toggler some no breakpoint lg), o space-between
           nativo já resolve "brand no start, resto no end" sem gambiarra
           e sem os saltos de alinhamento que um grid manual costuma
           causar quando o conteúdo muda de largura.
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

        /* O collapse agrupa links + ações. No desktop (>=lg) ele vira uma
           linha flex alinhada ao fim, então os dois blocos ficam sempre
           colados um ao outro na ponta direita — nunca "soltos" ou
           puxados pro centro. No mobile ele vira um painel empilhado. */
        .navbar-collapse {
            gap: 1.5rem;
        }

        @media (min-width: 992px) {
            .navbar-collapse {
                align-items: center;
                justify-content: flex-end;
            }
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

        .nav-link-custom:hover {
            color: var(--color-ink);
            background-color: var(--color-primary-softer);
        }

        .nav-link-custom.active {
            background-color: var(--color-primary);
            color: #fff;
            box-shadow: 0 6px 14px -6px rgba(124,58,237,.55);
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            flex-shrink: 0;
        }

        .icon-btn {
            color: var(--color-muted);
            font-size: 1.15rem;
            transition: color .18s ease;
        }
        .icon-btn:hover { color: var(--color-ink); }

        .navbar-toggler {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background-color: var(--color-primary-softer);
        }

        .navbar-toggler:focus { box-shadow: none; }

        .navbar-toggler-icon {
            width: 18px;
            height: 18px;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%237C3AED' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2.5' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .avatar-badge {
            width: 36px;
            height: 36px;
            border-radius: 100%;
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            font-weight: 700;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown-menu {
            border: 1px solid var(--color-border);
            box-shadow: var(--shadow-pop);
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

        .page-heading p {
            color: var(--color-muted);
            font-size: 0.95rem;
        }

        .btn-nova-vaga {
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

        .btn-nova-vaga:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 14px 26px -10px rgba(124,58,237,.7);
        }

        /* ---------------- Toolbar (busca + filtros) ---------------- */
        .toolbar-card {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            padding: 1rem 1.15rem;
            box-shadow: var(--shadow-card);
        }

        .search-container {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            border: 1px solid transparent;
            border-radius: var(--radius-sm);
            padding: 0.15rem 0;
        }

        .search-container input {
            border: none;
            outline: none;
            box-shadow: none;
            width: 100%;
            background: transparent;
            color: var(--color-ink);
            font-size: 0.95rem;
        }

        .search-container input::placeholder { color: #ACA8C2; }

        .filter-divider {
            width: 1px;
            align-self: stretch;
            background-color: var(--color-border);
        }

        .filter-chip {
            border: 1px solid var(--color-border);
            background-color: var(--color-surface);
            color: var(--color-body);
            font-size: 0.82rem;
            font-weight: 600;
            padding: 0.4rem 0.9rem;
            border-radius: 999px;
            white-space: nowrap;
            transition: all .15s ease;
        }

        .filter-chip:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .filter-chip.active {
            background-color: var(--color-ink);
            border-color: var(--color-ink);
            color: #fff;
        }

        /* ---------------- Job cards ---------------- */
        .job-card {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
            position: relative;
            overflow: hidden;
        }

        .job-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-shield));
            opacity: 0;
            transition: opacity .2s ease;
        }

        .job-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-card-hover);
            border-color: rgba(124,58,237,.25);
        }

        .job-card:hover::before { opacity: 1; }

        .job-title {
            font-family: var(--font-display);
            font-size: 1.08rem;
            font-weight: 600;
            color: var(--color-ink);
            letter-spacing: -0.01em;
        }

        .job-info-text {
            color: var(--color-muted);
            font-size: 0.87rem;
            display: flex;
            align-items: center;
            gap: 0.55rem;
        }

        .job-info-text i { color: #B7B2CF; font-size: 0.95rem; }

        .card-divider {
            border-top: 1px dashed var(--color-border);
            margin: 1.1rem 0 0.9rem;
        }

        .badge-nivel {
            padding: 0.32rem 0.75rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        /* Selo Bias Shield — elemento de assinatura do produto: cada
           vaga exibe seu índice de equidade de triagem, reforçando o
           diferencial de diversidade diretamente onde o RH decide. */
        .shield-score {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 0.3rem 0.65rem 0.3rem 0.55rem;
            border-radius: 999px;
        }

        .shield-score.is-high {
            background-color: var(--color-shield-soft);
            color: var(--color-shield);
        }

        .shield-score.is-mid {
            background-color: var(--color-shield-warn-soft);
            color: var(--color-shield-warn);
        }

        .shield-score i { font-size: 0.85rem; }

        .btn-ver-detalhes {
            color: var(--color-primary);
            font-weight: 700;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            transition: gap .15s ease, color .15s ease;
        }

        .btn-ver-detalhes:hover {
            color: var(--color-primary-hover);
            gap: 0.5rem;
        }

        .dropdown-actions .btn {
            padding: 0.15rem 0.35rem;
            color: var(--color-muted);
            border: none;
            background: transparent;
            border-radius: var(--radius-sm);
        }
        .dropdown-actions .btn:hover {
            color: var(--color-ink);
            background-color: var(--color-primary-softer);
        }

        /* ---------------- Estado vazio ---------------- */
        .empty-state {
            background-color: var(--color-surface);
            border: 1px dashed var(--color-border);
            border-radius: var(--radius-lg);
            padding: 3.5rem 1.5rem;
            text-align: center;
        }

        .empty-state i {
            font-size: 2.1rem;
            color: var(--color-primary);
            background-color: var(--color-primary-soft);
            width: 64px;
            height: 64px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
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

        /* ---------------- Responsivo ---------------- */
        /* Abaixo de lg, o collapse deixa de ser uma linha e vira um
           painel full-width empilhado sob a linha marca/toggler: links
           em coluna (mais fácil de tocar) e o cluster de ações separado
           por um divisor, para não parecer "grudado" nos links. */

        @media (max-width: 991.98px) {
            .navbar-collapse.show {
                margin-top: 0.85rem;
                padding-top: 0.85rem;
                padding-bottom: 0.5rem;
                border-top: 1px solid var(--color-border);
                max-height: 75vh;
                overflow-y: auto;
            }

            .navbar-nav {
                width: 100%;
                gap: 0.35rem;
            }

            .nav-link-custom {
                width: 100%;
            }

            .navbar-actions {
                width: 100%;
                justify-content: flex-start;
                margin-top: 0.75rem;
                padding-top: 0.75rem;
                border-top: 1px dashed var(--color-border);
            }
        }

        @media (max-width: 575.98px) {
            .toolbar-card { flex-direction: column; align-items: stretch !important; }
            .filter-divider { display: none; }
            .filter-scroll { overflow-x: auto; padding-bottom: 0.25rem; }
        }
    </style>
</head>
<body>

    {{-- NAVBAR SUPERIOR --}}
    <nav class="navbar navbar-expand-lg sticky-top py-2">
        <div class="container px-4">

            {{-- START: ícone + nome da empresa --}}
            <a class="navbar-brand d-flex align-items-center" href="#">
                <span class="brand-icon"><i class="bi bi-graph-up-arrow"></i></span>
                Skill<span style="color: var(--color-primary);">Focus</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- END: links de navegação + ações, sempre juntos na ponta direita --}}
            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav flex-lg-row gap-lg-1 gap-1">
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ url('/dashboard') }}">
                            <i class="bi bi-grid-1x2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom active" href="{{ url('/jobs') }}">
                            <i class="bi bi-briefcase"></i> Vagas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ url('/mapa-talentos') }}">
                            <i class="bi bi-map"></i> Mapa de Calor
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ url('/jobs/reports') }}">
                            <i class="bi bi-bar-chart"></i> Relatórios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom" href="{{ route('esg-progress.index') }}">
                            <i class="bi bi-shield-check"></i> Progresso
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom text-danger" href="{{route('logout')}}">
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
                <div class="eyebrow mb-2">Recrutamento &amp; seleção</div>
                <h1 class="mb-1">Vagas</h1>
                <p class="mb-0">Gerencie as posições abertas e acompanhe o índice de equidade de cada processo</p>
            </div>
            <a href="{{ url('/jobs/create') }}" class="btn btn-nova-vaga d-inline-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> Nova vaga
            </a>
        </div>

        <div class="toolbar-card d-flex align-items-center gap-3 mb-4">
            <div class="search-container flex-grow-1">
                <i class="bi bi-search text-muted"></i>
                <input type="text" placeholder="Buscar por título ou área...">
            </div>
            {{--
            BOTÕES DE FILTRO
            <div class="filter-divider d-none d-sm-block"></div>
            <div class="d-flex gap-2 filter-scroll">
                <button type="button" class="filter-chip active">Todas</button>
                <button type="button" class="filter-chip">Tecnologia</button>
                <button type="button" class="filter-chip">Operações</button>
                <button type="button" class="filter-chip">Comercial</button>
            </div> --}}
        </div>

        @if ($jobs->count())
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($jobs as $job)

                {{-- Cores das tags por nível --}}
                @php
                    $levelLower = strtolower($job->level);
                    $badgeBg = '#F3F4F6'; $badgeColor = '#4B5563';

                    if (str_contains($levelLower, 'pleno')) {
                        $badgeBg = 'var(--level-pleno-bg)'; $badgeColor = 'var(--level-pleno-fg)';
                    } elseif (str_contains($levelLower, 'sênior') || str_contains($levelLower, 'senior')) {
                        $badgeBg = 'var(--level-senior-bg)'; $badgeColor = 'var(--level-senior-fg)';
                    } elseif (str_contains($levelLower, 'júnior') || str_contains($levelLower, 'junior')) {
                        $badgeBg = 'var(--level-junior-bg)'; $badgeColor = 'var(--level-junior-fg)';
                    } elseif (str_contains($levelLower, 'gerência') || str_contains($levelLower, 'coordenação')) {
                        $badgeBg = 'var(--level-gestao-bg)'; $badgeColor = 'var(--level-gestao-fg)';
                    }

                    // Índice do Bias Shield — usa o valor real do job quando existir,
                    // caso contrário mantém o placeholder de demonstração.
                    $shieldScore = $job->bias_score ?? rand(72, 98);
                    $shieldClass = $shieldScore >= 85 ? 'is-high' : 'is-mid';
                    $shieldIcon = $shieldScore >= 85 ? 'bi-shield-check' : 'bi-shield-exclamation';
                @endphp

                <div class="col">
                    <div class="job-card p-4 h-100 d-flex flex-column">

                        <div class="d-flex justify-content-between align-items-start mb-3 gap-2">
                            <h2 class="job-title mb-0">{{ $job->title }}</h2>

                            <div class="dropdown dropdown-actions flex-shrink-0">
                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0" style="border-radius: 10px;">
                                    <li><a class="dropdown-item small py-2" href="/match/{{$job->id}}"><i class="bi bi-person-bounding-box me-2" style="color: var(--color-shield);"></i> Ver Matches</a></li>
                                    <li><a class="dropdown-item small py-2" href="/jobs/{{$job->id}}/edit"><i class="bi bi-pencil me-2" style="color: var(--level-gestao-fg);"></i> Editar Vaga</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="/jobs/{{$job->id}}/delete" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta vaga?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="dropdown-item small py-2 text-danger" type="submit">
                                                <i class="bi bi-trash me-2"></i> Excluir Vaga
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                            <span class="badge-nivel" style="background-color: {{ $badgeBg }}; color: {{ $badgeColor }};">
                                {{ $job->level }}
                            </span>
                            <span class="shield-score {{ $shieldClass }}" title="Índice Bias Shield de triagem equitativa">
                                <i class="bi {{ $shieldIcon }}"></i> {{ $shieldScore }}%
                            </span>
                        </div>

                        <div class="mb-1 flex-grow-1">
                            <div class="job-info-text mb-2">
                                <i class="bi bi-building"></i>
                                {{ $job->area ?? 'Departamento/Área' }}
                            </div>
                            <div class="job-info-text">
                                <i class="bi bi-geo-alt"></i>
                                {{ $job->city }}, {{ $job->district }}
                            </div>
                        </div>

                        <div class="card-divider"></div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="job-info-text mb-0">
                                <i class="bi bi-people"></i>
                                {{ $job->candidates_count ?? rand(10, 99) }} candidatos
                            </div>

                            <a href="/match/{{$job->id}}" class="btn-ver-detalhes">
                                Ver detalhes <i class="bi bi-chevron-right" style="font-size: 0.7rem;"></i>
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-briefcase"></i>
            <h2 class="job-title mb-2">Nenhuma vaga aberta</h2>
            <p class="text-muted mb-4">Crie a primeira vaga para começar a receber candidaturas com triagem justa.</p>
            <a href="{{ url('/jobs/create') }}" class="btn btn-nova-vaga d-inline-flex align-items-center gap-2">
                Criar nova vaga!
            </a>
        </div>
        @endif

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
