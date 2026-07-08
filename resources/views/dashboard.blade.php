<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SkillFocus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        /* ==========================================================
           SKILLFOCUS — DESIGN TOKENS
           Idênticos às demais views (Vagas, Progresso ESG, Mapa de Calor).
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
            --color-danger: #DC2626;
            --color-danger-soft: #FDEDEC;

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
            overflow-x: hidden;
        }

        h1, h2, h3, .font-display { font-family: var(--font-display); }
        a { text-decoration: none; }

        /* ==========================================================
           NAVBAR
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
            width: 36px; height: 36px;
            border-radius: 100%;
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            font-weight: 700;
            font-size: 0.8rem;
            display: flex; align-items: center; justify-content: center;
        }

        .user-name-pill { font-size: 0.85rem; font-weight: 600; color: var(--color-ink); }

        .dropdown-menu {
            border: 1px solid var(--color-border);
            box-shadow: var(--shadow-pop);
            border-radius: var(--radius-sm);
        }

        @media (max-width: 991.98px) {
            .navbar-collapse.show {
                margin-top: 0.85rem;
                padding-top: 0.85rem;
                padding-bottom: 0.5rem;
                border-top: 1px solid var(--color-border);
                max-height: 75vh;
                overflow-y: auto;
            }
            .navbar-nav { width: 100%; gap: 0.35rem; }
            .nav-link-custom { width: 100%; }
            .navbar-actions {
                width: 100%;
                justify-content: flex-start;
                margin-top: 0.75rem;
                padding-top: 0.75rem;
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
        .page-heading h1 { font-size: 1.85rem; font-weight: 700; color: var(--color-ink); letter-spacing: -0.02em; }
        .page-heading p { color: var(--color-muted); font-size: 0.95rem; }

        /* ---------------- Base de card ---------------- */
        .dash-card {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 1.5rem;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        /* ---------------- Alerta de configuração pendente ---------------- */
        .setup-alert {
            background-color: var(--color-shield-warn-soft);
            border: 1px solid rgba(180,83,9,.22);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 1.35rem 1.5rem;
        }

        .setup-alert .icon-wrap {
            width: 52px; height: 52px;
            border-radius: 15px;
            background-color: #fff;
            color: var(--color-shield-warn);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            box-shadow: var(--shadow-card);
        }

        .setup-alert h3 { font-size: 1.05rem; font-weight: 700; color: var(--color-ink); }
        .setup-alert p { color: var(--color-body); font-size: 0.9rem; margin: 0; }

        .btn-setup {
            background: linear-gradient(155deg, var(--color-shield-warn), #8A3E07);
            color: #fff;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 0.65rem 1.4rem;
            border-radius: var(--radius-sm);
            white-space: nowrap;
            box-shadow: 0 10px 22px -10px rgba(180,83,9,.55);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .btn-setup:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 14px 26px -10px rgba(180,83,9,.65); }

        /* ---------------- Cards de ação rápida ---------------- */
        .action-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 4px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-shield));
            opacity: 0;
            transition: opacity .2s ease;
        }

        .action-card:hover {
            box-shadow: var(--shadow-card-hover);
            transform: translateY(-3px);
            border-color: rgba(124,58,237,.25);
        }
        .action-card:hover::before { opacity: 1; }

        .action-card h3 { font-family: var(--font-display); font-size: 1.02rem; font-weight: 600; color: var(--color-ink); margin: 0; }
        .action-card p { font-size: 0.85rem; color: var(--color-muted); margin: 0.2rem 0 0; }

        .action-card .arrow-hint {
            margin-left: auto;
            color: var(--color-border);
            font-size: 1.1rem;
            transition: color .18s ease, transform .18s ease;
        }
        .action-card:hover .arrow-hint { color: var(--color-primary); transform: translateX(3px); }

        .icon-box {
            width: 54px; height: 54px;
            border-radius: 15px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
        .icon-box-sm { width: 44px; height: 44px; border-radius: 12px; font-size: 1.15rem; }

        .icon-purple { background-color: var(--color-primary-soft); color: var(--color-primary); }
        .icon-blue   { background-color: var(--level-senior-bg);    color: var(--level-senior-fg); }
        .icon-green  { background-color: var(--color-shield-soft);  color: var(--color-shield); }
        .icon-amber  { background-color: var(--color-shield-warn-soft); color: var(--color-shield-warn); }

        /* ---------------- Cabeçalho padrão de widget ---------------- */
        .widget-header {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            margin-bottom: 1.25rem;
        }
        .widget-header h3 {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--color-ink);
            margin: 0;
        }
        .widget-header p {
            font-size: 0.8rem;
            color: var(--color-muted);
            margin: 0.1rem 0 0;
        }

        /* ---------------- Score de diversidade ---------------- */
        .score-card { text-align: center; display: flex; flex-direction: column; }
        .score-value {
            font-family: var(--font-display);
            font-size: 3.1rem;
            font-weight: 800;
            color: var(--color-primary-dark);
            line-height: 1;
        }
        .score-max { font-size: 1.3rem; color: #C9C5DC; font-weight: 700; }
        .score-track {
            background-color: var(--color-primary-soft);
            border-radius: 999px;
            height: 10px;
            overflow: hidden;
            margin: 1rem 0 0.75rem;
        }
        .score-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-primary-dark));
        }
        .score-caption { font-size: 0.85rem; color: var(--color-shield); font-weight: 700; }

        /* ---------------- Metas ESG (mini lista) ---------------- */
        .mini-goal-list {
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
            max-height: 260px;
            overflow-y: auto;
            padding-right: 0.25rem;
        }
        .mini-goal-list::-webkit-scrollbar { width: 6px; }
        .mini-goal-list::-webkit-scrollbar-thumb { background-color: var(--color-border); border-radius: 999px; }

        .mini-goal {
            background-color: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            padding: 0.8rem 0.95rem;
        }
        .mini-goal-title { font-weight: 600; font-size: 0.85rem; color: var(--color-ink); margin-bottom: 0.55rem; }
        .mini-progress-track {
            background-color: var(--color-primary-soft);
            border-radius: 999px;
            height: 6px;
            flex: 1;
            overflow: hidden;
        }
        .mini-progress-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-shield));
        }
        .mini-progress-value { font-size: 0.72rem; font-weight: 700; color: var(--color-muted); white-space: nowrap; }

        .mini-status {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
        }
        .mini-status.st-not-started { background-color: #F1F0F6; color: var(--color-muted); }
        .mini-status.st-in-progress { background-color: var(--level-senior-bg); color: var(--level-senior-fg); }
        .mini-status.st-completed   { background-color: var(--color-shield-soft); color: var(--color-shield); }

        .empty-mini { text-align: center; color: var(--color-muted); font-size: 0.85rem; padding: 1.5rem 0; }

        /* ---------------- Prioridades de diversidade ---------------- */
        .priority-list { display: flex; flex-direction: column; }
        .priority-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px dashed var(--color-border);
        }
        .priority-row:last-child { border-bottom: none; padding-bottom: 0; }
        .priority-row:first-child { padding-top: 0; }
        .priority-label { font-weight: 600; font-size: 0.88rem; color: var(--color-ink); }
        .priority-pill {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            padding: 0.32rem 0.75rem;
            border-radius: 999px;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .priority-high   { background-color: var(--color-danger-soft); color: var(--color-danger); }
        .priority-medium { background-color: var(--color-shield-warn-soft); color: var(--color-shield-warn); }
        .priority-low    { background-color: var(--color-shield-soft); color: var(--color-shield); }

        /* ---------------- Tabela de vagas ---------------- */
        .table-widget { padding: 1.5rem 1.5rem 0.5rem; }
        .table-skillfocus-wrap { overflow-x: auto; border-radius: var(--radius-md); border: 1px solid var(--color-border); }

        .table-skillfocus { width: 100%; border-collapse: collapse; margin: 0; }
        .table-skillfocus thead th {
            background-color: var(--color-primary-softer);
            color: var(--color-muted);
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-weight: 700;
            border: none;
            padding: 0.9rem 1.1rem;
            text-align: left;
        }
        .table-skillfocus thead th:last-child { text-align: right; }
        .table-skillfocus tbody td {
            padding: 0.9rem 1.1rem;
            border-top: 1px solid var(--color-border);
            font-size: 0.87rem;
            color: var(--color-body);
            vertical-align: middle;
        }
        .table-skillfocus tbody tr:hover { background-color: var(--color-primary-softer); }

        .job-title-chip {
            background-color: var(--color-primary-soft);
            color: var(--color-primary-dark);
            font-weight: 600;
            font-size: 0.83rem;
            padding: 0.35rem 0.85rem;
            border-radius: var(--radius-sm);
            display: inline-block;
        }
        .badge-aberto {
            background-color: var(--color-shield-soft);
            color: var(--color-shield);
            font-weight: 700;
            font-size: 0.72rem;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .skill-pill {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            color: var(--color-body);
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.28rem 0.65rem;
            border-radius: 0.5rem;
            display: inline-block;
            margin: 0.12rem;
        }
        .btn-ver-vagas {
            width: 34px; height: 34px;
            border-radius: 10px;
            background-color: var(--color-primary-softer);
            color: var(--color-primary);
            display: inline-flex; align-items: center; justify-content: center;
            border: none;
            transition: all .15s ease;
        }
        .btn-ver-vagas:hover { background-color: var(--color-primary); color: #fff; }

        /* ---------------- Recomendação de IA ---------------- */
        .ai-card { text-align: center; display: flex; flex-direction: column; justify-content: space-between; height: 100%; }
        .ai-value { font-family: var(--font-display); font-size: 2.6rem; font-weight: 800; color: var(--color-shield-warn); line-height: 1; }
        .ai-caption { font-size: 0.85rem; color: var(--color-muted); font-weight: 600; margin: 0.35rem 0 1.35rem; }
        .ai-regions-box {
            background-color: var(--color-shield-warn-soft);
            border: 1px solid rgba(180,83,9,.16);
            border-radius: var(--radius-md);
            padding: 1rem;
        }
        .ai-regions-title { font-size: 0.82rem; font-weight: 700; color: var(--color-ink); margin-bottom: 0.7rem; }
        .region-chip {
            background-color: var(--color-surface);
            border: 1px solid rgba(180,83,9,.25);
            color: var(--color-shield-warn);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.35rem 0.75rem;
            border-radius: var(--radius-sm);
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            box-shadow: var(--shadow-card);
            margin: 0.2rem;
        }

        /* ==========================================================
           MAPA DE CALOR
        ========================================================== */
        .heatmap-card { padding: 1.5rem 1.5rem 1.75rem; }

        .heatmap-head {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.1rem;
        }
        .heatmap-head h3 { font-family: var(--font-display); font-size: 1.2rem; font-weight: 600; color: var(--color-ink); margin-bottom: 0.25rem; }
        .heatmap-head p { font-size: 0.88rem; color: var(--color-muted); margin: 0; }

        .badge-map {
            background-color: var(--color-shield-soft);
            color: var(--color-shield);
            font-size: 0.76rem;
            font-weight: 700;
            padding: 0.4rem 0.85rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            white-space: nowrap;
        }
        .badge-map .pulse-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background-color: var(--color-shield);
            box-shadow: 0 0 0 0 rgba(13,148,136,.55);
            animation: pulse-dot 1.8s infinite;
        }
        @keyframes pulse-dot {
            0%   { box-shadow: 0 0 0 0 rgba(13,148,136,.5); }
            70%  { box-shadow: 0 0 0 7px rgba(13,148,136,0); }
            100% { box-shadow: 0 0 0 0 rgba(13,148,136,0); }
        }

        .heatmap-stats { display: flex; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 1rem; }
        .heatmap-stat-chip {
            display: flex; align-items: center; gap: 0.5rem;
            background-color: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            padding: 0.55rem 0.9rem;
            font-size: 0.82rem;
            color: var(--color-body);
        }
        .heatmap-stat-chip strong { color: var(--color-ink); font-weight: 700; }
        .heatmap-stat-chip i { color: var(--color-primary); font-size: 0.95rem; }

        .map-frame { position: relative; border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--color-border); }
        #map-heatmap { height: 460px; width: 100%; z-index: 1; background-color: #EFEDF7; }

        .map-loading {
            position: absolute; inset: 0; z-index: 2;
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.6rem;
            background-color: var(--color-bg);
            color: var(--color-muted);
            font-size: 0.85rem;
            transition: opacity .3s ease;
        }
        .map-loading .spinner-border { width: 1.6rem; height: 1.6rem; color: var(--color-primary); }
        .map-loading.is-hidden { opacity: 0; pointer-events: none; }

        .map-legend {
            position: absolute; left: 14px; bottom: 14px; z-index: 2;
            background-color: rgba(255,255,255,.92);
            backdrop-filter: blur(6px);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            padding: 0.6rem 0.85rem;
            box-shadow: var(--shadow-pop);
            font-size: 0.72rem;
            color: var(--color-muted);
        }
        .map-legend .legend-title { font-weight: 700; color: var(--color-ink); font-size: 0.72rem; margin-bottom: 0.35rem; }
        .map-legend .legend-bar {
            width: 140px; height: 8px; border-radius: 999px;
            background: linear-gradient(90deg, #BFDBFE 0%, #60A5FA 30%, #2563EB 55%, var(--color-primary) 80%, #4C1D95 100%);
            margin-bottom: 0.3rem;
        }
        .map-legend .legend-labels { display: flex; justify-content: space-between; }

        .leaflet-popup-content-wrapper { border-radius: var(--radius-sm) !important; box-shadow: var(--shadow-pop) !important; }
        .leaflet-popup-content { font-family: var(--font-body); font-size: 0.82rem; color: var(--color-ink); margin: 0.6rem 0.8rem !important; }
        .leaflet-popup-content strong { font-family: var(--font-display); }

        /* ---------------- Geografia da Inclusão ---------------- */
        .subtitle-badge {
            color: var(--color-primary);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.78rem;
            display: block;
            margin-bottom: 0.6rem;
        }
        .section-title { color: var(--color-ink); font-family: var(--font-display); font-weight: 700; font-size: 1.9rem; margin-bottom: 1rem; letter-spacing: -0.02em; }
        .section-text { color: var(--color-muted); font-size: 1rem; line-height: 1.65; }

        .btn-section-link {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            border-radius: var(--radius-sm);
            font-weight: 600;
            padding: 0.65rem 1.35rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            box-shadow: 0 10px 22px -10px rgba(124,58,237,.6);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .btn-section-link:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 14px 26px -10px rgba(124,58,237,.7); }

        .img-box { border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--shadow-card); border: 1px solid var(--color-border); }
        .img-box img { width: 100%; height: 320px; object-fit: cover; transition: transform 0.5s ease; display: block; }
        .img-box:hover img { transform: scale(1.03); }

        @media (max-width: 575.98px) {
            #map-heatmap { height: 340px; }
            .map-legend { left: 10px; bottom: 10px; padding: 0.5rem 0.65rem; }
            .map-legend .legend-bar { width: 100px; }
        }

        /* ---------------- Footer ---------------- */
        footer { border-top: 1px solid var(--color-border); color: var(--color-muted); font-size: 0.78rem; }
        footer .shield-pill { display: inline-flex; align-items: center; gap: 0.4rem; color: var(--color-shield); font-weight: 600; }
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
                        <a class="nav-link-custom active" href="{{ url('/dashboard') }}">
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
                    <div class="avatar-badge">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end mt-2">
                        <li><a class="dropdown-item py-2" href="{{ route('dashboard') }}"><i class="bi bi-briefcase-fill me-2 text-muted"></i>Dashboard</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('esg-progress.index') }}"><i class="bi bi-bar-chart-fill me-2 text-muted"></i>Progresso ESG</a></li>
                        <li><a class="dropdown-item py-2" href="{{ url('/jobs/create') }}"><i class="bi bi-plus-circle-fill me-2 text-muted"></i>Criar vaga</a></li>
                        <li><a class="dropdown-item py-2" href="{{ url('/jobs') }}"><i class="bi bi-eye-fill me-2 text-muted"></i>Vagas criadas</a></li>
                        <li><a class="dropdown-item py-2" href="{{ url('/jobs/reports') }}"><i class="bi bi-clipboard2-fill me-2 text-muted"></i>Relatórios</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>

    {{-- CONTEÚDO PRINCIPAL --}}
    <main class="container my-5">

        <div class="page-heading mb-4">
            <div class="eyebrow mb-2">Painel geral</div>
            <h1 class="mb-1">Visão Geral</h1>
            <p class="mb-0">Acompanhe o panorama dos seus processos seletivos e o impacto em diversidade</p>
        </div>

        {{-- Alerta de configuração pendente --}}
        @if(!Auth::user()->company || !Auth::user()->company->setup_completed)
        <div class="setup-alert d-flex flex-column flex-md-row align-items-md-center gap-3 mb-4">
            <div class="icon-wrap flex-shrink-0">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="flex-grow-1">
                <h3 class="mb-1">Conclua sua configuração</h3>
                <p>Termine de configurar suas metas de diversidade e ESG para começar</p>
            </div>
            <a href="{{ route('setup.step1') }}" class="btn-setup text-center flex-shrink-0">Iniciar configuração</a>
        </div>
        @endif

        {{-- Cards de ação rápida --}}
        <div class="row g-4 mb-4">
            <div class="col-12 col-md-4">
                <a href="{{ url('/jobs/create') }}" class="dash-card action-card">
                    <div class="icon-box icon-purple"><i class="bi bi-briefcase-fill"></i></div>
                    <div>
                        <h3>Publicar Vaga</h3>
                        <p>Criar uma nova oferta</p>
                    </div>
                    <i class="bi bi-arrow-right arrow-hint"></i>
                </a>
            </div>

            <div class="col-12 col-md-4">
                <a href="{{ url('/mapa-talentos') }}" class="dash-card action-card">
                    <div class="icon-box icon-blue"><i class="bi bi-map-fill"></i></div>
                    <div>
                        <h3>Mapa de Talentos</h3>
                        <p>Ver concentração geográfica</p>
                    </div>
                    <i class="bi bi-arrow-right arrow-hint"></i>
                </a>
            </div>

            <div class="col-12 col-md-4">
                <a href="{{ route('reports.index') }}" class="dash-card action-card">
                    <div class="icon-box icon-green"><i class="bi bi-clipboard2-data-fill"></i></div>
                    <div>
                        <h3>Relatórios</h3>
                        <p>Métricas de diversidade</p>
                    </div>
                    <i class="bi bi-arrow-right arrow-hint"></i>
                </a>
            </div>
        </div>

        {{-- Score, Metas ESG e Prioridades --}}
        <div class="row g-4 mb-4 align-items-stretch">

            {{-- Pontuação de diversidade --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="dash-card h-100 score-card">
                    <div class="widget-header">
                        <div class="icon-box icon-box-sm icon-purple"><i class="bi bi-speedometer2"></i></div>
                        <div>
                            <h3>Pontuação de Diversidade</h3>
                            <p>Índice geral da empresa</p>
                        </div>
                    </div>
                    <div class="flex-grow-1 d-flex flex-column justify-content-center">
                        <div>
                            <span class="score-value">{{ $diversityScore ?? 0 }}</span><span class="score-max">/100</span>
                        </div>
                        <div class="score-track">
                            <div class="score-fill" style="width: {{ $diversityScore ?? 0 }}%"></div>
                        </div>
                        <span class="score-caption">
                            @if(($diversityScore ?? 0) >= 80)
                                Excelente progresso!
                            @elseif(($diversityScore ?? 0) >= 60)
                                Bom progresso!
                            @else
                                Continue avançando!
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Metas ESG --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="dash-card h-100">
                    <div class="widget-header">
                        <div class="icon-box icon-box-sm icon-green"><i class="bi bi-bar-chart-fill"></i></div>
                        <div>
                            <h3>Metas ESG</h3>
                            <p>Progresso das metas ativas</p>
                        </div>
                    </div>

                    <div class="mini-goal-list">
                        @if(Auth::user()->company && Auth::user()->company->esgGoals->count() > 0)
                            @foreach(Auth::user()->company->esgGoals as $goal)
                            <div class="mini-goal">
                                <div class="mini-goal-title">{{ $goal->title }}</div>

                                @if($goal->tracking_type === 'percentage')
                                    @php $percentage = min($goal->current_value ?? 0, 100); @endphp
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="mini-progress-track">
                                            <div class="mini-progress-fill" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="mini-progress-value">{{ $percentage }}%</span>
                                    </div>

                                @elseif($goal->tracking_type === 'count')
                                    @php
                                        $target = $goal->target_value ?? 1;
                                        $current = $goal->current_value ?? 0;
                                        $percentage = min(100, ($current / $target) * 100);
                                    @endphp
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="mini-progress-track">
                                            <div class="mini-progress-fill" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="mini-progress-value">{{ $current }}/{{ $target }}</span>
                                    </div>

                                @elseif($goal->tracking_type === 'status')
                                    @php
                                        $statusLabel = [
                                            'NOT_STARTED' => 'Não iniciado',
                                            'IN_PROGRESS' => 'Em andamento',
                                            'COMPLETED' => 'Concluído',
                                        ];
                                        $statusClass = [
                                            'NOT_STARTED' => 'st-not-started',
                                            'IN_PROGRESS' => 'st-in-progress',
                                            'COMPLETED' => 'st-completed',
                                        ];
                                    @endphp
                                    <span class="mini-status {{ $statusClass[$goal->status] ?? 'st-not-started' }}">
                                        {{ $statusLabel[$goal->status] ?? $goal->status }}
                                    </span>
                                @endif
                            </div>
                            @endforeach
                        @else
                            <div class="empty-mini">Nenhuma meta definida ainda</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Prioridades de diversidade --}}
            <div class="col-12 col-lg-4">
                <div class="dash-card h-100">
                    <div class="widget-header">
                        <div class="icon-box icon-box-sm icon-blue"><i class="bi bi-people-fill"></i></div>
                        <div>
                            <h3>Prioridades de Diversidade</h3>
                            <p>Grupos priorizados na triagem</p>
                        </div>
                    </div>

                    <div class="priority-list">
                        @if(Auth::user()->company && Auth::user()->company->diversityGoals->count() > 0)
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
                                $priorityLabels = ['low' => 'Baixa', 'medium' => 'Regular', 'high' => 'Alta'];
                                $priorityClass = ['low' => 'priority-low', 'medium' => 'priority-medium', 'high' => 'priority-high'];
                            @endphp
                            @foreach(Auth::user()->company->diversityGoals->take(4) as $goal)
                            <div class="priority-row">
                                <span class="priority-label">{{ $groupLabels[$goal->group] ?? ucwords(str_replace('_', ' ', $goal->group)) }}</span>
                                <span class="priority-pill {{ $priorityClass[$goal->priority] ?? 'priority-low' }}">
                                    {{ $priorityLabels[$goal->priority] ?? $goal->priority }}
                                </span>
                            </div>
                            @endforeach
                        @else
                            <div class="empty-mini">Nenhuma prioridade definida</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabela de vagas e Recomendação de IA --}}
        <div class="row g-4 mb-4 align-items-start">

            <div class="col-12 col-lg-8">
                <div class="dash-card table-widget h-100">
                    <div class="widget-header">
                        <div class="icon-box icon-box-sm icon-amber"><i class="bi bi-briefcase-fill"></i></div>
                        <div>
                            <h3>Vagas Públicas &amp; Andamentos</h3>
                            <p>Monitore o andamento dos processos seletivos sem vieses</p>
                        </div>
                    </div>

                    <div class="table-skillfocus-wrap mb-4">
                        <table class="table-skillfocus">
                            <thead>
                                <tr>
                                    <th>Cargo</th>
                                    <th>Cidade</th>
                                    <th>Status</th>
                                    <th>Skills</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jobs as $job)
                                <tr>
                                    <td><span class="job-title-chip">{{ $job->title }}</span></td>
                                    <td>{{ $job->city }}</td>
                                    <td><span class="badge-aberto"><i class="bi bi-circle-fill" style="font-size:.5rem;"></i> Aberto</span></td>
                                    <td>
                                        @if(!empty($job->required_skills))
                                            @php
                                                $skills = is_array($job->required_skills) ? $job->required_skills : json_decode($job->required_skills, true);
                                            @endphp
                                            @if(is_iterable($skills))
                                                @foreach($skills as $skill)
                                                    <span class="skill-pill">{{ $skill }}</span>
                                                @endforeach
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ url('/jobs') }}">
                                            <button type="button" class="btn-ver-vagas" title="Ver Vagas">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="dash-card ai-card">
                    <div>
                        <div class="widget-header justify-content-center">
                            <div class="icon-box icon-box-sm icon-amber"><i class="bi bi-stars"></i></div>
                            <div>
                                <h3>Recomendação IA</h3>
                            </div>
                        </div>
                        <div class="ai-value">{{ $highScoreMatchings }}</div>
                        <p class="ai-caption">profissionais com alta compatibilidade</p>

                        <div class="ai-regions-box">
                            <div class="ai-regions-title">Principais regiões mapeadas</div>
                            <div>
                                @foreach ($topRegions as $region)
                                <span class="region-chip"><i class="bi bi-geo-alt-fill"></i> {{ $region->city }}</span>
                                @endforeach
                            </div>
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
</body>
</html>
