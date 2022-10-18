@props([
    'class' => '',
    'type' => 'text',
    'label' => '',
    'name' => '',
    'value' => '',
    'description' => null,
    'isRequired' => false,
    'placeholder' => '',
    'error' => null,
    'step' => null,
    'max' => null,
    'min' => null
])

<div {{ $attributes->merge(['class' => 'form-group ' . $class]) }}>
    @if ($label)
        <label>{{ $label }}</label>
    @endif

    <input type="{{ $type }}" {{ $type != 'checkbox' ? 'class=form-control' : '' }} name="{{ $name }}" placeholder="{{ $placeholder ? $placeholder : $label }}"
        value="{{ $value ? $value : old($name) }}" {{ $isRequired ? 'required' : '' }} max="{{ $max }}" min="{{ $min }}" step="{{ $step }}">

    @if ($slot)
        {{ $slot }}
    @endif

    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>