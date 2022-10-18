@extends('layouts.backend.master')
@section('title', 'New Pengguna - Mahasiswa')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

@if($errors->any())
    <x-alert type="danger" title="Error" message="
    {!! implode('', $errors->all('<div>:message</div>')) !!}"
    />
@endif

<x-cards.regular-card heading="Edit Mahasiswa">
    <form action="{{ route('pengguna.mahasiswa.update', ['id' => $dataMahasiswa->id]) }}" method="post" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nomor Induk Mahasiswa" name="nim" placeholder="Masukkan NIM" value="{{ $dataMahasiswa->nim }}" />
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nama Mahasiswa" name="nama" placeholder="Masukkan Nama Mahasiswa" value="{{ $dataMahasiswa->nama }}" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="E-mail" name="email" placeholder="Masukkan E-mail" value="{{ $dataMahasiswa->email }}" />
            <x-inputs.textfield class="flex-grow-1 mr-3" label="No. Telp" name="no_telp" placeholder="Masukkan No. Telp" value="{{ $dataMahasiswa->no_telp }}" />
            <x-inputs.selector class="flex-grow-1 mr-3" :data="$jenisKelaminList" name="jenis_kelamin" label="Jenis Kelamin" isRequired="true" value="{{ $dataMahasiswa->jenis_kelamin }}" />
        </div>
        <!-- START SECTION ALAMAT -->
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Alamat" name="alamat" placeholder="Masukkan Alamat" value="{{ $dataMahasiswa->alamat }}" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="RT" name="alamat_rt" placeholder="Masukkan RT" value="{{ $dataMahasiswa->alamat_rt }}" />
            <x-inputs.textfield class="flex-grow-1 mr-3" label="RW" name="alamat_rw" placeholder="Masukkan RW" value="{{ $dataMahasiswa->alamat_rw }}" />
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Dusun" name="alamat_dusun" placeholder="Masukkan Dusun" value="{{ $dataMahasiswa->alamat_dusun }}" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Desa/Kelurahan" name="alamat_desa_kelurahan" placeholder="Masukkan Desa/Kelurahan" value="{{ $dataMahasiswa->alamat_desa_kelurahan }}" />
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Kecamatan" name="alamat_kecamatan" placeholder="Masukkan Kecamatan" value="{{ $dataMahasiswa->alamat_kecamatan }}" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Kode Pos" name="alamat_kode_pos" placeholder="Masukkan Kode Pos" value="{{ $dataMahasiswa->alamat_kode_pos }}" />
            <x-inputs.selector class="flex-grow-1 mr-3" :data="$kotaList" name="alamat_kota_id" label="Kota" value="{{ $dataMahasiswa->alamat_kota_id }}" />
        </div>
        <!-- END SECTION ALAMAT -->
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Asal Instansi" name="asal_instansi" placeholder="Masukkan Asal Instansi" value="{{ $dataMahasiswa->asal_instansi }}" />
            <x-inputs.textfield class="flex-grow-1 mr-3" label="NISN" name="nisn" placeholder="Masukkan NISN" value="{{ $dataMahasiswa->nisn }}" />
        </div>
        <x-inputs.selector :data="$tahunMasukList" name="tahun_masuk" label="Tahun Masuk" isRequired="true" value="{{ $dataMahasiswa->tahun_masuk }}" />
        <x-inputs.selector :data="$statusList" name="status" label="Status Mahasiswa" isRequired="true" value="{{ $dataMahasiswa->status }}" />
        <x-inputs.selector :data="$jenisPendaftaran" name="jenis_pendaftaran" label="Jenis Pendaftaran" isRequired="true" value="{{ $dataMahasiswa->jenis_pendaftaran }}" />
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Password" name="password" placeholder="Password">
            <span class="small text-secondary">* Kosongkan password jika tidak ingin merubah</span>
            </x-inputs.textfield>
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