@props([
'label',
'name',
'type' => 'text',
'placeholder' => '',
'icon' => 'bi-input',
'required' => false,
'value' => '',
'rows' => 4,
'options' => [], // for select
'id' => null,
])

@php
$id = $id ?? $name;
@endphp

<style>
    .select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
</style>

<div class="mb-4">
    <label class="field-label" for="{{ $id }}">{{ $label }}</label>
    <div class="input-group-custom" style="{{ $type === 'textarea' ? 'align-items: flex-start; padding-top: 0.65rem;' : '' }}">
        <i class="bi {{ $icon }}" style="color: #7C3AED; {{ $type === 'textarea' ? 'padding-top: 0.3rem;' : '' }}"></i>

        @if($type === 'textarea')
        <textarea
            name="{{ $name }}"
            id="{{ $id }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            class="border-none border-0 outline-0 bg-transparent px-3 py-1 outline-none w-full"
            rows="{{ $rows }}"
            style="resize: vertical;">{{ old($name, $value) }}</textarea>
        @elseif($type === 'select')
        <select
            name="{{ $name }}"
            id="{{ $id }}"
            {{ $required ? 'required' : '' }}
            class="border-none bg-transparent px-3 py-2.5 outline-none w-full select">
            @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ old($name, $value) === $optionValue ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
            @endforeach
        </select>
        @else
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $id }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            value="{{ old($name, $value) }}">
        @endif
    </div>
</div>