@extends('layouts.backend.master')
@section('title', 'Detail Mahasiswa')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<section class="mt-5">
    <x-cards.regular-card heading="Detail Mahasiswa">
        <div class="row">
            <div class="col-md-6">
                <x-table>
                    <x-slot name="header">
                        <h5>Data Diri</h5>
                    </x-slot>
                    <x-slot name="body">
                        <tr>
                            <th scope="row">NIM</th>
                            <th>: {{ $dataMahasiswa->nim }}</th>
                        </tr>
                        <tr>
                            <th scope="row">Nama</th>
                            <th>: {{ $dataMahasiswa->nama }}</th>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <th>: {{ $dataMahasiswa->email }}</th>
                        </tr>
                        <tr>
                            <th scope="row">No. Telp</th>
                            <th>: {{ $dataMahasiswa->no_telp }}</th>
                        </tr>
                        <tr>
                            <th scope="row">Asal Instansi</th>
                            <th>: {{ $dataMahasiswa->asal_instansi }}</th>
                        </tr>
                        <tr>
                            <th scope="row">NISN</th>
                            <th>: {{ $dataMahasiswa->nisn }}</th>
                        </tr>
                        <tr>
                            <th scope="row">Fakultas</th>
                            <th>: {!! $dataMahasiswa->registrasi_mbkm_aktif->kelas->jurusan->fakultas->nama ?? '<small class="text-muted">(Belum Registrasi/Registrasi Belum di Validasi)</small>' !!}</th>
                        </tr>
                        <tr>
                            <th scope="row">Jurusan</th>
                            <th>: {!! $dataMahasiswa->registrasi_mbkm_aktif->kelas->jurusan->nama ?? '<small class="text-muted">(Belum Registrasi/Registrasi Belum di Validasi)</small>' !!}</th>
                        </tr>
                        <tr>
                            <th scope="row">Kelas</th>
                            <th>: {!! $dataMahasiswa->registrasi_mbkm_aktif->kelas->nama ?? '<small class="text-muted">(Belum Registrasi/Registrasi Belum di Validasi)</small>' !!}</th>
                        </tr>
                    </x-slot>
                </x-table>
            </div>
            <div class="col-md-6">
                <x-table>
                    <x-slot name="header">
                        <h5>Alamat</h5>
                    </x-slot>
                    <x-slot name="body">
                        <tr>
                            <th scope="row">Alamat</th>
                            <th>: {{ $dataMahasiswa->alamat }} {{ $dataMahasiswa->alamat_rt ? 'RT ' . $dataMahasiswa->alamat_rt : '' }} {{ $dataMahasiswa->alamat_rw ? 'RW ' . $dataMahasiswa->alamat_rw : '' }}</th>
                        </tr>
                        <tr>
                            <th scope="row">Dusun</th>
                            <th>: {{ $dataMahasiswa->alamat_dusun ?? ''}}</th>
                        </tr>
                        <tr>
                            <th scope="row">Desa/Kelurahan</th>
                            <th>: {{ $dataMahasiswa->alamat_desa_kelurahan ?? ''}}</th>
                        </tr>
                        <tr>
                            <th scope="row">Kecamatan</th>
                            <th>: {{ $dataMahasiswa->alamat_kecamatan ?? ''}}</th>
                        </tr>
                        <tr>
                            <th scope="row">Kota/Kabupaten</th>
                            <th>: {{ $dataMahasiswa->alamat_kota->nama ?? ''}}</th>
                        </tr>
                        <tr>
                            <th scope="row">Provinsi</th>
                            <th>: {{ $dataMahasiswa->alamat_kota->provinsi->nama ?? ''}}</th>
                        </tr>
                    </x-slot>
                </x-table>
            </div>
        </div>
        <div class="d-flex flex-row mt-3">
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('pengguna.mahasiswa.index') }}" />
        </div>
    </x-cards.regular-card>
    <x-cards.regular-card heading="Riwayat Registrasi Mahasiswa">
        <x-table>
            <x-slot name="body">
                <tr>
                    <th scope="row">Tahun Ajaran</th>
                    <th scope="row">Semester</th>
                    <th scope="row">Kelas</th>
                    <th scope="row">Status</th>
                    <th scope="row">Tgl. Registrasi</th>
                    <th scope="row">Tgl. Validasi</th>
                </tr>
                @if(count($dataMahasiswa->registrasi_mbkm) > 0)
                @foreach($dataMahasiswa->registrasi_mbkm->sortByDesc('tanggal_registrasi') as $reg)
                <tr>
                    <td scope="row">{{ $reg->tahunAjaran->tahun_ajaran ?? '' }}</td>
                    <td scope="row">{{ $reg->tahunAjaran->semester->nama ?? '' }}</td>
                    <td scope="row">{{ $reg->kelas->nama ?? '' }}</td>
                    <td scope="row">{{ strtoupper($reg->status_validasi) }}</td>
                    <td scope="row">{{ $reg->tanggal_registrasi }}</td>
                    <td scope="row">{{ $reg->tanggal_validasi }}</td>
                </tr>
                @endforeach
                @endif
            </x-slot>
        </x-table>
    </x-cards.regular-card>
</section>

@endsection