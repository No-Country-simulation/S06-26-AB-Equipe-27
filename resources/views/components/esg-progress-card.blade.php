<div class="goal-card" style="padding: 2rem; height: 380px;display: grid;grid-template-rows: minmax(min-content, 60px) min-content 1fr;">
    <style>
        .circular-progress {
            position: relative;
            display: flex;
            align-items: center;
            width: 230px;
            height: 200px;
            margin-top: .5rem;
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

        .card-graph {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
    </style>

    <!-- Top section: title, tracking type, update button -->
    <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap" style="max-width: 260px;">
                <h3 class="goal-title mb-0">{{ $title }}</h3>
                <span class="tag-tracking-type">
                    @if($trackingType === 'count')
                    Quant.
                    @elseif($trackingType === 'percentage')
                    Porcent.
                    @elseif($trackingType === 'status')
                    Status
                    @endif
                </span>
            </div>
            @if($description)
            <p class="goal-description mb-0">{{ $description }}</p>
            @endif
        </div>
        <button type="button" class="btn-atualizar flex-shrink-0" data-bs-toggle="modal" data-bs-target="#editModal-{{ $goalId }}">
            <i class="bi bi-pencil"></i>
            <!-- Atualizar -->
        </button>
    </div>

    <div class="card-divider"></div>

    <!-- Progress section -->
    @if($trackingType === 'count')
    <!-- KPI-style count card -->
    <div class="mt-2 card-graph">
        <div style="font-family: var(--font-display); font-size: 3.5rem; font-weight: 800; color: var(--color-primary); line-height: 1; margin-bottom: 0.75rem; text-align: center;">
            {{ $currentValue }}
        </div>
        <div style="font-size: 1.1rem; color: var(--color-body); margin-bottom: 1rem; text-align: center;">
            <div style="color: #474747; font-weight: bold;">
                de {{ $targetValue }}
            </div>
            Concluídas
        </div>
        @if($notes)
        <p class="goal-note mb-0" style="color: var(--color-muted); font-style: italic; font-size: 0.9rem;">
            <i class="bi bi-info-circle"></i>{{ $notes }}
        </p>
        @endif
    </div>
    @elseif($trackingType === 'percentage')
    <div class="text-center">
        <div class="circular-progress mx-auto mb-3">
            <svg viewBox="0 0 180 180">
                <circle class="circle-bg" cx="90" cy="90" r="74"></circle>
                <circle
                    class="circle-progress"
                    cx="90"
                    cy="90"
                    r="74"
                    style="stroke: url(#progressGradient); stroke-dashoffset: {{ 502.65 - (502.65 * $getProgressPercentage() / 100) }};"></circle>
                <defs>
                    <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="{{ $colorStart }}" />
                        <stop offset="100%" stop-color="{{ $colorEnd }}" />
                    </linearGradient>
                </defs>
            </svg>
            <div class="position-absolute top-50 start-50 translate-middle">
                <span style="font-family: var(--font-display); font-size: 2.5rem; font-weight: 700; color: var(--color-ink);">{{ $getProgressPercentage() }}%</span>
                <div style="font-size: 1rem; color: var(--color-muted); font-weight: 500;">de progresso</div>
            </div>
        </div>
        <div class="mb-3" style="font-size: 0.95rem; color: var(--color-muted);">
            Meta: 100%
        </div>
        @if($notes)
        <p class="goal-note mt-2 mb-0"><i class="bi bi-sticky"></i>{{ $notes }}</p>
        @endif
    </div>
    @elseif($trackingType === 'status')
    <!-- Horizontal Status Bar design -->
    <div class="mt-3 card-graph">
        @php
        $statusLabels = [
        'NOT_STARTED' => 'Não iniciado',
        'IN_PROGRESS' => 'Em andamento',
        'COMPLETED' => 'Concluído',
        'PENDING' => 'Não iniciado',
        'ACHIEVED' => 'Concluído',
        'CANCELLED' => 'Não iniciado',
        ];
        $statusPosition = [
        'NOT_STARTED' => 0,
        'PENDING' => 0,
        'IN_PROGRESS' => 50,
        'COMPLETED' => 100,
        'ACHIEVED' => 100,
        'CANCELLED' => 0,
        ];
        @endphp

        <div class="mb-4">
            <!-- Horizontal progress track -->
            <div class="position-relative mb-3" style="height: 28px;">
                <div class="d-flex" style="height: 100%;">
                    <div class="flex-1 rounded-start" style="background-color: #A1A1AA; @if(in_array($status, ['IN_PROGRESS', 'COMPLETED', 'ACHIEVED'])) background-color: #3B82F6; @endif"></div>
                    <div class="flex-1" style="background-color: #D4D4D8; @if(in_array($status, ['COMPLETED', 'ACHIEVED'])) background-color: #3B82F6; @endif"></div>
                    <div class="flex-1 rounded-end" style="background-color: #E5E7EB; @if(in_array($status, ['COMPLETED', 'ACHIEVED'])) background-color: #22C55E; @endif"></div>
                </div>
                <!-- Triangle indicator -->
                <div class="position-absolute" style="top: 100%; left: {{ $statusPosition[$status] ?? 0 }}%; transform: translateX(-50%); margin-top: 4px;">
                    <div style="width: 0; height: 0; border-left: 10px solid transparent; border-right: 10px solid transparent; border-top: 10px solid #3B82F6;"></div>
                </div>
            </div>

            <!-- Status labels below track -->
            <div class="d-flex justify-content-between gap-3">
                <span class="fw-semibold" style="font-size: 0.9rem; color: {{ in_array($status, ['NOT_STARTED', 'PENDING', 'CANCELLED']) ? '#3B82F6' : '#71717A' }};">
                    Não iniciado
                </span>
                <span class="fw-semibold" style="font-size: 0.9rem; color: {{ $status === 'IN_PROGRESS' ? '#3B82F6' : '#71717A' }};">
                    Em andamento
                </span>
                <span class="fw-semibold" style="font-size: 0.9rem; color: {{ in_array($status, ['COMPLETED', 'ACHIEVED']) ? '#22C55E' : '#71717A' }};">
                    Concluído
                </span>
            </div>
        </div>

        @if($notes)
        <p class="goal-note mt-3 mb-0"><i class="bi bi-sticky"></i>{{ $notes }}</p>
        @endif
    </div>
    @endif
</div>