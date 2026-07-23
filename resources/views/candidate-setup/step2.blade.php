@extends('layouts.candidate-setup')

@section('content')
<div class="flex items-center gap-2 mb-8">
    @for ($i = 1; $i <= 6; $i++)
        <div class="flex items-center gap-2 {{ $i < 6 ? 'flex-1' : 'flex-0' }}">
            <div class="sf-step-dot w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold
                {{ $i <= 2 ? 'text-white' : 'text-[#9C97B5] bg-[#F3EEFE]' }}"
                @if($i <= 2) style="background: linear-gradient(155deg, #7C3AED, #5B21B6);" @endif>
                {{ $i }}
            </div>
            @if($i < 6)
                <div class="h-[2px] flex-1 rounded-full {{ $i <= 1 ? 'bg-[#7C3AED]' : 'bg-[#E9E5F3]' }}"></div>
            @endif
        </div>
    @endfor
</div>

<div class="flex items-center gap-1 mb-2">
    <span class="sf-eyebrow text-xs font-bold uppercase">Etapa 2 de 6</span>
</div>
<h2 class="text-2xl font-bold text-[#17152A] mb-2">Complete seu perfil de candidato</h2>
<p class="text-[#77738F] mb-8">Conte-nos sobre você para que possamos calibrar o Bias Shield desde o primeiro dia.</p>

<div class="sf-card bg-white rounded-2xl p-6 md:p-8">
    <form id="info-form" method="POST" action="{{ route('candidate-setup.step2.post') }}">
        @csrf

        <div class="mb-9">
            <div class="sf-field-label-row">
                <span class="sf-field-icon"><i class="bi bi-person"></i></span>
                <label class="sf-field-label mb-0">Informações Pessoais</label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="full_name" class="sf-field-label">Nome Completo</label>
                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $candidate->full_name ?? '') }}" required
                        class="sf-input" placeholder="Seu nome completo">
                </div>
                <div>
                    <label for="phone" class="sf-field-label">Telefone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $candidate->phone ?? '') }}"
                        class="sf-input" placeholder="Seu telefone">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="city" class="sf-field-label">Cidade</label>
                    <input type="text" name="city" id="city" value="{{ old('city', $candidate->city ?? '') }}"
                        class="sf-input" placeholder="Sua cidade">
                </div>
                <div>
                    <label for="country" class="sf-field-label">País <span class="text-[#9C97B5] font-normal">(Opcional)</span></label>
                    <input type="text" name="country" id="country" value="{{ old('country', $candidate->country ?? '') }}"
                        class="sf-input" placeholder="Seu país">
                </div>
            </div>

            <div class="mb-4">
                <label for="linkedin" class="sf-field-label">LinkedIn</label>
                <input type="text" name="linkedin" id="linkedin" value="{{ old('linkedin', $candidate->linkedin ?? '') }}"
                    class="sf-input" placeholder="linkedin.com/in/seu-perfil">
            </div>

            <div>
                <label for="portfolio" class="sf-field-label">Portfólio / GitHub</label>
                <input type="text" name="portfolio" id="portfolio" value="{{ old('portfolio', $candidate->portfolio ?? '') }}"
                    class="sf-input" placeholder="github.com/seu-perfil">
            </div>
        </div>

        <div class="flex justify-between items-center gap-3 pt-2 border-t border-[#E9E5F3]">
            <a href="{{ route('candidate-setup.step1') }}" class="sf-btn-back">
                <i class="bi bi-arrow-left mr-2"></i> Voltar
            </a>
            <div class="flex items-center gap-3">
                <span class="sf-footer-note hidden sm:inline-flex items-center gap-1">
                    <i class="bi bi-shield-lock"></i> Seus dados ficam protegidos pelo Bias Shield
                </span>
                <button type="submit" class="sf-btn-continue">Continuar</button>
            </div>
        </div>
    </form>
</div>
@endsection
