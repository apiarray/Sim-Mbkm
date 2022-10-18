@extends('layouts.backend.master')
@section('title', 'Update Pengguna Dosen')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<x-cards.regular-card heading="Update Data Pengguna - Dosen">
    <form action="{{ route('pengguna.dosen.update', ['id' => $dataDosen->id]) }}" method="post" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nomor Induk Pegawai" name="nip" placeholder="Nomor Induk Pegawai" value="{{ $dataDosen->nip }}"/>
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="E-mail" name="email" placeholder="E-mail" value="{{ $dataDosen->email }}"/>
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nama Lengkap" name="nama" placeholder="Nama Lengkap" value="{{ $dataDosen->nama }}"/>
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Password" name="password" placeholder="Password" >
            <span class="small text-secondary">* Kosongkan password jika tidak ingin merubah</span>
            </x-inputs.textfield>
            <x-inputs.textfield class="flex-grow-1 ml-3" label="Konfirmasi Password" name="password_confirmation" placeholder="Tulis ulang password" >
            </x-inputs.textfield>
        </div>
        <x-inputs.selector.fakultas-selector :data="$fakultasList" value="{{ $dataDosen->fakultas_id }}"/>
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('pengguna.dosen.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection