<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório - SkillFocus</title>
    <style>
        /* ==========================================================
           SKILLFOCUS — DESIGN TOKENS
           Mesma paleta/raios usados nas demais views do produto.
           CSS 100% autocontido (sem fontes/ícones externos), pois
           este template é renderizado para PDF/impressão.
        ========================================================== */
        :root {
            --color-primary: #7C3AED;
            --color-primary-dark: #5B21B6;
            --color-primary-soft: #F3EEFE;

            --color-shield: #0D9488;
            --color-shield-soft: #E8F8F6;
            --color-shield-warn: #B45309;
            --color-shield-warn-soft: #FEF6E7;
            --color-danger: #991B1B;
            --color-danger-soft: #FEE2E2;

            --color-ink: #17152A;
            --color-body: #47435C;
            --color-muted: #77738F;
            --color-border: #E9E5F3;
            --color-bg: #FAF9FD;

            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 18px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: -apple-system, 'Segoe UI', Helvetica, Arial, sans-serif;
            color: var(--color-body);
            background-color: #ffffff;
            margin: 0;
            padding: 36px 44px 48px;
            font-size: 14px;
            line-height: 1.5;
        }

        h1, h2, h3, h4 {
            font-family: -apple-system, 'Segoe UI', Helvetica, Arial, sans-serif;
            color: var(--color-ink);
            margin: 0;
        }

        /* ---------------- Cabeçalho do relatório ---------------- */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid var(--color-border);
            padding-bottom: 20px;
            margin-bottom: 28px;
        }

        .brand-row { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }

        .brand-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            display: inline-block;
        }

        .brand-name {
            font-weight: 700;
            font-size: 16px;
            color: var(--color-ink);
            letter-spacing: -0.01em;
        }
        .brand-name span { color: var(--color-primary); }

        .eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--color-primary);
            margin-bottom: 6px;
        }

        .report-header h1 { font-size: 24px; font-weight: 700; letter-spacing: -0.01em; }

        .report-meta {
            text-align: right;
            font-size: 12px;
            color: var(--color-muted);
        }

        .report-meta .confidential {
            display: inline-block;
            margin-top: 8px;
            background-color: var(--color-primary-soft);
            color: var(--color-primary-dark);
            font-weight: 700;
            font-size: 10px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 999px;
        }

        /* ---------------- Cards de seção ---------------- */
        .card {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 22px 24px;
            margin-bottom: 20px;
            background-color: #ffffff;
            page-break-inside: avoid;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .card-icon {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            flex-shrink: 0;
            text-align: center;
            line-height: 30px;
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
        }
        .card-icon.purple { background-color: var(--color-primary); }
        .card-icon.green  { background-color: var(--color-shield); }
        .card-icon.amber  { background-color: var(--color-shield-warn); }

        .card-header h2 {
            font-size: 15px;
            font-weight: 700;
            color: var(--color-ink);
        }

        /* ---------------- Pontuação de diversidade ---------------- */
        .score-row { display: flex; align-items: baseline; gap: 6px; margin-bottom: 12px; }
        .score-number { font-size: 40px; font-weight: 700; color: var(--color-primary-dark); }
        .score-of100 { font-size: 18px; color: #C9C5DC; font-weight: 700; }

        .progress-bar {
            height: 9px;
            background-color: var(--color-primary-soft);
            border-radius: 999px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(to right, var(--color-primary-dark), var(--color-primary));
        }
        .progress-fill.shield { background: linear-gradient(to right, var(--color-primary), var(--color-shield)); }

        .score-caption { font-size: 12px; font-weight: 700; color: var(--color-shield); margin-top: 8px; }

        /* ---------------- Metas ESG ---------------- */
        .goal-row {
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            background-color: var(--color-bg);
            padding: 12px 14px;
            margin-bottom: 10px;
        }
        .goal-row:last-child { margin-bottom: 0; }
        .goal-row h4 { font-size: 13px; font-weight: 600; color: var(--color-ink); margin-bottom: 8px; }

        .goal-progress-line { display: flex; align-items: center; gap: 10px; }
        .goal-progress-line .progress-bar { flex: 1; }
        .goal-progress-value { font-size: 11px; font-weight: 700; color: var(--color-muted); white-space: nowrap; }

        /* ---------------- Badges de status/prioridade ---------------- */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .badge-not_started { background-color: #F1F0F6; color: var(--color-muted); }
        .badge-in_progress { background-color: #E9F1FE; color: #1D4ED8; }
        .badge-completed   { background-color: var(--color-shield-soft); color: var(--color-shield); }

        .badge-low    { background-color: var(--color-shield-soft); color: var(--color-shield); }
        .badge-medium { background-color: var(--color-shield-warn-soft); color: var(--color-shield-warn); }
        .badge-high   { background-color: var(--color-danger-soft); color: var(--color-danger); }

        /* ---------------- Prioridades de diversidade ---------------- */
        .priority-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 1px dashed var(--color-border);
        }
        .priority-row:last-child { border-bottom: none; padding-bottom: 0; }
        .priority-row:first-child { padding-top: 0; }
        .priority-label { font-size: 13px; font-weight: 600; color: var(--color-ink); }

        /* ---------------- Recomendação de IA ---------------- */
        .ai-number { font-size: 40px; font-weight: 700; color: var(--color-shield-warn); margin-bottom: 2px; }
        .ai-caption { font-size: 12px; color: var(--color-muted); font-weight: 600; margin-bottom: 16px; }

        .ai-regions-box {
            background-color: var(--color-shield-warn-soft);
            border: 1px solid #F0DCB8;
            border-radius: var(--radius-md);
            padding: 14px;
        }
        .ai-regions-title { font-size: 12px; font-weight: 700; color: var(--color-ink); margin-bottom: 10px; }

        .region-chip {
            display: inline-block;
            padding: 5px 12px;
            border-radius: var(--radius-sm);
            background-color: #ffffff;
            border: 1px solid #EAC98E;
            color: var(--color-shield-warn);
            font-size: 11px;
            font-weight: 700;
            margin: 3px 4px 3px 0;
        }

        .empty-text { color: var(--color-muted); font-size: 13px; margin: 0; }

        /* ---------------- Rodapé ---------------- */
        .report-footer {
            margin-top: 28px;
            padding-top: 16px;
            border-top: 1px solid var(--color-border);
            font-size: 11px;
            color: var(--color-muted);
            display: flex;
            justify-content: space-between;
        }
        .report-footer .shield-note { color: var(--color-shield); font-weight: 700; }
    </style>
</head>

<body>

    <div class="report-header">
        <div>
            <div class="brand-row">
                <span class="brand-icon"></span>
                <span class="brand-name">Skill<span>Focus</span></span>
            </div>
            <div class="eyebrow">Recrutamento & seleção</div>
            <h1>Relatório Analítico de Diversidade</h1>
        </div>
        <div class="report-meta">
            Gerado em<br>
            <strong style="color: var(--color-ink); font-size: 13px;">{{ now()->format('d/m/Y') }}</strong>
            <br>
            <span class="confidential">Confidencial</span>
        </div>
    </div>

    {{-- Pontuação de diversidade --}}
    <div class="card">
        <div class="card-header">
            <h2>Pontuação de Diversidade</h2>
        </div>

        <div class="score-row">
            <span class="score-number">{{ $diversityScore ?? 0 }}</span>
            <span class="score-of100">/100</span>
        </div>
        <div class="progress-bar">
            <div class="progress-fill" style="width: {{ $diversityScore ?? 0 }}%"></div>
        </div>
        <p class="score-caption">
            @if(($diversityScore ?? 0) >= 80)
                Excelente progresso!
            @elseif(($diversityScore ?? 0) >= 60)
                Bom progresso!
            @else
                Continue avançando!
            @endif
        </p>
    </div>

    {{-- Metas ESG --}}
    <div class="card">
        <div class="card-header">
            <h2>Metas ESG</h2>
        </div>

        @if($esgGoals->count() > 0)
            @foreach($esgGoals as $goal)
            <div class="goal-row">
                <h4>{{ $goal->title }}</h4>

                @if($goal->tracking_type === 'percentage')
                    @php $percentage = min($goal->current_value ?? 0, 100); @endphp
                    <div class="goal-progress-line">
                        <div class="progress-bar"><div class="progress-fill shield" style="width: {{ $percentage }}%"></div></div>
                        <span class="goal-progress-value">{{ $percentage }}%</span>
                    </div>

                @elseif($goal->tracking_type === 'count')
                    @php
                        $target = $goal->target_value ?? 1;
                        $current = $goal->current_value ?? 0;
                        $percentage = min(100, ($current / $target) * 100);
                    @endphp
                    <div class="goal-progress-line">
                        <div class="progress-bar"><div class="progress-fill shield" style="width: {{ $percentage }}%"></div></div>
                        <span class="goal-progress-value">{{ $current }}/{{ $target }}</span>
                    </div>

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
            <p class="empty-text">Nenhuma meta definida ainda</p>
        @endif
    </div>

    {{-- Prioridades de diversidade --}}
    <div class="card">
        <div class="card-header">
            <h2>Prioridades de Diversidade</h2>
        </div>

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
                    'neurodivergent' => 'Neurodivergentes',
                ];
                $priorityLabels = ['low' => 'BAIXA', 'medium' => 'MÉDIA', 'high' => 'ALTA'];
            @endphp
            @foreach($diversityGoals as $goal)
            <div class="priority-row">
                <span class="priority-label">{{ $groupLabels[$goal->group] ?? ucwords(str_replace('_', ' ', $goal->group)) }}</span>
                <span class="badge badge-{{ $goal->priority }}">{{ $priorityLabels[$goal->priority] ?? $goal->priority }}</span>
            </div>
            @endforeach
        @else
            <p class="empty-text">Nenhuma prioridade definida</p>
        @endif
    </div>

    {{-- Recomendação IA --}}
    <div class="card">
        <div class="card-header">
            <h2>Recomendação IA</h2>
        </div>

        <div class="ai-number">{{ $highScoreMatchings }}</div>
        <p class="ai-caption">profissionais com alta compatibilidade</p>

        <div class="ai-regions-box">
            <div class="ai-regions-title">Principais regiões mapeadas</div>
            <div>
                @foreach($topRegions as $region)
                <span class="region-chip">{{ $region }}</span>
                @endforeach
            </div>
        </div>
    </div>

    <div class="report-footer">
        <span>© {{ now()->format('Y') }} SkillFocus — Plataforma de RH com foco em diversidade</span>
        <span class="shield-note">Bias Shield ativo</span>
    </div>

</body>

</html>