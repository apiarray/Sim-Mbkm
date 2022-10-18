@extends('layouts.backend.master')
@section('title', 'Laporan Akhir')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<section class="mt-5">
    <x-cards.regular-card heading="Laporan Akhir Mahasiswa">
        <x-button.button-link text="New Item" class="btn-success mb-4"
            link="{{ route('aktivitas.laporan_akhir.mahasiswa.create')}}" />
        <x-table>
            <x-slot name="header">
                <tr>
                    <th scope="row">ID Validasi Reg</th>
                    <th scope="row">ID Laporan Akhir</th>
                    <th scope="row">Semester</th>
                    <th scope="row">NIM</th>
                    <th scope="row">Nama Siswa</th>
                    <th scope="row">Jurusan</th>
                    <th scope="row">Nama Dosen</th>
                    <th scope="row">Kelas</th>
                    <th scope="row">Program</th>
                    <th scope="row">Tahun Ajaran</th>
                    <th scope="row">Deskripsi</th>
                    <th scope="row">Status Log Book Mingguan</th>
                    <th scope="row">Action</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @foreach($dataLaporan_akhir as $row)
                        <tr>
                            <td scope="col">{{$row->registrasi_mbkm_id}}</td>
                            <td scope="col">{{$row->id}}</td>
                            <td scope="col">{{$row->semester}}</td>
                            <td scope="col">{{$row->nim}}</td>
                            <td scope="col">{{$row->nama_mahasiswa}}</td>
                            <td scope="col">{{$row->jurusan}}</td>
                            <td scope="col">{{$row->nama_dosen}}</td>
                            <td scope="col">{{$row->kelas}}</td>
                            <td scope="col">{{$row->program}}</td>
                            <td scope="col">{{$row->tahun_ajaran}}</td>
                            <td scope="col">{{$row->deskripsi}}</td>
                            <td scope="col">{{$row->status_laporan_akhir}}</td>
                            <td scope="col">
                                <x-button.button-link text="Update" class="btn btn-primary btn-sm" link="{{ route('aktivitas.laporan_akhir.mahasiswa.edit', ['id' => $row->id_laporan_akhir_siswa]) }}" />
                                <x-button text="Delete" class="btn-danger" modalTarget="#modal-delete-{{ $row->id_laporan_akhir_siswa }}" />
                            </td>
                        </tr>
                @endforeach
            </x-slot>
        </x-table>
        <div class="d-flex flex-row justify-content-center mt-3">
        </div>
    </x-cards.regular-card>
</section>
@endsection

@foreach ($dataLaporan_akhir as $item)
<x-modal.modal-delete modalId="modal-delete-{{ $item->id_laporan_akhir_siswa }}" title="Delete Laporan"
    formLink="{{ route('aktivitas.laporan_akhir.mahasiswa.destroy', ['id' => $item->id_laporan_akhir_siswa]) }}" />
@endforeach
