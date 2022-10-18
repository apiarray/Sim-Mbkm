@props([
'type' => 'button',
'class' => '',
'text' => '',
'dataToggle' => 'modal',
'modalTarget' => '',
'dataDismiss' => 'false'
])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn btn-sm ' . $class]) }} data-toggle="{{ $dataToggle }}"
    data-target="{{ $modalTarget }}" data-dismiss="{{ $dataDismiss }}">
    {{ $text }}
</button>