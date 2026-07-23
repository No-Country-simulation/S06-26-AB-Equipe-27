<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title }} | SkillFocus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-primary: #7C3AED;
            --color-primary-dark: #5B21B6;
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
            --shadow-card: 0 1px 2px rgba(23,21,42,.04), 0 10px 28px -14px rgba(23,21,42,.14);
            --font-display: 'Sora', 'Inter', sans-serif;
            --font-body: 'Inter', sans-serif;
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

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            color: var(--color-muted);
            font-size: 0.88rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            transition: color .15s ease;
        }

        .back-link:hover { color: var(--color-primary); }

        .detail-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 1.5rem;
        }

        .company-logo {
            width: 64px;
            height: 64px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
            letter-spacing: 0.02em;
            color: #fff;
            flex-shrink: 0;
        }

        .job-title {
            font-size: clamp(1.35rem, 3vw, 1.85rem);
            font-weight: 700;
            color: var(--color-ink);
            letter-spacing: -0.02em;
            margin-bottom: 0.35rem;
        }

        .company-line {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.45rem;
            font-size: 0.92rem;
            color: var(--color-muted);
        }

        .company-line .verified { color: var(--color-shield); }

        .tag-pill {
            display: inline-flex;
            align-items: center;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 0.22rem 0.6rem;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        .tag-pill.featured {
            background: var(--color-primary-soft);
            color: var(--color-primary);
        }

        .meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.1rem;
            font-size: 0.84rem;
            color: var(--color-muted);
            margin-top: 1rem;
        }

        .meta-row span {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .meta-row i { color: #B7B2CF; }

        .skill-tag {
            display: inline-block;
            background: var(--color-primary-softer);
            border: 1px solid var(--color-border);
            color: var(--color-body);
            font-size: 0.76rem;
            font-weight: 600;
            padding: 0.28rem 0.65rem;
            border-radius: 999px;
            margin: 0.15rem 0.15rem 0 0;
        }

        .skill-tag.more {
            background: var(--color-primary-soft);
            color: var(--color-primary);
            border-color: transparent;
        }

        .match-panel {
            background: var(--color-primary-softer);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            padding: 1.1rem 1.25rem;
            min-width: 180px;
        }

        .match-panel-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--color-muted);
            margin-bottom: 0.45rem;
        }

        .match-badge {
            display: inline-flex;
            align-items: center;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.28rem 0.65rem;
            border-radius: 999px;
            margin-bottom: 0.55rem;
        }

        .match-badge.excellent { background: var(--color-match-excellent-soft); color: var(--color-match-excellent); }
        .match-badge.great { background: var(--color-match-great-soft); color: var(--color-match-great); }
        .match-badge.regular { background: var(--color-match-regular-soft); color: var(--color-match-regular); }

        .match-percent {
            font-family: var(--font-display);
            font-size: 2.4rem;
            font-weight: 800;
            line-height: 1;
        }

        .match-percent.excellent { color: var(--color-match-excellent); }
        .match-percent.great { color: var(--color-match-great); }
        .match-percent.regular { color: var(--color-match-regular); }

        .btn-save-job {
            width: 100%;
            border: 1px solid var(--color-primary);
            background: transparent;
            color: var(--color-primary);
            font-weight: 600;
            font-size: 0.84rem;
            border-radius: var(--radius-sm);
            padding: 0.55rem 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-top: 0.85rem;
            transition: all .15s ease;
        }

        .btn-save-job:hover,
        .btn-save-job.saved {
            background: var(--color-primary-soft);
            color: var(--color-primary-dark);
        }

        .content-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
            border-bottom: 1px solid var(--color-border);
            margin-bottom: 1.5rem;
        }

        .content-tab {
            border: none;
            background: none;
            color: var(--color-muted);
            font-weight: 600;
            font-size: 0.88rem;
            padding: 0.75rem 1rem;
            border-bottom: 2px solid transparent;
            margin-bottom: -1px;
            transition: all .15s ease;
        }

        .content-tab:hover { color: var(--color-primary); }

        .content-tab.active {
            color: var(--color-primary);
            border-bottom-color: var(--color-primary);
        }

        .tab-pane { display: none; }
        .tab-pane.active { display: block; }

        .section-block { margin-bottom: 1.75rem; }

        .section-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            font-weight: 700;
            color: var(--color-ink);
            margin-bottom: 0.85rem;
        }

        .section-title i { color: var(--color-primary); }

        .section-text {
            font-size: 0.92rem;
            line-height: 1.7;
            color: var(--color-body);
        }

        .bullet-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .bullet-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.65rem;
            font-size: 0.9rem;
            color: var(--color-body);
            margin-bottom: 0.65rem;
            line-height: 1.55;
        }

        .bullet-list li i {
            margin-top: 0.15rem;
            flex-shrink: 0;
        }

        .bullet-list.checks i { color: var(--color-match-excellent); }
        .bullet-list.dots i { color: var(--color-primary); font-size: 0.45rem; margin-top: 0.45rem; }

        .tip-card {
            background: linear-gradient(135deg, rgba(124,58,237,.08), rgba(13,148,136,.06));
            border: 1px solid rgba(124,58,237,.15);
            border-radius: var(--radius-md);
            padding: 1.25rem 1.35rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .tip-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--color-primary-soft);
            color: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .sidebar-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 1.35rem;
            margin-bottom: 1rem;
        }

        .sidebar-card h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--color-ink);
            margin-bottom: 1rem;
        }

        .summary-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0.85rem;
            font-size: 0.86rem;
            color: var(--color-body);
        }

        .summary-item i {
            color: var(--color-primary);
            font-size: 1rem;
            margin-top: 0.1rem;
        }

        .summary-item strong {
            display: block;
            color: var(--color-ink);
            font-size: 0.84rem;
        }

        .btn-apply-now {
            width: 100%;
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.92rem;
            padding: 0.85rem 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            box-shadow: 0 10px 22px -10px rgba(124,58,237,.55);
            transition: transform .15s ease;
        }

        .btn-apply-now:hover { color: #fff; transform: translateY(-1px); }

        .btn-applied {
            width: 100%;
            background: var(--color-primary-soft);
            color: var(--color-primary);
            border: none;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.92rem;
            padding: 0.85rem 1rem;
            pointer-events: none;
        }

        .company-about-logo {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.72rem;
            color: #fff;
            flex-shrink: 0;
        }

        .similar-job {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.85rem 0;
            border-bottom: 1px dashed var(--color-border);
            transition: opacity .15s ease;
        }

        .similar-job:last-child { border-bottom: none; padding-bottom: 0; }
        .similar-job:hover { opacity: 0.85; }

        .similar-logo {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.65rem;
            color: #fff;
            flex-shrink: 0;
        }

        .similar-title {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--color-ink);
            line-height: 1.35;
        }

        .similar-meta {
            font-size: 0.76rem;
            color: var(--color-muted);
        }

        .similar-match {
            margin-left: auto;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.25rem 0.55rem;
            border-radius: 999px;
            white-space: nowrap;
        }

        .similar-match.excellent { background: var(--color-match-excellent-soft); color: var(--color-match-excellent); }
        .similar-match.great { background: var(--color-match-great-soft); color: var(--color-match-great); }
        .similar-match.regular { background: var(--color-match-regular-soft); color: var(--color-match-regular); }

        .sidebar-link {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--color-primary);
            margin-top: 0.75rem;
        }

        .sidebar-link:hover { color: var(--color-primary-dark); }

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
            .match-panel { width: 100%; margin-top: 1.25rem; }
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

        <a href="{{ url('/jobs') }}" class="back-link">
            <i class="bi bi-arrow-left"></i> Voltar para vagas
        </a>

        @php
            $jobSkills = $requirements ?? [];
            $visibleSkills = array_slice($jobSkills, 0, 4);
            $extraSkills = max(0, count($jobSkills) - 4);
        @endphp

        {{-- Hero card --}}
        <div class="detail-card mb-4">
            <div class="d-flex flex-column flex-lg-row gap-4">
                <div class="flex-grow-1 min-w-0">
                    <div class="d-flex gap-3 align-items-start">
                        <div class="company-logo" style="background: {{ $companyMeta['logoColor'] }};">
                            {{ $companyMeta['initials'] }}
                        </div>
                        <div class="min-w-0">
                            <h1 class="job-title">{{ $job->title }}</h1>
                            <div class="company-line">
                                <span>{{ $companyMeta['name'] }}</span>
                                <i class="bi bi-patch-check-fill verified"></i>
                                @if($isFeatured)
                                    <span class="tag-pill featured">Destaque</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="meta-row">
                        <span><i class="bi bi-laptop"></i> {{ $workType }}</span>
                        <span><i class="bi bi-bar-chart-steps"></i> {{ $job->level }}</span>
                        <span><i class="bi bi-currency-dollar"></i> {{ $salary['label'] }}</span>
                        <span><i class="bi bi-clock"></i> há {{ $postedAgo }}</span>
                    </div>

                    <div class="mt-3">
                        @foreach($visibleSkills as $skill)
                            <span class="skill-tag">{{ $skill }}</span>
                        @endforeach
                        @if($extraSkills > 0)
                            <span class="skill-tag more">+{{ $extraSkills }}</span>
                        @endif
                    </div>
                </div>

                <div class="match-panel align-self-lg-start">
                    <div class="match-panel-label">Seu match</div>
                    <span class="match-badge {{ $matchMeta['class'] }}">{{ $matchMeta['label'] }}</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="match-percent {{ $matchMeta['class'] }}">{{ $matchScore }}%</span>
                        <i class="bi bi-info-circle text-muted" title="Compatibilidade baseada no seu perfil"></i>
                    </div>
                    <button type="button" class="btn-save-job" id="saveJobBtn" data-save-job="{{ $job->id }}">
                        <i class="bi bi-bookmark"></i> Salvar vaga
                    </button>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Main content --}}
            <div class="col-lg-8">
                <div class="detail-card">
                    <div class="content-tabs" role="tablist">
                        <button type="button" class="content-tab active" data-tab="description">Descrição</button>
                        <button type="button" class="content-tab" data-tab="requirements">Requisitos</button>
                        <button type="button" class="content-tab" data-tab="benefits">Benefícios</button>
                        <button type="button" class="content-tab" data-tab="company">Sobre a empresa</button>
                    </div>

                    <div id="tab-description" class="tab-pane active">
                        <div class="section-block">
                            <h2 class="section-title"><i class="bi bi-stars"></i> Sobre a oportunidade</h2>
                            <p class="section-text">{{ $job->description }}</p>
                        </div>

                        <div class="section-block">
                            <h2 class="section-title"><i class="bi bi-list-check"></i> Principais responsabilidades</h2>
                            <ul class="bullet-list">
                                @foreach($responsibilities as $item)
                                    <li><i class="bi bi-dot"></i><span>{{ $item }}</span></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="section-block">
                            <h2 class="section-title"><i class="bi bi-check2-square"></i> Requisitos</h2>
                            <ul class="bullet-list checks">
                                @forelse($requirements as $skill)
                                    <li><i class="bi bi-check-circle-fill"></i><span>Experiência com {{ $skill }}</span></li>
                                @empty
                                    <li><i class="bi bi-check-circle-fill"></i><span>Experiência comprovada na área</span></li>
                                @endforelse
                                <li><i class="bi bi-check-circle-fill"></i><span>Boa comunicação e trabalho em equipe</span></li>
                            </ul>
                        </div>

                        <div class="section-block mb-0">
                            <h2 class="section-title"><i class="bi bi-plus-circle"></i> Diferenciais</h2>
                            <ul class="bullet-list dots">
                                @foreach($niceToHave as $item)
                                    <li><i class="bi bi-circle-fill"></i><span>{{ $item }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div id="tab-requirements" class="tab-pane">
                        <div class="section-block">
                            <h2 class="section-title"><i class="bi bi-check2-square"></i> Requisitos obrigatórios</h2>
                            <ul class="bullet-list checks">
                                @forelse($requirements as $skill)
                                    <li><i class="bi bi-check-circle-fill"></i><span>{{ $skill }}</span></li>
                                @empty
                                    <li><i class="bi bi-check-circle-fill"></i><span>Formação ou experiência compatível com a vaga</span></li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="section-block mb-0">
                            <h2 class="section-title"><i class="bi bi-plus-circle"></i> Diferenciais</h2>
                            <ul class="bullet-list dots">
                                @foreach($niceToHave as $item)
                                    <li><i class="bi bi-circle-fill"></i><span>{{ $item }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div id="tab-benefits" class="tab-pane">
                        <div class="section-block mb-0">
                            <h2 class="section-title"><i class="bi bi-gift"></i> Benefícios</h2>
                            <ul class="bullet-list checks">
                                @foreach($benefits as $benefit)
                                    <li><i class="bi bi-check-circle-fill"></i><span>{{ $benefit }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div id="tab-company" class="tab-pane">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="company-about-logo" style="background: {{ $companyMeta['logoColor'] }};">
                                {{ $companyMeta['initials'] }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ $companyMeta['name'] }} <i class="bi bi-patch-check-fill text-success"></i></div>
                                <div class="text-muted" style="font-size: 0.85rem;">{{ $companyMeta['industry'] }}</div>
                            </div>
                        </div>
                        <p class="section-text mb-3">{{ $companyMeta['about'] }}</p>
                        <ul class="bullet-list mb-0">
                            <li><i class="bi bi-dot"></i><span><strong>Colaboradores:</strong> {{ $companyMeta['size'] }}</span></li>
                            <li><i class="bi bi-dot"></i><span><strong>Setor:</strong> {{ $companyMeta['industry'] }}</span></li>
                            <li><i class="bi bi-dot"></i><span><strong>Website:</strong> {{ $companyMeta['website'] }}</span></li>
                        </ul>
                    </div>
                </div>

                <div class="tip-card mt-4">
                    <div class="tip-icon"><i class="bi bi-rocket-takeoff"></i></div>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark mb-1">Dica para aumentar seu match</div>
                        <p class="mb-0 text-muted" style="font-size: 0.88rem;">Complete seu perfil com habilidades, idiomas e portfólio para melhorar a compatibilidade com vagas como esta.</p>
                    </div>
                    <a href="{{ route('candidate-setup.step1') }}" class="btn-save-job" style="width: auto; margin-top: 0;">Completar perfil</a>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="sidebar-card">
                    <h3>Resumo da vaga</h3>
                    <div class="summary-item">
                        <i class="bi bi-laptop"></i>
                        <div><strong>Modelo</strong>{{ $workType }}</div>
                    </div>
                    <div class="summary-item">
                        <i class="bi bi-bar-chart-steps"></i>
                        <div><strong>Experiência</strong>{{ $job->level }}</div>
                    </div>
                    <div class="summary-item">
                        <i class="bi bi-file-earmark-text"></i>
                        <div><strong>Contrato</strong>CLT</div>
                    </div>
                    <div class="summary-item">
                        <i class="bi bi-clock"></i>
                        <div><strong>Carga horária</strong>44h/semana</div>
                    </div>
                    <div class="summary-item">
                        <i class="bi bi-calendar3"></i>
                        <div><strong>Publicada</strong>há {{ $postedAgo }}</div>
                    </div>
                    <div class="summary-item mb-4">
                        <i class="bi bi-hourglass-split"></i>
                        <div><strong>Inscrições até</strong>{{ $applicationDeadline }}</div>
                    </div>

                    @if($alreadyApplied)
                        <span class="btn-applied d-block text-center">Candidatura enviada</span>
                    @else
                        <form action="{{ route('jobs.apply', $job) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-apply-now">
                                <i class="bi bi-send-fill"></i> Candidatar-se agora
                            </button>
                        </form>
                    @endif
                </div>

                <div class="sidebar-card">
                    <h3>Sobre a empresa</h3>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="company-about-logo" style="background: {{ $companyMeta['logoColor'] }};">
                            {{ $companyMeta['initials'] }}
                        </div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.92rem;">{{ $companyMeta['name'] }} <i class="bi bi-patch-check-fill text-success"></i></div>
                            <div class="text-muted" style="font-size: 0.78rem;">{{ $companyMeta['industry'] }}</div>
                        </div>
                    </div>
                    <p class="section-text mb-3" style="font-size: 0.86rem;">{{ Str::limit($companyMeta['about'], 160) }}</p>
                    <div class="summary-item mb-2">
                        <i class="bi bi-people"></i>
                        <div><strong>Colaboradores</strong>{{ $companyMeta['size'] }}</div>
                    </div>
                    <div class="summary-item mb-0">
                        <i class="bi bi-building"></i>
                        <div><strong>Setor</strong>{{ $companyMeta['industry'] }}</div>
                    </div>
                    <a href="{{ url('/jobs') }}?keyword={{ urlencode($companyMeta['name']) }}" class="sidebar-link">
                        Ver todas as vagas da empresa <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                @if($similarJobs->count())
                <div class="sidebar-card">
                    <h3>Vagas semelhantes</h3>
                    @foreach($similarJobs as $similar)
                        <a href="{{ route('jobs.show', $similar['job']) }}" class="similar-job">
                            <div class="similar-logo" style="background: {{ $similar['companyMeta']['logoColor'] }};">
                                {{ $similar['companyMeta']['initials'] }}
                            </div>
                            <div class="min-w-0">
                                <div class="similar-title text-truncate">{{ $similar['job']->title }}</div>
                                <div class="similar-meta">{{ $similar['companyMeta']['name'] }} · {{ $similar['workType'] }}</div>
                            </div>
                            <span class="similar-match {{ $similar['matchMeta']['class'] }}">{{ $similar['matchScore'] }}%</span>
                        </a>
                    @endforeach
                    <a href="{{ url('/jobs') }}" class="sidebar-link">
                        Ver mais vagas semelhantes <i class="bi bi-arrow-right"></i>
                    </a>
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
            try { return JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]'); }
            catch { return []; }
        }

        function setSavedJobs(ids) {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(ids));
        }

        function updateSaveButton() {
            const btn = document.getElementById('saveJobBtn');
            if (!btn) return;

            const id = btn.dataset.saveJob;
            const saved = getSavedJobs();
            const isSaved = saved.includes(id);

            btn.classList.toggle('saved', isSaved);
            btn.innerHTML = isSaved
                ? '<i class="bi bi-bookmark-fill"></i> Vaga salva'
                : '<i class="bi bi-bookmark"></i> Salvar vaga';
        }

        document.getElementById('saveJobBtn')?.addEventListener('click', () => {
            const btn = document.getElementById('saveJobBtn');
            const id = btn.dataset.saveJob;
            let saved = getSavedJobs();
            saved = saved.includes(id) ? saved.filter(x => x !== id) : [...saved, id];
            setSavedJobs(saved);
            updateSaveButton();
        });

        document.querySelectorAll('.content-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.content-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
                tab.classList.add('active');
                document.getElementById('tab-' + tab.dataset.tab)?.classList.add('active');
            });
        });

        document.addEventListener('DOMContentLoaded', updateSaveButton);
    </script>
</body>
</html>
