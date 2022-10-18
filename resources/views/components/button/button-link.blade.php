@props([
    'class' => '',
    'link' => '',
    'text' => ''
])

<a {{ $attributes->merge(['class' => 'btn btn-sm ' . $class]) }} href="{{ $link }}" role="button">
    {!! $text !!}
</a>