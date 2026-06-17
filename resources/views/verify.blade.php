<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifique seu E-mail | SkillFocus</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts: Poppins (Títulos) e Inter (Textos) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /* Palheta de cores */
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

        .verify-card {
            background: #ffffff;
            border: none;
            border-radius: 2rem;
            box-shadow: 0 20px 40px rgba(74, 20, 140, 0.06);
            max-width: 550px;
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        /* Detalhe colorido no topo do card simbolizando a pluralidade/diversidade */
        .card-top-bar {
            height: 6px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color), var(--accent-color));
            width: 100%;
        }

        .card-body-content {
            padding: 3.5rem 2.5rem;
        }

        /* Ícone de envelope animado/estilizado */
        .icon-box {
            width: 90px;
            height: 90px;
            background: rgba(74, 20, 140, 0.06);
            color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem auto;
            font-size: 2.5rem;
            position: relative;
        }

        .icon-box::after {
            content: '';
            position: absolute;
            inset: -5px;
            border: 2px dashed var(--secondary-color);
            border-radius: 50%;
            opacity: 0.4;
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            100% { transform: rotate(360deg); }
        }

        .title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }

        .description {
            color: #6C757D;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        /* Botão de Reenvio */
        .btn-resend {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.75rem;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(74, 20, 140, 0.15);
        }

        .btn-resend:hover {
            background-color: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 109, 0, 0.25);
        }

        /* Link secundário de logout ou voltar */
        .btn-logout {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.2s ease;
            background: none;
            border: none;
            padding: 0;
        }

        .btn-logout:hover {
            color: var(--primary-color);
        }

        /* Alerta sutil caso um novo link acabe de ser enviado */
        .alert-custom {
            background-color: rgba(0, 191, 165, 0.1);
            border: 1px solid rgba(0, 191, 165, 0.2);
            color: #00796B;
            border-radius: 0.75rem;
            font-size: 0.9rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

    <div class="verify-card">
        <!-- Barra de Diversidade no Topo -->
        <div class="card-top-bar"></div>

        <div class="card-body-content text-center">

            <!-- Caixa do Ícone -->
            <div class="icon-box">
                <i class="bi bi-envelope-open-heart"></i>
            </div>

            <!-- Título Principal -->
            <h2 class="title">Quase lá! Verifique seu e-mail</h2>

            <!-- Descrição Acolhedora -->
            <p class="description">
                Antes de começar a construir processos seletivos mais plurais e inclusivos, precisamos confirmar sua identidade.
                Enviamos um link de ativação para o seu e-mail cadastrado. Por favor, verifique sua caixa de entrada (e a pasta de spam).
            </p>

            <!-- Exemplo de Alerta de Sucesso Opcional (ativado pelo backend quando reenvia) -->
            <!--
            <div class="alert alert-custom d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                Um novo link de verificação foi enviado para o seu e-mail!
            </div>
            -->

            <!-- Formulário de Reenvio Obrigatório -->
            <form method="POST" action="/email/verification-notification" class="mb-4">
                <!-- Segurança do Laravel -->
                <input type="hidden" name="_token" value="csrf_token_placeholder">

                <button type="submit" class="btn btn-resend">
                    <i class="bi bi-send me-2"></i> Reenviar e-mail de verificação
                </button>
            </form>

            <!-- Opção de Sair ou trocar de conta -->
            <div class="pt-3 border-top">
                <form method="POST" action="/logout" class="d-inline">
                    <input type="hidden" name="_token" value="csrf_token_placeholder">
                    <span class="text-muted small">Não é o seu e-mail?</span>
                    <a href="{{url('/logout')}}"><button type="submit" class="btn-logout ms-1">Sair da conta</button></a>
                </form>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
