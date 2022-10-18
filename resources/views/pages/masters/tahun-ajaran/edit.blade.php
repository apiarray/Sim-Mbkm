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
    <form action="{{ route('tahun_ajaran.update', ['id' => $tahunAjaran->id]) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Tahun Ajaran" name="tahun_ajaran" value="{{ $tahunAjaran->tahun_ajaran }}" />
            <x-inputs.selector.semester-selector class="flex-grow-1" :data="$semesterList" value="{{ $tahunAjaran->semester->id }}" />
        </div>
        <x-inputs.selector.tahun-status-selector value="{{ $tahunAjaran->status }}" />
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('tahun_ajaran.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection