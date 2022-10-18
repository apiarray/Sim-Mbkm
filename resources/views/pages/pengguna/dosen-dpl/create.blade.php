@extends('layouts.backend.master')
@section('title', 'New Pengguna - Dosen')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<x-cards.regular-card heading="Insert New Dosen">
    <form action="{{ route('pengguna.dosen.store') }}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nomor Induk Pegawai" name="nip" placeholder="Nomor Induk Pegawai" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="E-mail" name="email" placeholder="E-mail" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nama Lengkap" name="nama" placeholder="Nama Lengkap" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Password" name="password" placeholder="Password" />
            <x-inputs.textfield class="flex-grow-1 ml-3" label="Konfirmasi Password" name="password_confirmation" placeholder="Tulis ulang password" />
        </div>
        <x-inputs.selector.fakultas-selector :data="$fakultasList" />
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" type="checkbox" isRequired="true" label="Saya mengerti dan ingin melanjutkan" name="checkbox" placeholder="Saya mengerti dan ingin melanjutkan" />
        </div>
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('pengguna.dosen.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection