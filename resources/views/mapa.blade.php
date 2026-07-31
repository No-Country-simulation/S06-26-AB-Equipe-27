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
           Idênticos a jobs.blade.php, login.blade.php e register.blade.php.
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

            --color-ink: #17152A;
            --color-body: #47435C;
            --color-muted: #77738F;
            --color-border: #E9E5F3;
            --color-surface: #FFFFFF;
            --color-bg: #FAF9FD;

            --level-junior-bg: #E7F8EF;
            --level-junior-fg: #157A47;
            --level-pleno-bg: #F3EEFE;
            --level-pleno-fg: #6D28D9;
            --level-senior-bg: #E9F1FE;
            --level-senior-fg: #1D4ED8;
            --level-gestao-bg: #FDF1DF;
            --level-gestao-fg: #B45309;

            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 22px;
            --shadow-card: 0 1px 2px rgba(23, 21, 42, .04), 0 10px 28px -14px rgba(23, 21, 42, .14);
            --shadow-card-hover: 0 18px 36px -14px rgba(124, 58, 237, .28);
            --shadow-pop: 0 12px 32px -8px rgba(23, 21, 42, .16);

            --font-display: 'Sora', 'Inter', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        * {
            -webkit-font-smoothing: antialiased;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--color-bg);
            background-image:
                radial-gradient(circle at 100% 0%, rgba(124, 58, 237, .06), transparent 45%),
                radial-gradient(circle at 0% 20%, rgba(13, 148, 136, .045), transparent 40%);
            background-attachment: fixed;
            color: var(--color-body);
            overflow-x: hidden;
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

        /* ---------------- Cards de ação rápida ---------------- */
        .dash-card {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: 1.5rem;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

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
            border-color: rgba(124, 58, 237, .25);
        }

        .action-card:hover::before {
            opacity: 1;
        }

        .action-card h3 {
            font-family: var(--font-display);
            font-size: 1.02rem;
            font-weight: 600;
            color: var(--color-ink);
            margin: 0;
        }

        .action-card p {
            font-size: 0.85rem;
            color: var(--color-muted);
            margin: 0.2rem 0 0;
        }

        .action-card .arrow-hint {
            margin-left: auto;
            color: var(--color-border);
            font-size: 1.1rem;
            transition: color .18s ease, transform .18s ease;
        }

        .action-card:hover .arrow-hint {
            color: var(--color-primary);
            transform: translateX(3px);
        }

        .icon-box {
            width: 54px;
            height: 54px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .icon-purple {
            background-color: var(--color-primary-soft);
            color: var(--color-primary);
        }

        .icon-blue {
            background-color: var(--level-senior-bg);
            color: var(--level-senior-fg);
        }

        .icon-green {
            background-color: var(--color-shield-soft);
            color: var(--color-shield);
        }

        /* ==========================================================
           MAPA DE CALOR — seção de destaque do dashboard
        ========================================================== */
        .heatmap-card {
            padding: 1.5rem 1.5rem 1.75rem;
        }

        .heatmap-head {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.1rem;
        }

        .heatmap-head h3 {
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--color-ink);
            margin-bottom: 0.25rem;
        }

        .heatmap-head p {
            font-size: 0.88rem;
            color: var(--color-muted);
            margin: 0;
        }

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
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: var(--color-shield);
            box-shadow: 0 0 0 0 rgba(13, 148, 136, .55);
            animation: pulse-dot 1.8s infinite;
        }

        @keyframes pulse-dot {
            0% {
                box-shadow: 0 0 0 0 rgba(13, 148, 136, .5);
            }

            70% {
                box-shadow: 0 0 0 7px rgba(13, 148, 136, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(13, 148, 136, 0);
            }
        }

        /* Faixa de estatísticas rápidas, calculada a partir dos próprios
           pontos do mapa — não é decoração solta, é leitura direta do dado. */
        .heatmap-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            margin-bottom: 1rem;
        }

        .heatmap-stat-chip {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background-color: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            padding: 0.55rem 0.9rem;
            font-size: 0.82rem;
            color: var(--color-body);
        }

        .heatmap-stat-chip strong {
            color: var(--color-ink);
            font-weight: 700;
        }

        .heatmap-stat-chip i {
            color: var(--color-primary);
            font-size: 0.95rem;
        }

        /* Contêiner do mapa: moldura + estado de carregamento + legenda
           flutuante, tudo dentro do mesmo raio/sombra do design system. */
        .map-frame {
            position: relative;
            border-radius: var(--radius-md);
            overflow: hidden;
            border: 1px solid var(--color-border);
        }

        #map-heatmap {
            height: 460px;
            width: 100%;
            z-index: 1;
            background-color: #EFEDF7;
        }

        .map-loading {
            position: absolute;
            inset: 0;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            background-color: var(--color-bg);
            color: var(--color-muted);
            font-size: 0.85rem;
            transition: opacity .3s ease;
        }

        .map-loading .spinner-border {
            width: 1.6rem;
            height: 1.6rem;
            color: var(--color-primary);
        }

        .map-loading.is-hidden {
            opacity: 0;
            pointer-events: none;
        }

        .map-legend {
            position: absolute;
            left: 14px;
            bottom: 14px;
            z-index: 2;
            background-color: rgba(255, 255, 255, .92);
            backdrop-filter: blur(6px);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            padding: 0.6rem 0.85rem;
            box-shadow: var(--shadow-pop);
            font-size: 0.72rem;
            color: var(--color-muted);
        }

        .map-legend .legend-title {
            font-weight: 700;
            color: var(--color-ink);
            font-size: 0.72rem;
            margin-bottom: 0.35rem;
        }

        .map-legend .legend-bar {
            width: 140px;
            height: 8px;
            border-radius: 999px;
            background: linear-gradient(90deg, #BFDBFE 0%, #60A5FA 30%, #2563EB 55%, var(--color-primary) 80%, #4C1D95 100%);
            margin-bottom: 0.3rem;
        }

        .map-legend .legend-labels {
            display: flex;
            justify-content: space-between;
        }

        .leaflet-popup-content-wrapper {
            border-radius: var(--radius-sm) !important;
            box-shadow: var(--shadow-pop) !important;
        }

        .leaflet-popup-content {
            font-family: var(--font-body);
            font-size: 0.82rem;
            color: var(--color-ink);
            margin: 0.6rem 0.8rem !important;
        }

        .leaflet-popup-content strong {
            font-family: var(--font-display);
        }

        /* ---------------- Seção geografia da inclusão ---------------- */
        .section-title {
            color: var(--color-ink);
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.9rem;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .subtitle-badge {
            color: var(--color-primary);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.78rem;
            display: block;
            margin-bottom: 0.6rem;
        }

        .section-text {
            color: var(--color-muted);
            font-size: 1rem;
            line-height: 1.65;
        }

        .btn-section-link {
            background: linear-gradient(155deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            border-radius: var(--radius-sm);
            font-weight: 600;
            padding: 0.65rem 1.35rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            box-shadow: 0 10px 22px -10px rgba(124, 58, 237, .6);
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .btn-section-link:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 14px 26px -10px rgba(124, 58, 237, .7);
        }

        .img-box {
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-card);
            border: 1px solid var(--color-border);
        }

        .img-box img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            transition: transform 0.5s ease;
            display: block;
        }

        .img-box:hover img {
            transform: scale(1.03);
        }

        @media (max-width: 575.98px) {
            #map-heatmap {
                height: 340px;
            }

            .map-legend {
                left: 10px;
                bottom: 10px;
                padding: 0.5rem 0.65rem;
            }

            .map-legend .legend-bar {
                width: 100px;
            }
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
    </style>
</head>

<body>

    {{-- NAVBAR SUPERIOR --}}
    <x-navbar activePage="heatmap" />

    {{-- CONTEÚDO PRINCIPAL --}}
    <main class="container my-5">

        {{-- Mapa de calor --}}
        <div class="dash-card heatmap-card mb-5">
            <div class="heatmap-head">
                <div>
                    <h3>Concentração Geográfica de Talentos Mapeados</h3>
                    <p>Visualização em tempo real das conexões geradas pela SkillFocus</p>
                </div>
                <span class="badge-map">
                    <span class="pulse-dot"></span> Ao vivo
                </span>
            </div>

            <div class="heatmap-stats" id="heatmapStats">
                {{-- Preenchido via JS a partir dos pontos reais do mapa --}}
            </div>

            <div class="map-frame">
                <div id="map-heatmap"></div>

                <div class="map-loading" id="mapLoading">
                    <div class="spinner-border" role="status"></div>
                    Carregando mapa de calor...
                </div>

                <div class="map-legend">
                    <div class="legend-title">Densidade de talentos</div>
                    <div class="legend-bar"></div>
                    <div class="legend-labels">
                        <span>Baixa</span>
                        <span>Alta</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Geografia da Inclusão --}}
        <div class="dash-card heatmap-card mb-4">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-6 pe-lg-5">
                    <span class="subtitle-badge">Saiba onde encontrar</span>
                    <h2 class="section-title">Geografia da Inclusão</h2>
                    <p class="section-text mb-4">
                        Mais do que um indicador visual, este mapa reflete nosso compromisso prático com a diversidade e inclusão.
                    </p>
                </div>

                <div class="col-12 col-lg-6 d-none d-lg-block">
                    <div class="img-box">
                        <img src="https://cdn.pixabay.com/photo/2018/03/10/12/00/teamwork-3213924_1280.jpg" alt="Trabalho em equipe diversificado">
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
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.heat/0.2.0/leaflet-heat.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Dados vindos do Controller Laravel
            const pointsData = @json($heatPoints ?? []);

            // Fallback de demonstração, só usado se o backend não enviar nada
            const points = pointsData.length > 0 ? pointsData : [
                [-23.5505, -46.6333, 0.8], // São Paulo
                [-22.9068, -43.1729, 0.6], // Rio de Janeiro
                [-19.9167, -43.9345, 0.5], // Belo Horizonte
                [-30.0346, -51.2177, 0.4] // Porto Alegre
            ];

            // ---- Mapa ----
            // Zoom inicial neutro; o foco real acontece depois de calcular
            // onde está a maior concentração de pontos (ver mais abaixo).
            const mapInstance = L.map('map-heatmap', {
                scrollWheelZoom: false
            }).setView([-14.5, -48], 4);

            // Tile claro e minimalista (CARTO Positron), combina melhor com
            // o restante da identidade visual do que o OSM colorido padrão.
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap contributors &copy; CARTO'
            }).addTo(mapInstance);

            // O "peso" mais alto do dataset vira a referência de saturação
            // máxima do heatmap. Sem isso, se os pesos reais nunca chegam a
            // 1.0, a cor nunca atinge o tom mais forte do gradiente — é
            // exatamente por isso que estava parecendo "fraco".
            const maxWeight = Math.max(...points.map(function(p) {
                return p[2];
            }));

            // Gradiente de calor nos tons de azul (pedido), com o roxo da
            // marca só como pico de intensidade máxima — mais saturado e
            // com opacidade mínima maior, então nenhuma área fica apagada.
            L.heatLayer(points, {
                radius: 32,
                blur: 22,
                maxZoom: 16,
                max: maxWeight * 0.85,
                minOpacity: 0.55,
                gradient: {
                    0.15: '#BFDBFE',
                    0.35: '#60A5FA',
                    0.55: '#2563EB',
                    0.78: '#7C3AED',
                    1.0: '#4C1D95'
                }
            }).addTo(mapInstance);

            // ---- Foco automático na área de maior concentração ----
            // 1) Enquadra todos os pontos primeiro, pra dar contexto geral.
            const bounds = L.latLngBounds(points.map(function(p) {
                return [p[0], p[1]];
            }));
            mapInstance.fitBounds(bounds, {
                padding: [30, 30],
                maxZoom: 6
            });

            // 2) Calcula o centróide ponderado pelo peso de cada ponto —
            //    ou seja, o "centro de massa" de onde há mais gente — e
            //    aproxima suavemente o mapa até lá.
            function weightedCentroid(pts) {
                let sumWeight = 0,
                    sumLat = 0,
                    sumLng = 0;
                pts.forEach(function(p) {
                    sumLat += p[0] * p[2];
                    sumLng += p[1] * p[2];
                    sumWeight += p[2];
                });
                return [sumLat / sumWeight, sumLng / sumWeight];
            }

            if (points.length > 1) {
                const centroid = weightedCentroid(points);
                setTimeout(function() {
                    mapInstance.flyTo(centroid, 6, {
                        duration: 1.1
                    });
                }, 700);
            }

            // Esconde o overlay de carregamento assim que os tiles chegam
            mapInstance.whenReady(function() {
                document.getElementById('mapLoading').classList.add('is-hidden');
            });

            // ---- Estatísticas rápidas, calculadas a partir dos próprios pontos ----
            const statsWrap = document.getElementById('heatmapStats');
            if (points.length > 0) {
                const topPoint = points.reduce((max, p) => (p[2] > max[2] ? p : max), points[0]);

                statsWrap.innerHTML = `
                    <div class="heatmap-stat-chip">
                        <i class="bi bi-geo-alt-fill"></i>
                        <strong>${points.length}</strong>&nbsp;regiões mapeadas
                    </div>
                    <div class="heatmap-stat-chip">
                        <i class="bi bi-lightning-charge-fill"></i>
                        Maior concentração em&nbsp;<strong>${topPoint[0].toFixed(2)}, ${topPoint[1].toFixed(2)}</strong>
                    </div>
                `;
            } else {
                statsWrap.style.display = 'none';
            }
        });
    </script>
</body>

</html>