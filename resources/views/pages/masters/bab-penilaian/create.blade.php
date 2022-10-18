@extends('layouts.backend.master')
@section('title', 'New Item')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<x-cards.regular-card heading="Insert New Data">
    <form action="{{ route('bab_penilaian.store') }}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nama Bab Penilaian" name="nama_bab" placeholder="Nama Bab Penilaian" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Bobot" type="number" name="bobot" max="1" step="0.01" placeholder="Bobot" >
            </x-inputs.textfield>
        </div>
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('bab_penilaian.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection