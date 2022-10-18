@extends('layouts.backend.master')
@section('title', 'New Item')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('message') }}" />
@endif

<x-cards.regular-card heading="Insert New Data">
    <form action="{{ route('identitas_universitas.store') }}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Property" name="property" placeholder="Property" />
            <x-inputs.textfield class="flex-grow-1 ml-3" label="Value" name="value" placeholder="Value" />
        </div>
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit"/>
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('identitas_universitas.index') }}"/>
        </div>
    </form>
</x-cards.regular-card>
@endsection