@extends('layouts.candidate-setup')

@section('content')
<div class="flex items-center gap-2 mb-8">
    @for ($i = 1; $i <= 6; $i++)
        <div class="flex items-center gap-2 {{ $i < 6 ? 'flex-1' : 'flex-0' }}">
            <div class="sf-step-dot w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold
                {{ $i <= 6 ? 'text-white' : 'text-[#9C97B5] bg-[#F3EEFE]' }}"
                @if($i <= 6) style="background: linear-gradient(155deg, #7C3AED, #5B21B6);" @endif>
                {{ $i }}
            </div>
            @if($i < 6)
                <div class="h-[2px] flex-1 rounded-full {{ $i <= 5 ? 'bg-[#7C3AED]' : 'bg-[#E9E5F3]' }}"></div>
            @endif
        </div>
    @endfor
</div>

<div class="flex items-center gap-1 mb-2">
    <span class="sf-eyebrow text-xs font-bold uppercase">Etapa 6 de 6</span>
</div>
<h2 class="text-2xl font-bold text-[#17152A] mb-2">Preferências de Vaga</h2>
<p class="text-[#77738F] mb-8">Suas preferências são muito importantes para nós. Vamos usá-las para encontrar as melhores oportunidades para você.</p>

<div class="sf-card bg-white rounded-2xl p-6 md:p-8">
    <form id="pref-form" method="POST" action="{{ route('candidate-setup.step6.post') }}">
        @csrf

        <div class="space-y-8 mb-8">
            <div>
                <div class="sf-field-label-row">
                    <span class="sf-field-icon"><i class="bi bi-briefcase"></i></span>
                    <label for="desired_position" class="sf-field-label mb-0">Cargo desejado</label>
                </div>
                <input type="text" name="desired_position" id="desired_position"
                    value="{{ old('desired_position', $candidate->desired_position ?? '') }}" class="sf-input">
            </div>

            <div>
                <div class="sf-field-label-row">
                    <span class="sf-field-icon"><i class="bi bi-list-check"></i></span>
                    <label class="sf-field-label mb-0">Tipo de contrato</label>
                </div>
                <p class="sf-field-hint">Selecione todos os formatos que você aceita.</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @php
                        $empTypes = ['Full-time', 'Part-time', 'Contract', 'Internship'];
                        $empTrans = ['Full-time' => 'Tempo integral', 'Part-time' => 'Meio período', 'Contract' => 'Contrato', 'Internship' => 'Estágio'];
                    @endphp
                    @foreach ($empTypes as $type)
                        @php $checked = in_array($type, $candidate->employment_type ?? []); @endphp
                        <label class="sf-option flex items-center p-3.5 rounded-xl {{ $checked ? 'is-selected-primary' : '' }}">
                            <input type="checkbox" name="employment_type[]" value="{{ $type }}" class="sf-checkbox mr-3"
                                {{ $checked ? 'checked' : '' }}>
                            <div>
                                <span class="sf-option-text block text-sm font-semibold {{ $checked ? 'text-[#7C3AED]' : 'text-[#47435C]' }}">{{ $empTrans[$type] }}</span>
                                <!-- <span class="text-xs text-[#9C97B5]">{{ $empTrans[$type] }}</span> -->
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <div class="sf-field-label-row">
                    <span class="sf-field-icon"><i class="bi bi-geo-alt"></i></span>
                    <label class="sf-field-label mb-0">Modelo de trabalho</label>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @php
                        $workModels = ['Remote', 'Hybrid', 'On-site'];
                        $workTrans = ['Remote' => 'Remoto', 'Hybrid' => 'Híbrido', 'On-site' => 'Presencial'];
                    @endphp
                    @foreach ($workModels as $model)
                        @php $checked = in_array($model, $candidate->work_model ?? []); @endphp
                        <label class="sf-option flex items-center p-3.5 rounded-xl {{ $checked ? 'is-selected-primary' : '' }}">
                            <input type="checkbox" name="work_model[]" value="{{ $model }}" class="sf-checkbox mr-3"
                                {{ $checked ? 'checked' : '' }}>
                            <div>
                                <span class="sf-option-text block text-sm font-semibold {{ $checked ? 'text-[#7C3AED]' : 'text-[#47435C]' }}">{{ $workTrans[$model] }}</span>
                                <!-- <span class="text-xs text-[#9C97B5]">{{ $workTrans[$model] }}</span> -->
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <div class="sf-field-label-row">
                    <span class="sf-field-icon"><i class="bi bi-cash-stack"></i></span>
                    <label class="sf-field-label mb-0">Expectativa salarial</label>
                </div>
                <p class="sf-field-hint">Opcional — ajuda a encontrar vagas compatíveis.</p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="salary_expectation" id="salary_expectation"
                        value="{{ old('salary_expectation', $candidate->salary_expectation ?? '') }}"
                        class="sf-input flex-1" placeholder="Ex: 8000">
                    <select name="salary_currency" id="salary_currency" class="sf-select sm:max-w-[180px]">
                        <option value="BRL" @selected(($candidate->salary_currency ?? 'BRL') === 'BRL')>BRL - R$</option>
                        <option value="USD" @selected(($candidate->salary_currency ?? 'BRL') === 'USD')>USD - $</option>
                        <option value="EUR" @selected(($candidate->salary_currency ?? 'BRL') === 'EUR')>EUR - €</option>
                    </select>
                </div>
            </div>

            <div>
                <div class="sf-field-label-row">
                    <span class="sf-field-icon shield"><i class="bi bi-calendar3"></i></span>
                    <label class="sf-field-label mb-0">Disponibilidade</label>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @php
                        $avail = ['Immediately', '2 weeks', '1 month', 'Custom'];
                        $availTrans = ['Immediately' => 'Imediatamente', '2 weeks' => '2 semanas', '1 month' => '1 mês', 'Custom' => 'Personalizado'];
                    @endphp
                    @foreach ($avail as $opt)
                        @php $checked = ($candidate->availability ?? '') === $opt; @endphp
                        <label class="sf-option flex items-center p-3.5 rounded-xl {{ $checked ? 'is-selected-primary' : '' }}">
                            <input type="radio" name="availability" value="{{ $opt }}" class="sf-radio mr-3"
                                {{ $checked ? 'checked' : '' }}>
                            <div>
                                <span class="sf-option-text block text-sm font-semibold {{ $checked ? 'text-[#7C3AED]' : 'text-[#47435C]' }}">{{ $availTrans[$opt] }}</span>
                                <!-- <span class="text-xs text-[#9C97B5]">{{ $availTrans[$opt] }}</span> -->
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center gap-3 pt-2 border-t border-[#E9E5F3]">
            <a href="{{ route('candidate-setup.step5') }}" class="sf-btn-back">
                <i class="bi bi-arrow-left mr-2"></i> Voltar
            </a>
            <button type="submit" class="sf-btn-continue">Salvar e Finalizar</button>
        </div>
    </form>
</div>

<script>
    window.sfInitOptions();
</script>
@endsection
