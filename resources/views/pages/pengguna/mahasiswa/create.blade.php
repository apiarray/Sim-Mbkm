@extends('layouts.backend.master')
@section('title', 'New Pengguna - Mahasiswa')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<x-cards.regular-card heading="Insert New Mahasiswa">
    <form action="{{ route('pengguna.mahasiswa.store') }}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nomor Induk Mahasiswa" name="nim" placeholder="Masukkan NIM" />
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nama Mahasiswa" name="nama" placeholder="Masukkan Nama Mahasiswa" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="E-mail" name="email" placeholder="Masukkan E-mail" />
            <x-inputs.textfield class="flex-grow-1 mr-3" label="No. Telp" name="no_telp" placeholder="Masukkan No. Telp" />
            <x-inputs.selector class="flex-grow-1 mr-3" :data="$jenisKelaminList" name="jenis_kelamin" label="Jenis Kelamin" isRequired="true"/>
        </div>
        <!-- START SECTION ALAMAT -->
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Alamat" name="alamat" placeholder="Masukkan Alamat" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="RT" name="alamat_rt" placeholder="Masukkan RT" />
            <x-inputs.textfield class="flex-grow-1 mr-3" label="RW" name="alamat_rw" placeholder="Masukkan RW" />
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Dusun" name="alamat_dusun" placeholder="Masukkan Dusun" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Desa/Kelurahan" name="alamat_desa_kelurahan" placeholder="Masukkan Desa/Kelurahan" />
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Kecamatan" name="alamat_kecamatan" placeholder="Masukkan Kecamatan" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Kode Pos" name="alamat_kode_pos" placeholder="Masukkan Kode Pos" />
            <x-inputs.selector class="flex-grow-1 mr-3" :data="$kotaList" name="alamat_kota_id" label="Kota" />
        </div>
        <!-- END SECTION ALAMAT -->
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Asal Instansi" name="asal_instansi" placeholder="Masukkan Asal Instansi" />
            <x-inputs.textfield class="flex-grow-1 mr-3" label="NISN" name="nisn" placeholder="Masukkan NISN" />
        </div>
        <x-inputs.selector :data="$tahunMasukList" name="tahun_masuk" label="Tahun Masuk" isRequired="true" />
        <x-inputs.selector :data="$statusList" name="status" label="Status Mahasiswa" isRequired="true" />
        <x-inputs.selector :data="$jenisPendaftaran" name="jenis_pendaftaran" label="Jenis Pendaftaran" isRequired="true" value="{{ old('jenis_pendaftaran') ?? NULL }}" />
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Password" name="password" placeholder="Password" />
            <x-inputs.textfield class="flex-grow-1 ml-3" label="Konfirmasi Password" name="password_confirmation" placeholder="Tulis ulang password" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" type="checkbox" isRequired="true" label="Saya mengerti dan ingin melanjutkan" name="checkbox" placeholder="Saya mengerti dan ingin melanjutkan" />
        </div>
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('pengguna.mahasiswa.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection