@extends('layouts.candidate-setup')

@section('content')
<div class="flex items-center gap-2 mb-8">
    @for ($i = 1; $i <= 6; $i++)
        <div class="flex items-center gap-2 {{ $i < 6 ? 'flex-1' : 'flex-0' }}">
            <div class="sf-step-dot w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold
                {{ $i <= 3 ? 'text-white' : 'text-[#9C97B5] bg-[#F3EEFE]' }}"
                @if($i <= 3) style="background: linear-gradient(155deg, #7C3AED, #5B21B6);" @endif>
                {{ $i }}
            </div>
            @if($i < 6)
                <div class="h-[2px] flex-1 rounded-full {{ $i <= 2 ? 'bg-[#7C3AED]' : 'bg-[#E9E5F3]' }}"></div>
            @endif
        </div>
    @endfor
</div>

<div class="flex items-center gap-1 mb-2">
    <span class="sf-eyebrow text-xs font-bold uppercase">Etapa 3 de 6</span>
</div>
<h2 class="text-2xl font-bold text-[#17152A] mb-2">Informação Profissional</h2>
<p class="text-[#77738F] mb-8">Essas informações foram pré-preenchidas com base no seu currículo. Você pode editá-las.</p>

<div class="sf-card bg-white rounded-2xl p-6 md:p-8">
    <form id="info-form" method="POST" action="{{ route('candidate-setup.step3.post') }}">
        @csrf

        <div class="space-y-6 mb-8">
            <div>
                <div class="sf-field-label-row">
                    <span class="sf-field-icon"><i class="bi bi-briefcase"></i></span>
                    <label for="current_job_title" class="sf-field-label mb-0">Título do Cargo Atual</label>
                </div>
                <input type="text" name="current_job_title" id="current_job_title"
                    value="{{ old('current_job_title', $candidate->current_job_title ?? '') }}" class="sf-input">
            </div>

            <div>
                <div class="sf-field-label-row">
                    <span class="sf-field-icon"><i class="bi bi-calendar3"></i></span>
                    <label for="years_experience" class="sf-field-label mb-0">Anos de Experiência</label>
                </div>
                <input type="number" name="years_experience" id="years_experience" min="0" max="50"
                    value="{{ old('years_experience', $candidate->years_experience ?? '') }}" class="sf-number">
            </div>

            <div>
                <div class="sf-field-label-row">
                    <span class="sf-field-icon"><i class="bi bi-journal-text"></i></span>
                    <label for="professional_summary" class="sf-field-label mb-0">Resumo Profissional</label>
                </div>
                <div class="sf-textarea-wrap">
                    <textarea name="professional_summary" id="professional_summary" rows="4" class="sf-textarea"
                        placeholder="Descreva sua experiência e principais competências">{{ old('professional_summary', $candidate->professional_summary ?? '') }}</textarea>
                </div>
            </div>

            <div>
                <div class="sf-field-label-row">
                    <span class="sf-field-icon"><i class="bi bi-tags"></i></span>
                    <label class="sf-field-label mb-0">Habilidades</label>
                </div>
                <div id="skills-container" class="sf-chip-area">
                    @foreach ($candidate->skills ?? [] as $skill)
                        <span class="sf-chip">
                            {{ $skill }}
                            <button type="button" class="remove-skill">&times;</button>
                            <input type="hidden" name="skills[]" value="{{ $skill }}">
                        </span>
                    @endforeach
                    <div class="add-skill-container flex items-center gap-2">
                        <input type="text" id="new-skill-input" placeholder="Adicionar habilidade" class="sf-chip-input">
                        <button type="button" id="add-skill-btn" class="sf-chip-add"><i class="bi bi-plus"></i></button>
                    </div>
                </div>
            </div>

            <div>
                <div class="sf-field-label-row">
                    <span class="sf-field-icon shield"><i class="bi bi-translate"></i></span>
                    <label class="sf-field-label mb-0">Idiomas</label>
                </div>
                <div id="languages-container" class="sf-chip-area mb-4">
                    @foreach ($candidate->languages ?? [] as $index => $lang)
                        <span class="sf-chip language-chip">
                            {{ $lang['name'] ?? '' }} ({{ $lang['level'] ?? '' }})
                            <button type="button" class="remove-language">&times;</button>
                            <input type="hidden" name="languages[{{ $index }}][name]" value="{{ $lang['name'] ?? '' }}">
                            <input type="hidden" name="languages[{{ $index }}][level]" value="{{ $lang['level'] ?? '' }}">
                        </span>
                    @endforeach
                </div>

                <div id="language-form-error" class="hidden mb-3 text-sm font-semibold text-[#B91C1C]"></div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mb-4">
                    <div>
                        <label for="language-select" class="sf-field-label">Idioma</label>
                        <select id="language-select" class="sf-select">
                            <option value="">Selecione ou digite abaixo</option>
                            @foreach (['Inglês', 'Espanhol', 'Português', 'Francês', 'Alemão', 'Italiano', 'Mandarim', 'Japonês'] as $lang)
                                <option value="{{ $lang }}">{{ $lang }}</option>
                            @endforeach
                        </select>
                        <input type="text" id="language-custom-input" class="sf-input mt-2" placeholder="Ou digite outro idioma">
                    </div>
                    <div class="lg:col-span-2">
                        <label class="sf-field-label">Nível</label>
                        <div id="language-level-options" class="grid grid-cols-2 md:grid-cols-3 gap-2">
                            @foreach (['Básico', 'Intermediário', 'Avançado', 'Fluente', 'Nativo'] as $level)
                                <label class="sf-option flex items-center p-3 rounded-xl {{ $loop->first ? 'is-selected-primary' : '' }}">
                                    <input type="radio" name="new_language_level" value="{{ $level }}" class="sf-radio mr-2"
                                        {{ $loop->first ? 'checked' : '' }}>
                                    <span class="sf-option-text text-sm font-semibold {{ $loop->first ? 'text-[#7C3AED]' : 'text-[#47435C]' }}">{{ $level }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <button type="button" id="add-language-btn" class="sf-btn-secondary">
                    <i class="bi bi-plus-lg me-1"></i> Adicionar idioma
                </button>
            </div>
        </div>

        <div class="flex justify-between items-center gap-3 pt-2 border-t border-[#E9E5F3]">
            <a href="{{ route('candidate-setup.step2') }}" class="sf-btn-back">
                <i class="bi bi-arrow-left mr-2"></i> Voltar
            </a>
            <button type="submit" class="sf-btn-continue">Continuar</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const skillsContainer = document.getElementById('skills-container');
        const languagesContainer = document.getElementById('languages-container');
        const languageSelect = document.getElementById('language-select');
        const languageCustomInput = document.getElementById('language-custom-input');
        const languageFormError = document.getElementById('language-form-error');

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function normalizeLanguageName(name) {
            const base = String(name || '')
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .trim()
                .toLowerCase();

            const aliases = {
                english: 'ingles',
                ingles: 'ingles',
                spanish: 'espanhol',
                espanhol: 'espanhol',
                portuguese: 'portugues',
                portugues: 'portugues',
            };

            return aliases[base] || base;
        }

        function showLanguageError(message) {
            if (!languageFormError) return;
            languageFormError.textContent = message;
            languageFormError.classList.remove('hidden');
        }

        function clearLanguageError() {
            if (!languageFormError) return;
            languageFormError.textContent = '';
            languageFormError.classList.add('hidden');
        }

        function reindexLanguages() {
            languagesContainer.querySelectorAll('.language-chip').forEach((chip, index) => {
                const nameInput = chip.querySelector('input[name$="[name]"]');
                const levelInput = chip.querySelector('input[name$="[level]"]');
                if (nameInput) nameInput.name = `languages[${index}][name]`;
                if (levelInput) levelInput.name = `languages[${index}][level]`;
            });
        }

        function bindRemoveLanguage(button) {
            button.addEventListener('click', () => {
                button.closest('.language-chip')?.remove();
                reindexLanguages();
            });
        }

        function createLanguageChip(name, level) {
            const chip = document.createElement('span');
            chip.className = 'sf-chip language-chip';
            chip.innerHTML = `
                ${escapeHtml(name)} (${escapeHtml(level)})
                <button type="button" class="remove-language">&times;</button>
                <input type="hidden" name="languages[0][name]" value="${escapeHtml(name)}">
                <input type="hidden" name="languages[0][level]" value="${escapeHtml(level)}">
            `;
            bindRemoveLanguage(chip.querySelector('.remove-language'));
            return chip;
        }

        function getSelectedLanguageName() {
            const customName = languageCustomInput?.value.trim() || '';
            if (customName) return customName;
            return languageSelect?.value.trim() || '';
        }

        function getExistingLanguageNames() {
            return Array.from(languagesContainer.querySelectorAll('input[name$="[name]"]'))
                .map(input => normalizeLanguageName(input.value));
        }

        function addLanguage() {
            clearLanguageError();

            const selectedName = getSelectedLanguageName();
            const selectedLevel = document.querySelector('input[name="new_language_level"]:checked')?.value;

            if (!selectedName) {
                showLanguageError('Selecione um idioma na lista ou digite o nome no campo abaixo.');
                return;
            }

            if (!selectedLevel) {
                showLanguageError('Selecione o nível do idioma.');
                return;
            }

            const normalizedName = normalizeLanguageName(selectedName);
            if (getExistingLanguageNames().includes(normalizedName)) {
                showLanguageError('Este idioma já foi adicionado.');
                return;
            }

            languagesContainer.appendChild(createLanguageChip(selectedName, selectedLevel));
            reindexLanguages();

            if (languageSelect) languageSelect.value = '';
            if (languageCustomInput) languageCustomInput.value = '';
        }

        document.querySelectorAll('.remove-skill').forEach(btn => {
            btn.addEventListener('click', () => btn.closest('.sf-chip')?.remove());
        });

        document.getElementById('add-skill-btn')?.addEventListener('click', () => {
            const input = document.getElementById('new-skill-input');
            const skillText = input?.value.trim();
            if (!skillText || !skillsContainer) return;

            const newChip = document.createElement('span');
            newChip.className = 'sf-chip';
            newChip.innerHTML = `
                ${escapeHtml(skillText)}
                <button type="button" class="remove-skill">&times;</button>
                <input type="hidden" name="skills[]" value="${escapeHtml(skillText)}">
            `;
            skillsContainer.insertBefore(newChip, skillsContainer.querySelector('.add-skill-container'));
            newChip.querySelector('.remove-skill')?.addEventListener('click', () => newChip.remove());
            input.value = '';
        });

        document.getElementById('new-skill-input')?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('add-skill-btn')?.click();
            }
        });

        document.querySelectorAll('.remove-language').forEach(bindRemoveLanguage);

        document.getElementById('add-language-btn')?.addEventListener('click', addLanguage);

        languageCustomInput?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                addLanguage();
            }
        });

        languageSelect?.addEventListener('change', () => {
            if (languageSelect.value && languageCustomInput) {
                languageCustomInput.value = '';
            }
            clearLanguageError();
        });

        languageCustomInput?.addEventListener('input', () => {
            if (languageCustomInput.value.trim() && languageSelect) {
                languageSelect.value = '';
            }
            clearLanguageError();
        });

        if (typeof window.sfInitOptions === 'function') {
            window.sfInitOptions();
        }
    });
</script>
@endpush
@endsection
