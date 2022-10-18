@extends('layouts.backend.master')
@section('title', 'Update Item')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<x-cards.regular-card heading="Update Data">
    <form action="{{ route('bab_penilaian.update', ['id' => $babPenilaian->id]) }}" method="post" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nama Bab Penilaian" name="nama_bab" placeholder="Nama Bab Penilaian" value="{{ $babPenilaian->nama_bab }}" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Bobot" name="bobot" type="number" step="0.01" max="1" placeholder="Bobot" value="{{ $babPenilaian->bobot }}" />
        </div>
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('bab_penilaian.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection