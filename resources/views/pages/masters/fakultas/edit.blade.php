@extends('layouts.backend.master')
@section('title', 'New Item')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<x-cards.regular-card heading="Update Data">
    <form action="{{ route('fakultas.update', ['id' => $fakultas->id]) }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nama Fakultas" name="nama" value="{{ $fakultas->nama }}"/>
            <x-inputs.textfield class="flex-grow-1 ml-3" label="Kode Fakultas" name="kode" value="{{ $fakultas->kode }}"/>
        </div>
        <x-inputs.selector.jenjang-selector label="Jenis Jenjang" name="jenjang_id" :data="$jenjangList" value="{{ $fakultas->jenjang->id }}">
            <small>Tambah data baru melalui <a href="{{ route('jenjang.create') }}">data master - jenjang</a>.</small>
        </x-inputs.selector.jenjang-selector>
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('fakultas.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection