<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progresso de Diversidade | SkillFocus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
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
            --shadow-card-hover: 0 18px 36px -14px rgba(124, 58, 237, .28);
            --shadow-pop: 0 12px 32px -8px rgba(23, 21, 42, .16);
            --font-display: 'Sora', 'Inter', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        body {
            background-color: var(--color-bg);
            background-image: radial-gradient(circle at 100% 0%, rgba(124, 58, 237, .06), transparent 45%),
                radial-gradient(circle at 0% 20%, rgba(13, 148, 136, .045), transparent 40%);
            background-attachment: fixed;
            color: var(--color-body);
            font-family: var(--font-body);
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

        .success-banner {
            background-color: var(--color-shield-soft);
            border: 1px solid rgba(13, 148, 136, 0.25);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 1.25rem 1.5rem;
            margin-bottom: 1rem;
        }

        .success-banner .icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background-color: #fff;
            color: var(--color-shield);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            box-shadow: var(--shadow-card);
        }

        .goal-card {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: box-shadow .2s ease, border-color .2s ease;
            height: 380px;
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
            border-color: rgba(124, 58, 237, 0.2);
        }

        .empty-state {
            background-color: var(--color-surface);
            border: 1px dashed var(--color-border);
            border-radius: var(--radius-lg);
            padding: 3.5rem 1.5rem;
            text-align: center;
        }

        .priority-pill {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            padding: 0.32rem 0.75rem;
            border-radius: 999px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .priority-high {
            background-color: var(--color-danger-soft);
            color: var(--color-danger);
        }

        .priority-medium {
            background-color: var(--color-shield-warn-soft);
            color: var(--color-shield-warn);
        }

        .priority-low {
            background-color: var(--color-shield-soft);
            color: var(--color-shield);
        }
    </style>
</head>


<body>
    <x-navbar activePage="diversity-progress" />

    <main class="container my-5">
        <x-pageheader
            page="Progresso de Diversidade"
            eyebrow="Recrutamento & seleção"
            description="Acompanhe o progresso das suas metas de diversidade e inclusão" />

        @if(session('success'))
        <div class="success-banner d-flex align-items-center gap-3 mb-6">
            <div class="icon-wrap flex-shrink-0">
                <i class="bi bi-check-lg"></i>
            </div>
            <h3 class="mb-0" style="font-family: var(--font-display); color: var(--color-ink); font-size: 1.05rem; font-weight: 700;">{{ session('success') }}</h3>
        </div>
        @endif

        @if($goals->count() > 0)
        <div class="row g-4">
            @php
            $groupLabels = [
            'women' => 'Mulheres',
            'black' => 'Prof. Negros',
            'indigenous' => 'Prof. Indígenas',
            'disabled' => 'PCDs',
            'lgbt' => 'LGBTQIAP++',
            'refugee' => 'Refugiados',
            'over_50' => 'Sêniores (50+)',
            'neurodivergent' => 'Neurodivergentes'
            ];
            $priorityLabels = [
            'low' => 'Baixa',
            'medium' => 'Regular',
            'high' => 'Alta'
            ];
            @endphp
            @foreach($goals as $goal)
            <div class="col-lg-4">
                <!-- First, we need to override the esg-progress-card component for diversity, so let's copy it and make small changes! -->
                <!-- Wait, actually, let's just create a temporary component here, or we can modify our existing component! -->
                <!-- Wait, let's just re-use the code for now, and make it use percentage type! -->
                <div class="goal-card" style="padding: 2rem;">
                    <style>
                        .circular-progress {
                            position: relative;
                            display: flex;
                            align-items: center;
                            width: 230px;
                            height: 200px;
                        }

                        .circular-progress svg {
                            transform: rotate(-90deg);
                        }

                        .circular-progress circle {
                            fill: none;
                            stroke-width: 16;
                            stroke-linecap: round;
                        }

                        .circular-progress .circle-bg {
                            stroke: #E9E5F3;
                        }

                        .circular-progress .circle-progress {
                            stroke-dasharray: 502.65;
                            stroke-dashoffset: 502.65;
                            transition: stroke-dashoffset 0.5s ease;
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

                        .card-divider {
                            border-top: 1px dashed var(--color-border);
                            margin: 1.1rem 0;
                        }

                        .goal-title {
                            font-family: var(--font-display);
                            font-size: 1.1rem;
                            font-weight: 700;
                            color: var(--color-ink);
                        }
                    </style>
                    <div class="d-flex justify-content-between align-items-start mb-4 gap-3 flex-wrap">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                <h3 class="goal-title mb-0">{{ $groupLabels[$goal->group] ?? ucwords(str_replace('_', ' ', $goal->group)) }}</h3>
                                @php
                                $priorityClass = ['low' => 'priority-low', 'medium' => 'priority-medium', 'high' => 'priority-high'];
                                @endphp
                                <span class="priority-pill {{ $priorityClass[$goal->priority] ?? 'priority-low' }}">
                                    {{ $priorityLabels[$goal->priority] ?? $goal->priority }}
                                </span>
                            </div>
                            @if($goal->target_percentage)
                            <p style="color: var(--color-muted); font-size: 0.87rem;">Meta: {{ $goal->target_percentage }}% até {{ $goal->target_year ?? 'futuro' }}</p>
                            @endif
                        </div>
                        <button type="button" class="btn-atualizar flex-shrink-0" data-bs-toggle="modal" data-bs-target="#editModal-{{ $goal->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>

                    <div class="card-divider"></div>

                    @php
                    $target = $goal->target_percentage ?? 100;
                    $current = $goal->current_value ?? 0;
                    $percentage = $target > 0 ? min(($current / $target) * 100, 100) : 0;
                    @endphp

                    <div class="text-center">
                        <div class="circular-progress mx-auto mb-3">
                            <svg viewBox="0 0 180 180">
                                <circle class="circle-bg" cx="90" cy="90" r="74"></circle>
                                <circle
                                    class="circle-progress"
                                    cx="90"
                                    cy="90"
                                    r="74"
                                    style="
                                        stroke: url(#progressGradient-{{ $goal->id }});
                                        stroke-dashoffset: {{ 502.65 - (502.65 * $percentage / 100) }};">
                                </circle>
                                <defs>
                                    <linearGradient id="progressGradient-{{ $goal->id }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#7C3AED" />
                                        <stop offset="100%" stop-color="#0D9488" />
                                    </linearGradient>
                                </defs>
                            </svg>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <span style="font-family: var(--font-display); font-size: 2.5rem; font-weight: 700; color: var(--color-ink);">{{ round($percentage) }}%</span>
                                <div style="font-size: 1rem; color: var(--color-muted); font-weight: 500;">de progresso</div>
                            </div>
                        </div>
                        <div class="mb-3" style="font-size: 0.95rem; color: var(--color-muted);">
                            Meta: {{ $target }}%
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal-{{ $goal->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $goal->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border: 1px solid var(--color-border); border-radius: var(--radius-lg); box-shadow: var(--shadow-pop);">
                        <form action="{{ route('diversity-progress.update', $goal) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title" style="font-family: var(--font-display); color: var(--color-ink); font-weight: 700; font-size: 1.1rem;" id="editModalLabel-{{ $goal->id }}">Atualizar Meta: {{ $groupLabels[$goal->group] ?? ucwords(str_replace('_', ' ', $goal->group)) }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if($goal->target_percentage)
                                <div class="mb-4">
                                    <label class="form-label" style="font-weight: 600; font-size: 0.85rem; color: var(--color-body);">Meta (Fixa)</label>
                                    <input type="number" class="form-control" value="{{ $goal->target_percentage }}" disabled style="border: 1px solid var(--color-border); border-radius: var(--radius-sm); font-size: 0.9rem;">
                                    <span style="font-size: 0.8rem; color: var(--color-muted);">%</span>
                                </div>
                                @endif
                                <div class="mb-4">
                                    <label class="form-label" style="font-weight: 600; font-size: 0.85rem; color: var(--color-body);">Progresso Atual</label>
                                    <div class="input-group">
                                        <input type="number" name="current_value" value="{{ $goal->current_value ?? 0 }}" class="form-control" style="border: 1px solid var(--color-border); border-radius: var(--radius-sm); font-size: 0.9rem;" min="0" max="100" step="0.01" required>
                                        <span class="input-group-text" style="border-radius: var(--radius-sm); border-top-left-radius: 0; border-bottom-left-radius: 0;">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn" style="background-color: var(--color-primary-softer); color: var(--color-body); font-weight: 600; border: none; border-radius: var(--radius-sm); padding: 0.6rem 1.2rem;" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn" style="background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark)); color: #fff; font-weight: 600; border: none; border-radius: var(--radius-sm); padding: 0.6rem 1.3rem; box-shadow: 0 10px 22px -10px rgba(124,58,237,.6);">Salvar Alterações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state" style="background-color: var(--color-surface); border: 1px dashed var(--color-border); border-radius: var(--radius-lg); padding: 3.5rem 1.5rem; text-align: center;">
            <i class="bi bi-people" style="font-size: 2.1rem; color: var(--color-primary); background-color: var(--color-primary-soft); width: 64px; height: 64px; border-radius: 18px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem;"></i>
            <h3 style="font-family: var(--font-display); color: var(--color-ink); font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem;">Nenhuma meta de diversidade definida</h3>
            <p style="color: var(--color-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">Complete o setup inicial para definir suas metas de diversidade!</p>
            <a href="{{route('setup.step1')}}" style="background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark)); color: #fff; font-weight: 700; font-size: 1rem; border: none; border-radius: var(--radius-sm); padding: 0.875rem; box-shadow: 0 10px 22px -10px rgba(124,58,237,.6); display: inline-block; text-decoration: none; transition: all .3s ease;">Iniciar Setup</a>
        </div>
        @endif
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>