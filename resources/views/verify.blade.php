<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifique seu E-mail | SkillFocus</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-purple: #7C3AED;
            --primary-purple-hover: #6D28D9;
            --bg-body: #F9FAFB;
            --text-main: #111827;
            --text-muted: #6B7280;
            --border-color: #E5E7EB;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        /* Card de Verificação */
        .auth-card {
            background-color: #FFFFFF;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            padding: 3rem;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        /* Ícone */
        .icon-box {
            width: 72px;
            height: 72px;
            background-color: #EDE9FE;
            color: var(--primary-purple);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem auto;
        }

        /* Botões */
        .btn-purple {
            background-color: var(--primary-purple);
            color: white;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.2s;
            border: none;
        }

        .btn-purple:hover {
            background-color: var(--primary-purple-hover);
            color: white;
        }

        .btn-link-custom {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .btn-link-custom:hover {
            color: var(--primary-purple);
        }

        /* Mensagens de Sucesso */
        .alert-success-custom {
            background-color: #ECFDF5;
            color: #065F46;
            border: 1px solid #A7F3D0;
            border-radius: 12px;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>

    <div class="auth-card">
        <!-- Ícone -->
        <div class="icon-box">
            <i class="bi bi-envelope-at-fill"></i>
        </div>

        <!-- Títulos -->
        <h1 class="fs-3 fw-bold mb-3">Verifique seu e-mail</h1>
        <p class="text-muted mb-4" style="line-height: 1.6;">
            Antes de começar a construir processos seletivos mais plurais e inclusivos, precisamos confirmar sua identidade. Enviamos um link de ativação para o seu e-mail.
        </p>

        <!-- Mensagem de Sucesso (Exemplo de condicional Blade) -->
        @if (session('resent'))
            <div class="alert alert-success-custom" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> Um novo link foi enviado com sucesso!
            </div>
        @endif

        <!-- Formulário de Reenvio -->
        <form method="POST" action="/email/verification-notification" class="mb-4">
            @csrf
            <button type="submit" class="btn btn-purple">
                <i class="bi bi-send-fill me-2"></i> Reenviar e-mail
            </button>
        </form>

        <!-- Link de Logout -->
        <div class="pt-3 border-top">
            <span class="text-muted small">Não é o seu e-mail?</span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link-custom ms-1 fw-semibold">Sair da conta</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
