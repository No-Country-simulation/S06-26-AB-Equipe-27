@extends('layouts.setup')

@section('content')
<style>
    /* ==========================================================
       SKILLFOCUS — TOKENS (mesma paleta usada nas views Bootstrap
       de /jobs, /reports, /matches e nas telas de auth)
    ========================================================== */
    .sf-eyebrow {
        color: #7C3AED;
        letter-spacing: .08em;
    }

    .sf-card {
        border: 1px solid #E9E5F3;
        box-shadow: 0 1px 2px rgba(23, 21, 42, .04), 0 10px 28px -14px rgba(23, 21, 42, .14);
    }

    .sf-option {
        border: 2px solid #E9E5F3;
        transition: all .18s ease;
    }

    .sf-option:hover {
        border-color: #C9BEF2;
        background-color: #FBFAFF;
    }

    .sf-option.is-selected-primary {
        border-color: #7C3AED;
        background-color: #F3EEFE;
    }

    .sf-option.is-selected-shield {
        border-color: #0D9488;
        background-color: #E8F8F6;
    }

    .sf-radio:checked {
        accent-color: #7C3AED;
    }

    .sf-checkbox:checked {
        accent-color: #0D9488;
    }

    .sf-btn-continue {
        background: linear-gradient(155deg, #7C3AED, #5B21B6);
        box-shadow: 0 10px 22px -10px rgba(124, 58, 237, .6);
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .sf-btn-continue:hover {
        transform: translateY(-1px);
        box-shadow: 0 14px 26px -10px rgba(124, 58, 237, .7);
    }

    .sf-step-dot {
        transition: all .2s ease;
    }
</style>

<!-- Indicador de progresso do wizard -->
<div class="flex items-center gap-2 mb-8">
    @for ($i = 1; $i <= 4; $i++)
        <div class="flex items-center gap-2 {{$i < 4 ? 'flex-1' : 'flex-0'}}">
        <div class="sf-step-dot w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold
                    {{ $i === 1 ? 'text-white' : 'text-[#9C97B5] bg-[#F3EEFE]' }}"
            @if($i===1) style="background: linear-gradient(155deg, #7C3AED, #5B21B6);" @endif>
            {{ $i }}
        </div>

        @if($i < 4)
            <div class="h-[2px] flex-1 rounded-full {{ $i === 1 ? 'bg-[#7C3AED]' : 'bg-[#E9E5F3]' }}">
</div>
@endif
</div>
@endfor
</div>

<div class="flex items-center gap-1 mb-2">
    <span class="sf-eyebrow text-xs font-bold uppercase">Etapa 1 de 4</span>
</div>
<h2 class="text-2xl font-bold text-[#17152A] mb-2">Perfil de Diversidade da Empresa</h2>
<p class="text-[#77738F] mb-8">Conte-nos sobre sua empresa para calibrarmos o Bias Shield desde o primeiro dia.</p>

<div class="sf-card bg-white rounded-2xl p-6 md:p-8">
    <form method="POST" action="{{ route('setup.step1.post') }}">
        @csrf

        <!-- Validation Errors -->
        @if ($errors->any())
        <div class="mb-8 bg-[#FDEAEA] border border-[#F5C6C6] p-4 rounded-xl">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-[#B91C1C]" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold text-[#991B1B]">Ops! Algo deu errado.</h3>
                    <div class="mt-2 text-sm text-[#B91C1C]">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Company Size -->
        <div class="mb-9">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-8 h-8 rounded-lg bg-[#F3EEFE] text-[#7C3AED] inline-flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1m-1 4h1m4-4h1m-1 4h1m-9 8v-4a2 2 0 012-2h2a2 2 0 012 2v4" />
                    </svg>
                </span>
                <label class="block text-sm font-semibold text-[#17152A]">Tamanho da Empresa</label>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                @foreach(['1-10', '11-50', '51-200', '201-1000', '1000+'] as $size)
                <label class="sf-option flex items-center justify-center p-4 rounded-xl cursor-pointer
                    {{ old('size', $company->size) === $size ? 'is-selected-primary' : '' }}">
                    <input type="radio" name="size" value="{{ $size }}" class="sf-radio mr-2 w-4 h-4"
                        {{ old('size', $company->size) === $size ? 'checked' : '' }} required>
                    <span class="font-semibold text-sm {{ old('size', $company->size) === $size ? 'text-[#7C3AED]' : 'text-[#47435C]' }}">{{ $size }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Work Model -->
        <div class="mb-9">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-8 h-8 rounded-lg bg-[#F3EEFE] text-[#7C3AED] inline-flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
                    </svg>
                </span>
                <label class="block text-sm font-semibold text-[#17152A]">Modelo de Trabalho</label>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach(['remote' => 'Remoto', 'hybrid' => 'Híbrido', 'on-site' => 'Presencial'] as $value => $label)
                <label class="sf-option flex items-center p-4 rounded-xl cursor-pointer
                    {{ old('work_model', $company->work_model) === $value ? 'is-selected-primary' : '' }}">
                    <input type="radio" name="work_model" value="{{ $value }}" class="sf-radio mr-3 w-4 h-4"
                        {{ old('work_model', $company->work_model) === $value ? 'checked' : '' }} required>
                    <span class="font-semibold text-sm {{ old('work_model', $company->work_model) === $value ? 'text-[#7C3AED]' : 'text-[#47435C]' }}">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Inclusion Programs -->
        <div class="mb-9">
            <div class="flex items-center gap-2 mb-1">
                <span class="w-8 h-8 rounded-lg bg-[#E8F8F6] text-[#0D9488] inline-flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <label class="block text-sm font-semibold text-[#17152A]">Programas de Inclusão</label>
            </div>
            <p class="text-xs text-[#9C97B5] mb-4 ml-10">Selecione todos os que já existem hoje na empresa.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @php
                $programs = [
                'diversity_committee' => 'Comitê de Diversidade',
                'accessibility_program' => 'Programa de Acessibilidade',
                'mentorship_program' => 'Programa de Mentoria',
                'internship_program' => 'Programa de Estágio',
                'returnship_program' => 'Programa de Retorno ao Trabalho',
                'erg' => 'Grupos de Recursos de Funcionários (ERGs)',
                ];
                $selectedPrograms = old('inclusion_programs', $company->inclusion_programs ?? []);
                @endphp
                @foreach($programs as $value => $label)
                <label class="sf-option flex items-center p-3.5 rounded-xl cursor-pointer
                    {{ in_array($value, (array)$selectedPrograms) ? 'is-selected-shield' : '' }}">
                    <input type="checkbox" name="inclusion_programs[]" value="{{ $value }}" class="sf-checkbox mr-3 w-4 h-4"
                        {{ in_array($value, (array)$selectedPrograms) ? 'checked' : '' }}>
                    <span class="text-sm font-medium {{ in_array($value, (array)$selectedPrograms) ? 'text-[#0D9488]' : 'text-[#47435C]' }}">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Diversity Statement -->
        <div class="mb-9">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-8 h-8 rounded-lg bg-[#F3EEFE] text-[#7C3AED] inline-flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </span>
                <label class="block text-sm font-semibold text-[#17152A]">Declaração de Diversidade</label>
            </div>
            <div class="border-2 border-dashed border-[#E9E5F3] rounded-xl p-5 bg-[#FBFAFF] focus-within:border-[#C9BEF2] transition-colors">
                <textarea name="diversity_statement" rows="4"
                    class="w-full bg-transparent border-none resize-none focus:ring-0 text-[#47435C] text-sm p-0 placeholder:text-[#ACA8C2]"
                    placeholder="Estamos comprometidos em criar um ambiente de trabalho inclusivo onde profissionais de todos os fundos possam prosperar.">{{ old('diversity_statement', $company->diversity_statement) }}</textarea>
            </div>
        </div>

        <!-- Continue Button -->
        <div class="flex justify-end items-center gap-3 pt-2 border-t border-[#E9E5F3]">
            <span class="text-xs text-[#9C97B5] mr-auto hidden sm:inline-flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Seus dados ficam protegidos pelo Bias Shield
            </span>
            <button type="submit" class="sf-btn-continue text-white font-semibold py-3 px-8 rounded-xl">
                Continuar
            </button>
        </div>
    </form>
</div>
@endsection