<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios | SkillFocus</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #4A148C;
            --secondary-color: #FF6D00;
            --bg-light: #F9F7F6;
            --text-dark: #2B2B2B;
        }
        body {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
        }
        h1, h2, h3, h4, .navbar-brand { font-family: 'Poppins', sans-serif; }
        .dash-navbar { background-color: #ffffff; border-bottom: 2px solid rgba(74, 20, 140, 0.05); }
        .navbar-brand { font-weight: 700; color: var(--primary-color) !important; }
        .navbar-brand span { color: var(--secondary-color); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg dash-navbar sticky-top py-3 px-4 mb-5">
        <div class="container-fluid max-w-[1920px] mx-auto flex justify-between items-center">
            <a class="navbar-brand text-2xl" href="{{url('/dashboard')}}">Skill<span>Focus</span></a>
            <a href="{{url('/dashboard')}}" class="btn btn-sm btn-outline-primary rounded-lg">
                <i class="bi bi-arrow-left me-1"></i> Voltar ao Dashboard
            </a>
        </div>
    </nav>

    <main class="container mx-auto px-4 pb-12 max-w-7xl flex flex-col gap-8">
        <div>
            <h1 class="text-3xl font-bold text-purple-900 mb-2">Relatórios Analíticos de Diversidade</h1>
            <p class="text-gray-600">Acompanhamento detalhado do impacto de inclusão e metas ESG em tempo real.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl p-4 mb-4">
                    <h3 class="text-white font-bold text-lg mb-0">Pontuação de Diversidade</h3>
                </div>
                <div class="text-center pt-2">
                    <p class="text-6xl font-bold text-purple-700 mb-4">85<span class="text-3xl text-gray-400">/100</span></p>
                    <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-700 h-3 rounded-full" style="width: 85%"></div>
                    </div>
                    <p class="text-sm text-gray-500 fw-medium">Atualizado em tempo real</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="bg-gradient-to-br from-green-500 to-emerald-700 rounded-xl p-4 mb-4">
                    <h3 class="text-white font-bold text-lg mb-0">Metas ESG</h3>
                </div>
                <div class="space-y-3">
                    <div class="p-3 bg-gray-50 border border-gray-100 rounded-lg">
                        <p class="font-semibold text-gray-800 text-sm mb-2">Inclusão de Talentos Diversos em Tecnologia</p>
                        <div class="flex items-center gap-3">
                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full" style="width: 65%"></div>
                            </div>
                            <span class="text-xs font-bold text-gray-600">65%</span>
                        </div>
                    </div>
                    <div class="p-3 bg-gray-50 border border-gray-100 rounded-lg">
                        <p class="font-semibold text-gray-800 text-sm mb-2">Ações de Governança Integrada (ESG)</p>
                        <div class="flex items-center gap-3">
                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full" style="width: 42%"></div>
                            </div>
                            <span class="text-xs font-bold text-gray-600">42%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="bg-gradient-to-br from-blue-500 to-indigo-700 rounded-xl p-4 mb-4">
                    <h3 class="text-white font-bold text-lg mb-0">Prioridades de Diversidade</h3>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between p-2 border-b border-gray-50">
                        <span class="text-gray-800 font-medium text-sm">Prof. Negros</span>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider bg-red-100 text-red-700">ALTA</span>
                    </div>
                    <div class="flex items-center justify-between p-2 border-b border-gray-50">
                        <span class="text-gray-800 font-medium text-sm">Mulheres em Liderança</span>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider bg-red-100 text-red-700">ALTA</span>
                    </div>
                    <div class="flex items-center justify-between p-2 border-b border-gray-50">
                        <span class="text-gray-800 font-medium text-sm">PCDs</span>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider bg-yellow-100 text-yellow-700">MÉDIA</span>
                    </div>
                    <div class="flex items-center justify-between p-2 last:border-0">
                        <span class="text-gray-800 font-medium text-sm">LGBTQIA+</span>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider bg-green-100 text-green-700">BAIXA</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
