<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillFocus - Configuração</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-purple-50 to-blue-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-purple-800 mb-2">SkillFocus</h1>
                <p class="text-lg text-gray-600">Configuração de Diversidade & ESG</p>
            </div>

            <!-- Progress Bar -->
            @php
            $steps = [
            'step1' => 25,
            'step2' => 50,
            'step3' => 75,
            'step4' => 100,
            'review' => 100,
            ];
            $currentStep = request()->route()->getName();
            $progress = $steps[$currentStep] ?? 25;
            @endphp

            <div class="mb-8">
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Passo {{ array_search($currentStep, array_keys($steps)) + 1 }} de {{ count($steps) }}</span>
                    <span class="text-sm font-medium text-purple-700">{{ $progress }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-700 h-3 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                </div>
            </div>

            <!-- Content -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>