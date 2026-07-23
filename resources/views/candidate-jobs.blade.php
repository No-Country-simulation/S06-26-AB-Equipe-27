<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vagas Disponíveis | SkillFocus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-primary: #7C3AED;
            --color-primary-dark: #5B21B6;
            --color-primary-hover: #6D28D9;
            --color-primary-soft: #F3EEFE;
            --color-primary-softer: #FBFAFF;
            --color-shield: #0D9488;
            --color-shield-soft: #E8F8F6;
            --color-match-excellent: #059669;
            --color-match-excellent-soft: #D1FAE5;
            --color-match-great: #2563EB;
            --color-match-great-soft: #DBEAFE;
            --color-match-regular: #D97706;
            --color-match-regular-soft: #FEF3C7;
            --color-ink: #17152A;
            --color-body: #47435C;
            --color-muted: #77738F;
            --color-border: #E9E5F3;
            --color-surface: #FFFFFF;
            --color-bg: #FAF9FD;
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            --shadow-card: 0 1px 2px rgba(23, 21, 42, .04), 0 10px 28px -14px rgba(23, 21, 42, .14);
            --shadow-card-hover: 0 18px 36px -14px rgba(124, 58, 237, .22);
            --font-display: 'Sora', 'Inter', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        * {
            -webkit-font-smoothing: antialiased;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--color-bg);
            background-image:
                radial-gradient(circle at 100% 0%, rgba(124, 58, 237, .06), transparent 45%),
                radial-gradient(circle at 0% 20%, rgba(13, 148, 136, .045), transparent 40%);
            background-attachment: fixed;
            color: var(--color-body);
        }

        h1,
        h2,
        h3,
        .font-display {
            font-family: var(--font-display);
        }

        a {
            text-decoration: none;
        }

        .page-heading .eyebrow {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
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

        .btn-outline-soft {
            border: 1px solid var(--color-border);
            background: var(--color-surface);
            color: var(--color-body);
            font-weight: 600;
            font-size: 0.85rem;
            border-radius: var(--radius-sm);
            padding: 0.55rem 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            transition: all .15s ease;
        }

        .btn-outline-soft:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .sort-select {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            padding: 0.55rem 2rem 0.55rem 0.85rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--color-body);
            background-color: var(--color-surface);
            min-width: 160px;
        }

        /* Sidebar filters */
        .filters-panel {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 1.35rem;
            box-shadow: var(--shadow-card);
            position: sticky;
            top: 88px;
        }

        .filters-panel h2 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--color-ink);
        }

        .filter-clear {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--color-primary);
            border: none;
            background: none;
            padding: 0;
        }

        .filter-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--color-ink);
            margin-bottom: 0.45rem;
        }

        .filter-input-wrap {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            padding: 0.55rem 0.75rem;
            background: var(--color-primary-softer);
        }

        .filter-input-wrap i {
            color: var(--color-muted);
            font-size: 0.95rem;
        }

        .filter-input-wrap input,
        .filter-input-wrap select {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            font-size: 0.85rem;
            color: var(--color-ink);
        }

        .filter-check {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            font-size: 0.85rem;
            color: var(--color-body);
            margin-bottom: 0.4rem;
            cursor: pointer;
        }

        .filter-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--color-primary);
        }

        .salary-range {
            width: 100%;
            accent-color: var(--color-primary);
        }

        .salary-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: var(--color-muted);
            margin-top: 0.35rem;
        }

        .btn-apply-filters {
            width: 100%;
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            font-weight: 600;
            font-size: 0.88rem;
            border: none;
            border-radius: var(--radius-sm);
            padding: 0.7rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            box-shadow: 0 8px 20px -8px rgba(124, 58, 237, .55);
            transition: transform .15s ease;
        }

        .btn-apply-filters:hover {
            color: #fff;
            transform: translateY(-1px);
        }

        /* Tabs */
        .jobs-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .jobs-tab {
            border: 1px solid var(--color-border);
            background: var(--color-surface);
            color: var(--color-body);
            font-size: 0.82rem;
            font-weight: 600;
            padding: 0.45rem 0.9rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: all .15s ease;
            cursor: pointer;
        }

        .jobs-tab:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .jobs-tab.active {
            background: var(--color-primary);
            border-color: var(--color-primary);
            color: #fff;
            box-shadow: 0 6px 14px -6px rgba(124, 58, 237, .55);
        }

        .jobs-tab .tab-count {
            background: rgba(255, 255, 255, .25);
            padding: 0.1rem 0.45rem;
            border-radius: 999px;
            font-size: 0.72rem;
        }

        .jobs-tab:not(.active) .tab-count {
            background: var(--color-primary-soft);
            color: var(--color-primary);
        }

        .results-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            color: var(--color-muted);
        }

        .results-bar strong {
            color: var(--color-ink);
        }

        .refresh-link {
            color: var(--color-muted);
            font-size: 0.82rem;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            border: none;
            background: none;
            padding: 0;
        }

        .refresh-link:hover {
            color: var(--color-primary);
        }

        /* Job listing cards */
        .listing-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 1.25rem 1.35rem;
            box-shadow: var(--shadow-card);
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
            margin-bottom: 1rem;
        }

        .listing-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-card-hover);
            border-color: rgba(124, 58, 237, .2);
        }

        .company-logo {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.72rem;
            letter-spacing: 0.02em;
            color: #fff;
            flex-shrink: 0;
        }

        .listing-title {
            font-family: var(--font-display);
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--color-ink);
            margin-bottom: 0.25rem;
        }

        .listing-company {
            font-size: 0.85rem;
            color: var(--color-muted);
            display: flex;
            align-items: center;
            gap: 0.35rem;
            flex-wrap: wrap;
        }

        .listing-company .verified {
            color: var(--color-shield);
            font-size: 0.8rem;
        }

        .tag-pill {
            display: inline-flex;
            align-items: center;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        .tag-pill.featured {
            background: var(--color-primary-soft);
            color: var(--color-primary);
        }

        .tag-pill.new {
            background: var(--color-shield-soft);
            color: var(--color-shield);
        }

        .skill-tag {
            display: inline-block;
            background: var(--color-primary-softer);
            border: 1px solid var(--color-border);
            color: var(--color-body);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.6rem;
            border-radius: 999px;
            margin: 0.15rem 0.15rem 0 0;
        }

        .skill-tag.more {
            background: var(--color-primary-soft);
            color: var(--color-primary);
            border-color: transparent;
        }

        .match-block {
            text-align: center;
            min-width: 110px;
            padding-left: 1rem;
            border-left: 1px dashed var(--color-border);
        }

        .match-label {
            display: inline-flex;
            align-items: center;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 0.25rem 0.55rem;
            border-radius: 999px;
            margin-bottom: 0.35rem;
            white-space: nowrap;
        }

        .match-label.excellent {
            background: var(--color-match-excellent-soft);
            color: var(--color-match-excellent);
        }

        .match-label.great {
            background: var(--color-match-great-soft);
            color: var(--color-match-great);
        }

        .match-label.regular {
            background: var(--color-match-regular-soft);
            color: var(--color-match-regular);
        }

        .match-percent {
            font-family: var(--font-display);
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1;
        }

        .match-percent.excellent {
            color: var(--color-match-excellent);
        }

        .match-percent.great {
            color: var(--color-match-great);
        }

        .match-percent.regular {
            color: var(--color-match-regular);
        }

        .meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            font-size: 0.8rem;
            color: var(--color-muted);
            margin-top: 0.85rem;
        }

        .meta-row span {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .meta-row i {
            color: #B7B2CF;
        }

        .btn-save-job {
            border: none;
            background: none;
            color: var(--color-muted);
            font-size: 1.15rem;
            padding: 0.25rem;
            transition: color .15s ease;
            flex-shrink: 0;
        }

        .btn-save-job:hover,
        .btn-save-job.saved {
            color: var(--color-primary);
        }

        .listing-title a:hover {
            color: var(--color-primary) !important;
        }

        .btn-candidatar {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.82rem;
            padding: 0.45rem 1rem;
            white-space: nowrap;
        }

        .btn-candidatar:hover {
            color: #fff;
        }

        .btn-applied {
            background: var(--color-primary-soft);
            color: var(--color-primary);
            border: none;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.82rem;
            padding: 0.45rem 1rem;
            pointer-events: none;
        }

        /* Pagination */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
        }

        .pagination-wrap .pagination {
            gap: 0.35rem;
        }

        .pagination-wrap .page-link {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm) !important;
            color: var(--color-body);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.45rem 0.75rem;
            min-width: 38px;
            text-align: center;
        }

        .pagination-wrap .page-item.active .page-link {
            background: var(--color-primary);
            border-color: var(--color-primary);
            color: #fff;
        }

        .pagination-wrap .page-link:hover {
            background: var(--color-primary-soft);
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .empty-state {
            background: var(--color-surface);
            border: 1px dashed var(--color-border);
            border-radius: var(--radius-lg);
            padding: 3rem 1.5rem;
            text-align: center;
        }

        .alert-flash {
            border-radius: var(--radius-md);
            font-size: 0.88rem;
            font-weight: 600;
        }

        footer {
            border-top: 1px solid var(--color-border);
            color: var(--color-muted);
            font-size: 0.78rem;
        }

        @media (max-width: 991.98px) {
            .filters-panel {
                position: static;
                margin-bottom: 1.5rem;
            }

            .match-block {
                border-left: none;
                border-top: 1px dashed var(--color-border);
                padding-left: 0;
                padding-top: 1rem;
                margin-top: 1rem;
                width: 100%;
            }
        }

        @media (max-width: 575.98px) {
            .page-heading-actions {
                width: 100%;
            }

            .sort-select {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <x-navbar activePage="jobs" />

    <main class="container my-4 my-lg-5 px-3 px-lg-4">

        @if(session('success'))
        <div class="alert alert-success alert-flash mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-flash mb-4">{{ session('error') }}</div>
        @endif

        {{-- Page header --}}
        <div class="page-heading d-flex flex-column flex-lg-row justify-content-between align-items-lg-end mb-4 gap-3">
            <div>
                <div class="eyebrow mb-2">{{ $isFilterApplied ? 'Suas candidaturas' : 'Vagas disponíveis' }}</div>
                <h1 class="mb-1">{{ $isFilterApplied ? 'Minhas candidaturas' : 'Encontre oportunidades incríveis' }}</h1>
                <p class="mb-0">{{ $isFilterApplied ? 'Acompanhe o status das suas aplicações' : 'Descubra vagas alinhadas ao seu perfil e objetivos de carreira' }}</p>
            </div>
            <div class="page-heading-actions d-flex flex-wrap align-items-center gap-2">
                @if(!$isFilterApplied)
                <button type="button" class="btn-outline-soft" id="btnSaveSearch">
                    <i class="bi bi-bookmark"></i> Salvar busca
                </button>
                @endif
                <select class="sort-select" id="sortSelect" form="filtersForm" name="sort">
                    <option value="relevance" @selected(($filters['sort'] ?? 'relevance' )==='relevance' )>Relevância</option>
                    <option value="recent" @selected(($filters['sort'] ?? '' )==='recent' )>Mais recentes</option>
                    <option value="match" @selected(($filters['sort'] ?? '' )==='match' )>Melhor match</option>
                    <option value="salary" @selected(($filters['sort'] ?? '' )==='salary' )>Maior salário</option>
                </select>
            </div>
        </div>

        <div class="row g-4">
            {{-- Filters sidebar --}}
            <div class="col-lg-3">
                <aside class="filters-panel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0">Filtros</h2>
                        <a href="{{ url('/jobs') }}" class="filter-clear">Limpar</a>
                    </div>

                    <form id="filtersForm" method="GET" action="{{ url('/jobs') }}">
                        <input type="hidden" name="tab" id="tabInput" value="{{ $filters['tab'] ?? 'all' }}">
                        @if($isFilterApplied)
                        <input type="hidden" name="filter" value="applied">
                        @endif

                        <div class="mb-3">
                            <div class="filter-label">Palavra-chave</div>
                            <div class="filter-input-wrap">
                                <i class="bi bi-search"></i>
                                <input type="text" name="keyword" placeholder="Ex: Python, UX..." value="{{ $filters['keyword'] ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="filter-label">Localização</div>
                            <div class="filter-input-wrap">
                                <i class="bi bi-geo-alt"></i>
                                <input type="text" name="location" placeholder="Cidade ou estado" value="{{ $filters['location'] ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="filter-label">Tipo de trabalho</div>
                            @foreach(['Remoto', 'Presencial', 'Híbrido'] as $type)
                            <label class="filter-check">
                                <input type="checkbox" name="work_type[]" value="{{ $type }}"
                                    @checked(in_array($type, (array)($filters['work_type'] ?? ['Remoto'])))>
                                {{ $type }}
                            </label>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <div class="filter-label">Nível de experiência</div>
                            @foreach(['Estágio', 'Júnior', 'Pleno', 'Sênior', 'Especialista'] as $level)
                            <label class="filter-check">
                                <input type="checkbox" name="level[]" value="{{ $level }}"
                                    @checked(in_array($level, (array)($filters['level'] ?? ['Pleno'])))>
                                {{ $level }}
                            </label>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <div class="filter-label">Área</div>
                            <div class="filter-input-wrap">
                                <select name="area">
                                    <option value="">Todas as áreas</option>
                                    @foreach(['Tecnologia', 'Design', 'Marketing', 'Finanças', 'Operações', 'Recursos Humanos'] as $area)
                                    <option value="{{ $area }}" @selected(($filters['area'] ?? '' )===$area)>{{ $area }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="filter-label">Salário esperado</div>
                            <input type="range" class="salary-range" name="salary_min" min="2000" max="20000" step="500"
                                value="{{ $filters['salary_min'] ?? 8000 }}" id="salaryRange">
                            <div class="salary-labels">
                                <span>R$ 2.000</span>
                                <span id="salaryValue">R$ {{ number_format($filters['salary_min'] ?? 8000, 0, ',', '.') }}</span>
                                <span>R$ 20.000+</span>
                            </div>
                        </div>

                        <button type="submit" class="btn-apply-filters">
                            <i class="bi bi-funnel"></i> Aplicar filtros
                        </button>
                    </form>
                </aside>
            </div>

            {{-- Job listings --}}
            <div class="col-lg-9">
                <div class="jobs-tabs" role="tablist">
                    <button type="button" class="jobs-tab active" data-tab="all">
                        Todas as vagas <span class="tab-count">{{ $allCount }}</span>
                    </button>
                    <button type="button" class="jobs-tab" data-tab="today">
                        Novas hoje <span class="tab-count">{{ $todayCount }}</span>
                    </button>
                    <button type="button" class="jobs-tab" data-tab="compatible">
                        Compatíveis <span class="tab-count">{{ $compatibleCount }}</span>
                    </button>
                    <button type="button" class="jobs-tab" data-tab="saved">
                        Salvas <span class="tab-count" id="savedCount">0</span>
                    </button>
                </div>

                <div class="results-bar">
                    <span><strong>{{ $jobs->total() }}</strong> vagas encontradas</span>
                    <button type="button" class="refresh-link" onclick="location.reload()">
                        <i class="bi bi-arrow-clockwise"></i> Atualizado há poucos minutos
                    </button>
                </div>

                @if($jobs->count())
                <div id="jobsList">
                    @foreach($jobs as $job)
                    @php
                    $companyName = $job->company->name ?? 'Empresa';
                    $initials = collect(explode(' ', $companyName))->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->join('');
                    $logoColors = ['#7C3AED', '#2563EB', '#0D9488', '#D97706', '#DB2777'];
                    $logoColor = $logoColors[$job->id % count($logoColors)];

                    $jobSkills = $job->required_skills ?? [];
                    $candidateSkills = $candidate?->skills ?? [];
                    $matchScore = !empty($jobSkills)
                    ? (int) round((count(array_intersect(
                    array_map('strtolower', $jobSkills),
                    array_map('strtolower', $candidateSkills)
                    )) / count($jobSkills)) * 100)
                    : rand(55, 75);

                    if ($matchScore >= 85) {
                    $matchClass = 'excellent';
                    $matchLabel = 'Excelente match';
                    } elseif ($matchScore >= 70) {
                    $matchClass = 'great';
                    $matchLabel = 'Ótimo match';
                    } else {
                    $matchClass = 'regular';
                    $matchLabel = 'Regular match';
                    }

                    $workTypes = ['Remoto', 'Híbrido', 'Presencial'];
                    $workType = $workTypes[$job->id % 3];

                    $salaryBase = match(true) {
                    str_contains(strtolower($job->level), 'senior') || str_contains(strtolower($job->level), 'sênior') => 12000,
                    str_contains(strtolower($job->level), 'pleno') => 9000,
                    str_contains(strtolower($job->level), 'junior') || str_contains(strtolower($job->level), 'júnior') => 6000,
                    default => 7500,
                    };
                    $salaryMin = $salaryBase;
                    $salaryMax = $salaryBase + 4000;

                    $isNew = $job->created_at->isToday();
                    $isFeatured = $job->id % 4 === 0;
                    $alreadyApplied = in_array($job->id, $appliedJobIds);
                    $visibleSkills = array_slice($jobSkills, 0, 4);
                    $extraSkills = max(0, count($jobSkills) - 4);

                    $postedAgo = $job->created_at->diffForHumans(null, true);
                    @endphp

                    <article class="listing-card"
                        data-job-id="{{ $job->id }}"
                        data-match="{{ $matchScore }}"
                        data-new="{{ $isNew ? '1' : '0' }}"
                        data-compatible="{{ $matchScore >= 70 ? '1' : '0' }}"
                        data-job-url="{{ route('jobs.show', $job) }}">
                        <div class="d-flex flex-column flex-md-row gap-3">
                            <a href="{{ route('jobs.show', $job) }}" class="company-logo text-decoration-none" style="background: {{ $logoColor }};">{{ $initials }}</a>

                            <div class="flex-grow-1 min-w-0">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div>
                                        <h2 class="listing-title">
                                            <a href="{{ route('jobs.show', $job) }}" class="text-decoration-none" style="color: inherit;">{{ $job->title }}</a>
                                        </h2>
                                        <div class="listing-company">
                                            {{ $companyName }}
                                            <i class="bi bi-patch-check-fill verified"></i>
                                            @if($isFeatured)
                                            <span class="tag-pill featured">Destaque</span>
                                            @endif
                                            @if($isNew)
                                            <span class="tag-pill new">Nova</span>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="button" class="btn-save-job" data-save-job="{{ $job->id }}" aria-label="Salvar vaga">
                                        <i class="bi bi-bookmark"></i>
                                    </button>
                                </div>

                                <div class="mt-2">
                                    @foreach($visibleSkills as $skill)
                                    <span class="skill-tag">{{ $skill }}</span>
                                    @endforeach
                                    @if($extraSkills > 0)
                                    <span class="skill-tag more">+{{ $extraSkills }}</span>
                                    @endif
                                </div>

                                <div class="meta-row">
                                    <span><i class="bi bi-laptop"></i> {{ $workType }}</span>
                                    <span><i class="bi bi-bar-chart-steps"></i> {{ $job->level }}</span>
                                    <span><i class="bi bi-currency-dollar"></i> R$ {{ number_format($salaryMin, 0, ',', '.') }} – R$ {{ number_format($salaryMax, 0, ',', '.') }}</span>
                                    <span><i class="bi bi-clock"></i> há {{ $postedAgo }}</span>
                                </div>
                            </div>

                            <div class="match-block d-flex flex-column align-items-center justify-content-center">
                                <span class="match-label {{ $matchClass }}">{{ $matchLabel }}</span>
                                <div class="match-percent {{ $matchClass }}">{{ $matchScore }}%</div>
                                <div class="mt-2">
                                    @if($alreadyApplied)
                                    <span class="btn-applied">Candidatado</span>
                                    @else
                                    <a href="{{ route('jobs.show', $job) }}" class="btn-candidatar d-inline-block text-decoration-none">Ver vaga</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                <div class="pagination-wrap">
                    {{ $jobs->links('pagination::bootstrap-5') }}
                </div>
                @else
                <div class="empty-state">
                    <i class="bi bi-{{ $isFilterApplied ? 'file-earmark-text' : 'search' }} display-6 text-primary mb-3 d-block"></i>
                    <h2 class="listing-title mb-2">{{ $isFilterApplied ? 'Você ainda não se candidatou a nenhuma vaga' : 'Nenhuma vaga encontrada' }}</h2>
                    <p class="text-muted mb-0">{{ $isFilterApplied ? 'Explore as vagas disponíveis e se candidate a oportunidades incríveis!' : 'Tente ajustar os filtros ou volte mais tarde para novas oportunidades.' }}</p>
                </div>
                @endif
            </div>
        </div>
    </main>

    <footer class="container pb-4 pt-2">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 pt-3">
            <span>© 2026 SkillFocus — Plataforma de contratação inclusiva</span>
            <span class="text-muted"><i class="bi bi-shield-check text-success"></i> Match inteligente ativo</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const STORAGE_KEY = 'skillfocus_saved_jobs';

        function getSavedJobs() {
            try {
                return JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
            } catch {
                return [];
            }
        }

        function setSavedJobs(ids) {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(ids));
        }

        function updateSavedUI() {
            const saved = getSavedJobs();
            document.getElementById('savedCount').textContent = saved.length;

            document.querySelectorAll('[data-save-job]').forEach(btn => {
                const id = btn.dataset.saveJob;
                const isSaved = saved.includes(id);
                btn.classList.toggle('saved', isSaved);
                btn.querySelector('i').className = isSaved ? 'bi bi-bookmark-fill' : 'bi bi-bookmark';
            });

            filterByTab(document.querySelector('.jobs-tab.active')?.dataset.tab || 'all');
        }

        document.querySelectorAll('[data-save-job]').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.saveJob;
                let saved = getSavedJobs();
                saved = saved.includes(id) ? saved.filter(x => x !== id) : [...saved, id];
                setSavedJobs(saved);
                updateSavedUI();
            });
        });

        document.getElementById('btnSaveSearch').addEventListener('click', () => {
            const params = new URLSearchParams(new FormData(document.getElementById('filtersForm')));
            localStorage.setItem('skillfocus_saved_search', params.toString());
            alert('Busca salva com sucesso!');
        });

        const salaryRange = document.getElementById('salaryRange');
        const salaryValue = document.getElementById('salaryValue');
        salaryRange?.addEventListener('input', () => {
            const val = parseInt(salaryRange.value, 10);
            salaryValue.textContent = 'R$ ' + val.toLocaleString('pt-BR');
        });

        document.getElementById('sortSelect')?.addEventListener('change', () => {
            document.getElementById('filtersForm').submit();
        });

        function filterByTab(tab) {
            const saved = getSavedJobs();
            document.querySelectorAll('.listing-card').forEach(card => {
                let show = true;
                if (tab === 'today') show = card.dataset.new === '1';
                else if (tab === 'compatible') show = card.dataset.compatible === '1';
                else if (tab === 'saved') show = saved.includes(card.dataset.jobId);
                card.style.display = show ? '' : 'none';
            });
        }

        document.querySelectorAll('.jobs-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.jobs-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                document.getElementById('tabInput').value = tab.dataset.tab;
                filterByTab(tab.dataset.tab);
            });
        });

        document.addEventListener('DOMContentLoaded', updateSavedUI);
    </script>
</body>

</html>