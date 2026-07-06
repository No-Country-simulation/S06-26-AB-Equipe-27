<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progresso ESG | SkillFocus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ==========================================================
           SKILLFOCUS — DESIGN TOKENS
           Mesmos tokens da view de Vagas (jobs), para manter
           consistência visual entre as páginas do produto.
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
            --color-shield-danger: #DC2626;
            --color-shield-danger-soft: #FDEDEC;

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

        /* ---------------- Alerta de sucesso ---------------- */
        .success-banner {
            background-color: var(--color-shield-soft);
            border: 1px solid rgba(13,148,136,.25);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 1.25rem 1.5rem;
        }

        .success-banner .icon-wrap {
            width: 48px; height: 48px;
            border-radius: 14px;
            background-color: #fff;
            color: var(--color-shield);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            box-shadow: var(--shadow-card);
        }

        .success-banner h3 {
            font-family: var(--font-display);
            color: var(--color-ink);
            font-size: 1.05rem;
            font-weight: 700;
        }

        /* ---------------- Goal cards ---------------- */
        .goal-card {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: box-shadow .2s ease, border-color .2s ease;
        }

        .goal-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-shield));
        }

        .goal-card:hover {
            box-shadow: var(--shadow-card-hover);
            border-color: rgba(124,58,237,.2);
        }

        .goal-title {
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--color-ink);
            letter-spacing: -0.01em;
        }

        .goal-description {
            color: var(--color-muted);
            font-size: 0.87rem;
        }

        .tag-tracking-type {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            background-color: var(--color-primary-soft);
            color: var(--color-primary-dark);
            padding: 0.3rem 0.7rem;
            border-radius: 999px;
        }

        .btn-atualizar {
            border: 1px solid var(--color-border);
            background-color: var(--color-surface);
            color: var(--color-primary);
            font-weight: 700;
            font-size: 0.82rem;
            padding: 0.45rem 0.9rem;
            border-radius: var(--radius-sm);
            transition: all .15s ease;
            white-space: nowrap;
        }

        .btn-atualizar:hover {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: #fff;
        }

        .goal-value {
            font-family: var(--font-display);
            font-size: 2.1rem;
            font-weight: 700;
            color: var(--color-shield);
            line-height: 1;
        }

        .goal-value-target {
            color: #C9C5DC;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .goal-progress-track {
            background-color: var(--color-primary-soft);
            border-radius: 999px;
            height: 10px;
            flex: 1;
            overflow: hidden;
        }

        .goal-progress-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-shield));
        }

        .goal-note {
            color: var(--color-muted);
            font-size: 0.85rem;
        }

        /* Status badges — mesma linguagem visual das badges de nível da view de Vagas */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.95rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.78rem;
        }

        .badge-status.status-not-started {
            background-color: #F1F0F6;
            color: var(--color-muted);
        }

        .badge-status.status-in-progress {
            background-color: var(--level-senior-bg, #E9F1FE);
            color: #1D4ED8;
        }

        .badge-status.status-completed {
            background-color: var(--color-shield-soft);
            color: var(--color-shield);
        }

        .badge-status.status-cancelled {
            background-color: var(--color-shield-danger-soft);
            color: var(--color-shield-danger);
        }

        .card-divider {
            border-top: 1px dashed var(--color-border);
            margin: 1.1rem 0;
        }

        /* ---------------- Modal ---------------- */
        .modal-content {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-pop);
        }

        .modal-title {
            font-family: var(--font-display);
            color: var(--color-ink);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .modal .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--color-body);
        }

        .modal .form-control,
        .modal .input-group-text {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
        }

        .modal .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(124,58,237,.12);
        }

        .modal .form-control:disabled {
            background-color: var(--color-primary-softer);
            color: var(--color-muted);
        }

        .modal .form-check-input:checked {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .btn-cancelar {
            background-color: var(--color-primary-softer);
            color: var(--color-body);
            font-weight: 600;
            border: none;
            border-radius: var(--radius-sm);
            padding: 0.6rem 1.2rem;
        }
        .btn-cancelar:hover { background-color: var(--color-primary-soft); color: var(--color-ink); }

        .btn-salvar {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: var(--radius-sm);
            padding: 0.6rem 1.3rem;
            box-shadow: 0 10px 22px -10px rgba(124,58,237,.6);
        }
        .btn-salvar:hover { color: #fff; box-shadow: 0 14px 26px -10px rgba(124,58,237,.7); }

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
            width: 64px; height: 64px;
            border-radius: 18px;
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: 1rem;
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
                        <a class="nav-link-custom" href="{{ url('/jobs') }}">
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
                        <a class="nav-link-custom active" href="{{ route('esg-progress.index') }}">
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
    <main class="container my-5" style="max-width: 900px;">

        <div class="page-heading mb-4">
            <div class="eyebrow mb-2">Ambiental, social e governança</div>
            <h1 class="mb-1">Progresso ESG</h1>
            <p class="mb-0">Acompanhe o progresso das suas metas ambientais, sociais e de governança</p>
        </div>

        @if(session('success'))
        <div class="success-banner d-flex align-items-center gap-3 mb-4">
            <div class="icon-wrap flex-shrink-0">
                <i class="bi bi-check-lg"></i>
            </div>
            <h3 class="mb-0">{{ session('success') }}</h3>
        </div>
        @endif

        @if($goals->count())
        <div class="d-flex flex-column gap-4">
            @foreach($goals as $goal)
            <div class="goal-card">
                <div class="d-flex justify-content-between align-items-start mb-3 gap-3 flex-wrap">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                            <h3 class="goal-title mb-0">{{ $goal->title }}</h3>
                            <span class="tag-tracking-type">{{ ucfirst($goal->tracking_type) }}</span>
                        </div>
                        @if($goal->description)
                        <p class="goal-description mb-0">{{ $goal->description }}</p>
                        @endif
                    </div>
                    <button type="button" class="btn-atualizar flex-shrink-0" data-bs-toggle="modal" data-bs-target="#editModal-{{ $goal->id }}">
                        <i class="bi bi-pencil me-1"></i>Atualizar
                    </button>
                </div>

                <div class="card-divider"></div>

                @if($goal->tracking_type === 'count')
                <div class="d-flex align-items-center gap-3">
                    <div class="goal-value">{{ $goal->current_value }}</div>
                    <div class="goal-value-target">/ {{ $goal->target_value }}</div>
                    <div class="goal-progress-track">
                        <div class="goal-progress-fill" style="width: {{ $goal->target_value > 0 ? min(($goal->current_value / $goal->target_value) * 100, 100) : 0 }}%"></div>
                    </div>
                </div>
                @if($goal->notes)
                <p class="goal-note mt-3 mb-0"><i class="bi bi-sticky me-1"></i>{{ $goal->notes }}</p>
                @endif

                @elseif($goal->tracking_type === 'percentage')
                <div class="d-flex align-items-center gap-3">
                    <div class="goal-value">{{ $goal->current_value }}%</div>
                    <div class="goal-value-target">/ 100%</div>
                    <div class="goal-progress-track">
                        <div class="goal-progress-fill" style="width: {{ $goal->current_value }}%"></div>
                    </div>
                </div>

                @elseif($goal->tracking_type === 'status')
                @php
                    $statusLabels = [
                        'NOT_STARTED' => 'Não iniciado',
                        'IN_PROGRESS' => 'Em andamento',
                        'COMPLETED' => 'Concluído',
                        'PENDING' => 'Não iniciado',
                        'ACHIEVED' => 'Concluído',
                        'CANCELLED' => 'Não iniciado',
                    ];
                    $statusClasses = [
                        'NOT_STARTED' => 'status-not-started',
                        'PENDING' => 'status-not-started',
                        'IN_PROGRESS' => 'status-in-progress',
                        'COMPLETED' => 'status-completed',
                        'ACHIEVED' => 'status-completed',
                        'CANCELLED' => 'status-cancelled',
                    ];
                    $statusIcons = [
                        'NOT_STARTED' => 'bi-dash-circle',
                        'PENDING' => 'bi-dash-circle',
                        'IN_PROGRESS' => 'bi-arrow-repeat',
                        'COMPLETED' => 'bi-check-circle-fill',
                        'ACHIEVED' => 'bi-check-circle-fill',
                        'CANCELLED' => 'bi-x-circle',
                    ];
                @endphp
                <span class="badge-status {{ $statusClasses[$goal->status] ?? 'status-not-started' }}">
                    <i class="bi {{ $statusIcons[$goal->status] ?? 'bi-dash-circle' }}"></i>
                    {{ $statusLabels[$goal->status] ?? $goal->status }}
                </span>
                @endif
            </div>

            {{-- Modal de edição --}}
            <div class="modal fade" id="editModal-{{ $goal->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $goal->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('esg-progress.update', $goal) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title" id="editModalLabel-{{ $goal->id }}">Atualizar meta: {{ $goal->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                @if($goal->tracking_type === 'count')
                                <div class="mb-3">
                                    <label class="form-label">Valor alvo (fixo)</label>
                                    <input type="number" class="form-control" value="{{ $goal->target_value }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Valor atual</label>
                                    <input type="number" name="current_value" value="{{ $goal->current_value }}" class="form-control" min="0" max="{{ $goal->target_value }}" required>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label">Notas (opcional)</label>
                                    <textarea name="notes" class="form-control" rows="3">{{ $goal->notes }}</textarea>
                                </div>

                                @elseif($goal->tracking_type === 'percentage')
                                <div class="mb-3">
                                    <label class="form-label">Valor alvo (fixo)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" value="100" disabled>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label">Percentual atual</label>
                                    <div class="input-group">
                                        <input type="number" name="current_value" value="{{ $goal->current_value }}" class="form-control" min="0" max="100" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>

                                @elseif($goal->tracking_type === 'status')
                                <div class="mb-1">
                                    <label class="form-label d-block mb-2">Status</label>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="NOT_STARTED" id="status-not-started-{{ $goal->id }}" {{ in_array($goal->status, ['NOT_STARTED', 'PENDING']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status-not-started-{{ $goal->id }}">Não iniciado</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="IN_PROGRESS" id="status-in-progress-{{ $goal->id }}" {{ $goal->status === 'IN_PROGRESS' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status-in-progress-{{ $goal->id }}">Em andamento</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" value="COMPLETED" id="status-completed-{{ $goal->id }}" {{ in_array($goal->status, ['COMPLETED', 'ACHIEVED']) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status-completed-{{ $goal->id }}">Concluído</label>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn-salvar">Salvar alterações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <i class="bi bi-bar-chart"></i>
            <h2 class="goal-title mb-2">Nenhuma meta cadastrada</h2>
            <p class="text-muted mb-0">Assim que houver metas ESG configuradas, elas aparecerão aqui.</p>
        </div>
        @endif

    </main>

    <footer class="container pb-4 pt-2" style="border-top: 1px solid var(--color-border); color: var(--color-muted); font-size: 0.78rem;">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 pt-3">
            <span>© 2026 SkillFocus — Plataforma de RH com foco em diversidade</span>
            <span class="d-inline-flex align-items-center gap-2" style="color: var(--color-shield); font-weight: 600;">
                <i class="bi bi-lock-fill"></i> Dados protegidos · Bias Shield ativo
            </span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
