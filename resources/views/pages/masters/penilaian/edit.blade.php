@extends('layouts.backend.master')
@section('title', 'Update Soal Penilaian')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<x-cards.regular-card heading="Update Data">
    <form action="{{ route('penilaian.update', ['id' => $penilaian->id]) }}" method="post" autocomplete="off">
        @csrf
        @method('PUT')
        <x-inputs.selector.bab-penilaian-selector label="Bab Penilaian" name="bab_penilaian_id" :data="$babPenilaianList" value="{{ $penilaian->bab_penilaian_id }}">
        </x-inputs.selector.bab-penilaian-selector>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Soal Penilaian" name="soal_penilaian" placeholder="Soal Penilaian" value="{{ $penilaian->soal_penilaian }}" />
        </div>
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('penilaian.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection