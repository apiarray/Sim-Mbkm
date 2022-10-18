@props([
    'type' => 'success',
    'title' => 'Success',
    'message' => '',
    'class' => ''
])

<div {{ $attributes->merge(['class' => "alert alert-$type alert-dismissible fade show" . $class]) }} role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{!! $title !!}: </strong>
    {!! $message !!}
</div>