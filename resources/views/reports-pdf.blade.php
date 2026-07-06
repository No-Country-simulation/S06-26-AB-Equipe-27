<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório - SkillFocus</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #2B2B2B;
        }

        h1,
        h2,
        h3 {
            color: #4A148C;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .progress-bar {
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(to right, #4A148C, #7C3AED);
        }

        .badge {
            padding: 4px 8px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-low {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-medium {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-high {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>

<body>
    <h1>Relatório Analítico de Diversidade</h1>
    <p>Data: {{ now()->format('d/m/Y') }}</p>

    <div class="card">
        <h2>Pontuação de Diversidade</h2>
        <p style="font-size: 48px; font-weight: bold;">{{ $diversityScore ?? 0 }}/100</p>
        <div class="progress-bar">
            <div class="progress-fill" style="width: {{ $diversityScore ?? 0 }}%"></div>
        </div>
    </div>

    <div class="card">
        <h2>Metas ESG</h2>
        @if($esgGoals->count() > 0)
        @foreach($esgGoals as $goal)
        <div style="margin-bottom: 16px;">
            <h4>{{ $goal->title }}</h4>
            @if($goal->tracking_type === 'percentage')
            @php
            $percentage = min($goal->current_value ?? 0, 100);
            @endphp
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $percentage }}%"></div>
            </div>
            <p>{{ $percentage }}%</p>
            @elseif($goal->tracking_type === 'count')
            @php
            $target = $goal->target_value ?? 1;
            $current = $goal->current_value ?? 0;
            $percentage = min(100, ($current / $target) * 100);
            @endphp
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $percentage }}%"></div>
            </div>
            <p>{{ $current }}/{{ $target }}</p>
            @elseif($goal->tracking_type === 'status')
            @php
            $statusLabel = [
            'not_started' => 'Não Iniciado',
            'in_progress' => 'Em Andamento',
            'completed' => 'Concluído',
            ];
            @endphp
            <span class="badge badge-{{ $goal->status }}">{{ $statusLabel[$goal->status] ?? 'Desconhecido' }}</span>
            @endif
        </div>
        @endforeach
        @else
        <p>Nenhuma meta definida ainda</p>
        @endif
    </div>

    <div class="card">
        <h2>Prioridades de Diversidade</h2>
        @if($diversityGoals->count() > 0)
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
        'low' => 'BAIXA',
        'medium' => 'MÉDIA',
        'high' => 'ALTA'
        ];
        @endphp
        @foreach($diversityGoals as $goal)
        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
            <span>{{ $groupLabels[$goal->group] ?? ucwords(str_replace('_', ' ', $goal->group)) }}</span>
            <span class="badge badge-{{ $goal->priority }}">{{ $priorityLabels[$goal->priority] ?? $goal->priority }}</span>
        </div>
        @endforeach
        @else
        <p>Nenhuma prioridade definida</p>
        @endif
    </div>

    <div class="card">
        <h2>Recomendação IA</h2>
        <p style="font-size: 48px; font-weight: bold; color: #FF6D00;">{{ $highScoreMatchings }}</p>
        <p>profissionais com alta compatibilidade</p>

        <h4 style="margin-top: 16px;">Principais regiões mapeadas:</h4>
        <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px;">
            @foreach($topRegions as $region)
            <span style="padding: 4px 12px; border-radius: 9999px; background: #fff7ed; color: #EA580C; border: 1px solid #fed7aa; font-size: 14px;">
                {{ $region }}
            </span>
            @endforeach
        </div>
    </div>
</body>

</html>
