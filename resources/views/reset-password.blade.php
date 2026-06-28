<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha | SkillFocus</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts: Poppins (Títulos) e Inter (Textos) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /*Palheta de cores */
        :root {
            --primary-color: #4A148C;
            --secondary-color: #FF6D00;
            --accent-color: #00BFA5;
            --bg-light: #F9F7F6;
            --text-dark: #2B2B2B;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        h1, h2, h3, .btn {
            font-family: 'Poppins', sans-serif;
        }

        .reset-card {
            background: #ffffff;
            border: none;
            border-radius: 2rem;
            box-shadow: 0 20px 40px rgba(74, 20, 140, 0.06);
            max-width: 480px;
            width: 100%;
            overflow: hidden;
        }

        /* Detalhe sutil de pluralidade no topo */
        .card-top-bar {
            height: 6px;
            background: linear-gradient(to right, var(--accent-color), var(--primary-color), var(--secondary-color));
            width: 100%;
        }

        .card-body-content {
            padding: 3rem 2.5rem;
        }

        .icon-box {
            width: 70px;
            height: 70px;
            background: rgba(0, 191, 165, 0.1);
            color: var(--accent-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            font-size: 2rem;
        }

        .title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.6rem;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #6C757D;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }

        /* Customização dos Inputs Estilizados */
        .form-floating .form-control {
            border-radius: 0.75rem;
            border: 1px solid #E2E8F0;
            background-color: #FAFAFA;
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }

        .form-floating .form-control:focus {
            border-color: var(--primary-color);
            background-color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(74, 20, 140, 0.1);
        }

        .form-floating label {
            color: #8D8D8D;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Botão Principal de Ação */
        .btn-reset {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.75rem;
            padding: 0.875rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-reset:hover {
            background-color: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 109, 0, 0.25);
        }
    </style>
</head>
<body>

    <div class="reset-card">
        <!-- Detalhe Superior de Cores -->
        <div class="card-top-bar"></div>

        <div class="card-body-content">

            <!-- Ícone de Segurança -->
            <div class="icon-box">
                <i class="bi bi-shield-lock"></i>
            </div>

            <!-- Textos de Cabeçalho -->
            <div class="text-center">
                <h2 class="title">Nova Senha</h2>
                <p class="subtitle">Crie uma credencial forte para proteger seu acesso à plataforma.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Formulário com os campos solicitados -->
            <form action="/reset-password" method="POST">
                @csrf
                <!-- Inputs Ocultos Requeridos pelo Ecossistema de Autenticação (ex: Laravel) -->
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- Campo: Nova Senha -->
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Nova Senha" required>
                    <label for="password">
                        <i class="bi bi-key text-muted"></i> Nova Senha
                    </label>
                </div>

                <!-- Campo: Confirme a Nova Senha -->
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirme a Nova Senha" required>
                    <label for="password_confirmation">
                        <i class="bi bi-key-fill text-muted"></i> Confirme a Nova Senha
                    </label>
                </div>

                <!-- Informação de Ajuda Visual Sutil -->
                <div class="d-flex align-items-center gap-2 mb-4 text-muted small">
                    <i class="bi bi-info-circle text-accent" style="color: var(--accent-color);"></i>
                    <span>Certifique-se de usar letras, números e caracteres especiais.</span>
                </div>

                <!-- Botão de Envio -->
                <button type="submit" class="btn btn-reset">
                    Redefinir Senha <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </form>

        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
