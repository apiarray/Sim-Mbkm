@extends('layouts.backend.master')
@section('title', 'Update Jenjang')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<x-cards.regular-card heading="Insert New Data">
    <form action="{{ route('jenjang.update', [$jenjang->id]) }}" method="post" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nama Jenjang" name="nama" placeholder="Nama Jenjang"
                value="{{ $jenjang->nama }}" />
            <x-inputs.textfield class="flex-grow-1 ml-3" label="Kode Jenjang" name="kode" placeholder="Kode Jenjang"
                value="{{ $jenjang->kode }}" />
        </div>
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('jenjang.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection