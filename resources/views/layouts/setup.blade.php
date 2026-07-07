<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillFocus - Configuração</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
            'step1' => 20,
            'step2' => 40,
            'step3' => 60,
            'step4' => 80,
            'review' => 100,
            ];
            $currentStep = explode("/", request()?->path())[1];
            $progress = $steps[$currentStep] ?? 25;
            @endphp

            <!-- Content -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>