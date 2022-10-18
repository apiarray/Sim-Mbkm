@props([
    'header' => null,
    'body' => null,
    'footer' => null,
    'class' => ""
])
<div class="table-responsive">
    <table {{ $attributes->merge(['class' => 'table' . $class]) }}>
        <thead>
            {{ $header }}
        </thead>
        <tbody>
            {{ $body }}
        </tbody>
        <tfoot>
            {{ $footer }}
        </tfoot>
    </table>
</div>