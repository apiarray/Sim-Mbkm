@props([
    'heading' => "",
    'class' => ""
])

<div {{ $attributes->merge(['class' => 'card ' . $class]) }}>
    <div class="card-header">
        <h5>{{ $heading }}</h5>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>