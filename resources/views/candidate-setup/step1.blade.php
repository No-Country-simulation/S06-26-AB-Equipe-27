@extends('layouts.candidate-setup')

@section('content')
<div class="flex items-center gap-2 mb-8">
    @for ($i = 1; $i <= 6; $i++)
        <div class="flex items-center gap-2 {{ $i < 6 ? 'flex-1' : 'flex-0' }}">
            <div class="sf-step-dot w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold
                {{ $i === 1 ? 'text-white' : 'text-[#9C97B5] bg-[#F3EEFE]' }}"
                @if($i === 1) style="background: linear-gradient(155deg, #7C3AED, #5B21B6);" @endif>
                {{ $i }}
            </div>
            @if($i < 6)
                <div class="h-[2px] flex-1 rounded-full {{ $i === 1 ? 'bg-[#7C3AED]' : 'bg-[#E9E5F3]' }}"></div>
            @endif
        </div>
    @endfor
</div>

<div class="flex items-center gap-1 mb-2">
    <span class="sf-eyebrow text-xs font-bold uppercase">Etapa 1 de 6</span>
</div>
<h2 class="text-2xl font-bold text-[#17152A] mb-2">Upload do Currículo</h2>
<p class="text-[#77738F] mb-8">Adicione seu currículo para que nossa IA possa preencher automaticamente seu perfil. Você poderá revisar as informações.</p>


<style>
.analysis-panel {
        border: 3px dashed #7C3AED;
        border-radius: 16px;
        padding: 2rem 1.5rem;
        background: rgba(124, 58, 237, 0.05);
        min-height: 280px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .analysis-step {
        opacity: 0;
        transform: translateY(8px);
        transition: opacity 0.45s ease, transform 0.45s ease;
    }

    .analysis-step.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .analysis-step.is-done .step-icon-pending,
    .analysis-step.is-done .step-icon-loading {
        display: none;
    }

    .analysis-step.is-done .step-icon-done {
        display: inline-flex;
    }

    .analysis-step.is-loading .step-icon-pending,
    .analysis-step.is-done .step-icon-pending {
        display: none;
    }

    .analysis-step.is-loading .step-icon-loading {
        display: inline-flex;
    }

    .analysis-step.is-loading .step-icon-done {
        display: none;
    }

    .step-icon-pending,
    .step-icon-loading,
    .step-icon-done {
        display: none;
        width: 1.25rem;
        height: 1.25rem;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .analysis-step:not(.is-loading):not(.is-done) .step-icon-pending {
        display: inline-flex;
    }

    .analysis-status {
        opacity: 0;
        transform: translateY(8px);
        transition: opacity 0.45s ease, transform 0.45s ease;
    }

    .analysis-status.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .analysis-done {
        opacity: 0;
        transform: translateY(8px);
        transition: opacity 0.45s ease, transform 0.45s ease;
    }

    .analysis-done.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    .analysis-spinner {
        animation: analysis-spin 0.9s linear infinite;
    }

    @keyframes analysis-spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .analysis-pulse {
        animation: analysis-pulse 1.6s ease-in-out infinite;
    }

    @keyframes analysis-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.55; }
    }
</style>
<div class="sf-card bg-white rounded-2xl p-6 md:p-8">

