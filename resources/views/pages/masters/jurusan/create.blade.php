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
    <form action="{{ route('jurusan.store') }}" method="POST" autocomplete="off">
        @csrf
        @method('POST')
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nama Jurusan" name="nama" />
            <x-inputs.textfield class="flex-grow-1 ml-3" label="Kode Jurusan" name="kode" />
        </div>
        <x-inputs.selector.fakultas-selector :data="$fakultasList" />
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('jurusan.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection