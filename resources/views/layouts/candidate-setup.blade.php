<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillFocus - Complete seu Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="theme-color" content="#7C3AED">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/jpeg" sizes="192x192" href="/images/banner_032.jpg">
    <script src="/register-sw.js"></script>
    <style>
        .sf-eyebrow { color: #7C3AED; letter-spacing: .08em; }

        .sf-card {
            border: 1px solid #E9E5F3;
            box-shadow: 0 1px 2px rgba(23, 21, 42, .04), 0 10px 28px -14px rgba(23, 21, 42, .14);
        }

        .sf-field-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background-color: #F3EEFE;
            color: #7C3AED;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.95rem;
        }

        .sf-field-icon.shield {
            background-color: #E8F8F6;
            color: #0D9488;
        }

        .sf-field-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #17152A;
            margin-bottom: 0.5rem;
        }

        .sf-field-label-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.65rem;
        }

        .sf-field-label-row .sf-field-label { margin-bottom: 0; }

        .sf-field-hint {
            font-size: 0.75rem;
            color: #9C97B5;
            margin-bottom: 0.65rem;
            margin-left: 2.5rem;
        }

        .sf-input,
        .sf-select,
        .sf-number {
            width: 100%;
            padding: 0.625rem 1rem;
            background-color: #FFFFFF;
            border: 2px solid #E9E5F3;
            border-radius: 12px;
            color: #47435C;
            font-size: 0.875rem;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .sf-input:focus,
        .sf-select:focus,
        .sf-number:focus {
            outline: none;
            border-color: #7C3AED;
            box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
        }

        .sf-input::placeholder { color: #ACA8C2; }

        .sf-number {
            max-width: 120px;
            text-align: center;
            font-size: 1.15rem;
            font-weight: 700;
            color: #17152A;
        }

        .sf-textarea-wrap {
            border: 2px solid #E9E5F3;
            border-radius: 12px;
            padding: 0.75rem;
            background-color: #FBFAFF;
            transition: border-color .15s ease;
        }

        .sf-textarea-wrap:focus-within { border-color: #C9BEF2; }

        .sf-textarea {
            width: 100%;
            background: transparent;
            border: none;
            resize: vertical;
            outline: none;
            color: #47435C;
            font-size: 0.875rem;
            line-height: 1.6;
            min-height: 96px;
        }

        .sf-textarea::placeholder { color: #ACA8C2; }

        .sf-chip-area {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0.75rem;
            border: 2px solid #E9E5F3;
            border-radius: 12px;
            background-color: #FBFAFF;
            min-height: 60px;
        }

        .sf-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            background-color: #7C3AED;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
        }

        .sf-chip button {
            border: none;
            background: none;
            color: rgba(255,255,255,.75);
            font-size: 1rem;
            line-height: 1;
            padding: 0;
            cursor: pointer;
        }

        .sf-chip button:hover { color: #fff; }

        .sf-chip-input {
            width: 140px;
            padding: 0.35rem 0.65rem;
            border: 2px dashed #E9E5F3;
            border-radius: 8px;
            background: #fff;
            font-size: 0.8rem;
            outline: none;
        }

        .sf-chip-input:focus { border-color: #7C3AED; }

        .sf-chip-add {
            width: 32px;
            height: 32px;
            border: 2px dashed #E9E5F3;
            border-radius: 999px;
            background: #fff;
            color: #77738F;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .15s ease;
        }

        .sf-chip-add:hover {
            border-color: #7C3AED;
            color: #7C3AED;
        }

        .sf-option {
            border: 2px solid #E9E5F3;
            transition: all .18s ease;
            cursor: pointer;
        }

        .sf-option:hover {
            border-color: #C9BEF2;
            background-color: #FBFAFF;
        }

        .sf-option.is-selected-primary {
            border-color: #a270f7;
            background-color: #F3EEFE;
        }

        .sf-option.is-selected-shield {
            border-color: #7eb3ae;
            background-color: #E8F8F6;
        }

        .sf-radio,
        .sf-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #E9E5F3;
            background-color: #FFFFFF;
            cursor: pointer;
            position: relative;
            transition: all 0.15s ease;
            flex-shrink: 0;
        }

        .sf-radio { border-radius: 50%; }
        .sf-checkbox { border-radius: 6px; }

        .sf-radio:checked,
        .sf-checkbox:checked {
            border-color: #7C3AED;
            background-color: #7C3AED;
        }

        .sf-checkbox.shield:checked {
            border-color: #0D9488;
            background-color: #0D9488;
        }

        .sf-radio:checked::after,
        .sf-checkbox:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .sf-radio:checked::after {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: white;
        }

        .sf-checkbox:checked::after {
            width: 12px;
            height: 12px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
        }

        .sf-item-card {
            background: #FFFFFF;
            border: 1px solid #E9E5F3;
            border-radius: 16px;
            padding: 1.35rem;
            box-shadow: 0 1px 2px rgba(23, 21, 42, .04);
        }

        .sf-btn-continue {
            background: linear-gradient(155deg, #7C3AED, #5B21B6);
            color: white;
            font-weight: 600;
            padding: 0.78rem 1.5rem;
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 22px -10px rgba(124, 58, 237, .6);
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .sf-btn-continue:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 26px -10px rgba(124, 58, 237, .7);
            color: white;
        }

        .sf-btn-continue:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .sf-btn-back {
            color: #47435C;
            font-weight: 600;
            padding: 0.625rem 1.25rem;
            border-radius: 12px;
            border: 2px solid #E9E5F3;
            background: white;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
        }

        .sf-btn-back:hover {
            border-color: #C9BEF2;
            color: #7C3AED;
            background-color: #FBFAFF;
        }

        .sf-btn-secondary {
            color: #47435C;
            font-weight: 600;
            padding: 0.55rem 1rem;
            border-radius: 12px;
            border: 2px solid #E9E5F3;
            background: white;
            transition: all 0.15s ease;
        }

        .sf-btn-secondary:hover {
            border-color: #7C3AED;
            color: #7C3AED;
        }

        .sf-btn-danger {
            color: #B91C1C;
            font-weight: 600;
            font-size: 0.875rem;
            border: none;
            background: none;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .sf-btn-danger:hover { color: #991B1B; }

        .dropzone {
            border: 3px dashed #7C3AED;
            border-radius: 16px;
            padding: 20px 18px;
            text-align: center;
            cursor: pointer;
            background: rgba(124, 58, 237, 0.05);
            transition: all 0.2s ease;
        }

        .dropzone.dragover {
            background: rgba(124, 58, 237, 0.1);
            border-color: #5B21B6;
        }

        .sf-step-dot { transition: all .2s ease; }

        .sf-footer-note {
            font-size: 0.75rem;
            color: #9C97B5;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-purple-50 to-blue-50 min-h-screen">
    <div class="container mx-auto px-4 py-4 md:py-8">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-6 md:mb-8">
                <h1 class="text-2xl md:text-4xl font-bold text-purple-800 mb-2">SkillFocus</h1>
                <p class="text-sm md:text-lg text-gray-600">Complete seu Perfil de Candidato</p>
            </div>

            <div class="bg-white rounded-2xl shadow-2xl p-4 md:p-8">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        window.sfInitOptions = function() {
            document.querySelectorAll('input.sf-radio, input.sf-checkbox').forEach(input => {
                if (input.dataset.sfBound) return;
                input.dataset.sfBound = '1';

                const sync = () => {
                    const option = input.closest('.sf-option');
                    if (!option) return;

                    const isCheckbox = input.classList.contains('sf-checkbox');
                    const isShield = input.classList.contains('shield');
                    const selectedClass = isShield ? 'is-selected-shield' : 'is-selected-primary';
                    const textClass = isShield ? 'text-[#0D9488]' : 'text-[#7C3AED]';
                    const textSpan = option.querySelector('.sf-option-text');

                    if (input.checked) {
                        if (isCheckbox) {
                            option.classList.add(selectedClass);
                            textSpan?.classList.add(textClass);
                        } else {
                            document.querySelectorAll(`input[name="${input.name}"]`).forEach(radio => {
                                const label = radio.closest('.sf-option');
                                label?.classList.remove('is-selected-primary');
                                label?.querySelector('.sf-option-text')?.classList.remove('text-[#7C3AED]');
                            });
                            option.classList.add('is-selected-primary');
                            textSpan?.classList.add('text-[#7C3AED]');
                        }
                    } else if (isCheckbox) {
                        option.classList.remove(selectedClass);
                        textSpan?.classList.remove(textClass);
                    }
                };

                input.addEventListener('change', sync);
                sync();
            });
        };

        document.addEventListener('DOMContentLoaded', window.sfInitOptions);
    </script>

    @stack('scripts')
</body>

</html>