<form id="resume-form" method="POST" action="{{ route('candidate-setup.step1.post') }}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="resume" id="resume" accept=".pdf,.docx" class="hidden" required>

    <!-- Upload area (dropzone + select) -->
    <div id="upload-area">
        <div id="dropzone" class="dropzone mb-4">
            <div class="text-center">
                <i class="bi bi-file-earmark-arrow-up text-6xl text-purple-400 mb-2 d-block"></i>
                <p class="text-xl text-gray-700 mb-2">Arraste e Solte seu Currículo aqui</p>
                <p class="text-sm text-gray-500">Formatos aceitos: PDF, DOCX</p>
            </div>
        </div>

        <div class="text-center mb-8">
            <p class="text-gray-500 mb-4">ou</p>
            <button type="button" id="select-file-btn" class="sf-btn-back">
                <i class="bi bi-folder mr-2"></i> Selecionar Arquivo
            </button>
        </div>
    </div>

    <!-- AI Analysis (replaces dropzone after upload) -->
    <div id="analysis-section" class="hidden mb-8">
        <div class="analysis-panel">
            <h3 id="analysis-title" class="analysis-status text-xl font-bold text-gray-900 mb-4 text-center">Análise do Currículo</h3>

            <div id="analysis-status" class="analysis-status flex items-center justify-center gap-2 mb-6">
                <i class="bi bi-robot text-purple-600 text-xl analysis-pulse"></i>
                <span class="text-gray-700 font-medium analysis-pulse">A IA está analisando seu currículo...</span>
            </div>

            <ul id="analysis-steps" class="space-y-3 max-w-md mx-auto mb-4">
                <li class="analysis-step flex items-center gap-3" data-step="personal">
                    <span class="step-icon-pending"><i class="bi bi-circle text-gray-300"></i></span>
                    <span class="step-icon-loading"><i class="bi bi-arrow-repeat text-purple-600 analysis-spinner"></i></span>
                    <span class="step-icon-done"><i class="bi bi-check-circle-fill text-green-500"></i></span>
                    <span class="text-gray-700">Informações Pessoais</span>
                </li>
                <li class="analysis-step flex items-center gap-3" data-step="experience">
                    <span class="step-icon-pending"><i class="bi bi-circle text-gray-300"></i></span>
                    <span class="step-icon-loading"><i class="bi bi-arrow-repeat text-purple-600 analysis-spinner"></i></span>
                    <span class="step-icon-done"><i class="bi bi-check-circle-fill text-green-500"></i></span>
                    <span class="text-gray-700">Experiência Profissional</span>
                </li>
                <li class="analysis-step flex items-center gap-3" data-step="skills">
                    <span class="step-icon-pending"><i class="bi bi-circle text-gray-300"></i></span>
                    <span class="step-icon-loading"><i class="bi bi-arrow-repeat text-purple-600 analysis-spinner"></i></span>
                    <span class="step-icon-done"><i class="bi bi-check-circle-fill text-green-500"></i></span>
                    <span class="text-gray-700">Habilidades</span>
                </li>
                <li class="analysis-step flex items-center gap-3" data-step="education">
                    <span class="step-icon-pending"><i class="bi bi-circle text-gray-300"></i></span>
                    <span class="step-icon-loading"><i class="bi bi-arrow-repeat text-purple-600 analysis-spinner"></i></span>
                    <span class="step-icon-done"><i class="bi bi-check-circle-fill text-green-500"></i></span>
                    <span class="text-gray-700">Educação</span>
                </li>
            </ul>

            <p id="analysis-done" class="analysis-done text-center text-gray-500 font-medium">Currículo analisado.</p>
        </div>
    </div>

    <!-- Buttons -->
    <div class="flex justify-end items-center gap-3 pt-2 border-t border-[#E9E5F3]">
        <span class="sf-footer-note hidden sm:inline-flex items-center gap-1">
            <i class="bi bi-shield-lock"></i> Seus dados ficam protegidos pelo Bias Shield
        </span>
        <button id="continue-btn" type="submit" class="sf-btn-continue" disabled>
            Revisar dados
        </button>
    </div>
</form>
</div>

<script>
    const dropzone = document.getElementById('dropzone');
    const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('resume');
    const selectFileBtn = document.getElementById('select-file-btn');
    const continueBtn = document.getElementById('continue-btn');
    const analysisSection = document.getElementById('analysis-section');
    const analysisTitle = document.getElementById('analysis-title');
    const analysisStatus = document.getElementById('analysis-status');
    const analysisDone = document.getElementById('analysis-done');
    const analysisSteps = Array.from(document.querySelectorAll('#analysis-steps .analysis-step'));

    const STEP_LOAD_MS = 700;
    const STEP_DONE_MS = 550;
    const INITIAL_DELAY_MS = 500;

    dropzone.addEventListener('click', () => fileInput.click());
    selectFileBtn.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', handleFileSelect);

    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('dragover');
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('dragover');
    });

    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('dragover');

        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            handleFileSelect();
        }
    });

    function wait(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    function resetAnalysisAnimation() {
        analysisSteps.forEach(step => {
            step.classList.remove('is-visible', 'is-loading', 'is-done');
        });
        analysisStatus.classList.remove('is-visible');
        analysisTitle.classList.remove('is-visible');
        analysisDone.classList.remove('is-visible');
    }

    async function runAnalysisAnimation() {
        resetAnalysisAnimation();

        uploadArea.classList.add('hidden');
        analysisSection.classList.remove('hidden');

        await wait(INITIAL_DELAY_MS);
        analysisTitle.classList.add('is-visible');

        await wait(450);
        analysisStatus.classList.add('is-visible');

        for (const step of analysisSteps) {
            await wait(STEP_LOAD_MS);
            step.classList.add('is-visible', 'is-loading');

            await wait(STEP_DONE_MS);
            step.classList.remove('is-loading');
            step.classList.add('is-done');
        }

        await wait(400);
        analysisDone.classList.add('is-visible');

        continueBtn.disabled = false;
    }

    function handleFileSelect() {
        if (!fileInput.files.length) {
            return;
        }

        continueBtn.disabled = true;

        runAnalysisAnimation();
    }
</script>
@endsection
