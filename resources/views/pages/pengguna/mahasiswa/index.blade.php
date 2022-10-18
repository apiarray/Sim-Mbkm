@extends('layouts.backend.master')
@section('title', 'Pengguna - Mahasiswa')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<section class="mt-5">
    <x-cards.regular-card heading="Data Pengguna - Mahasiswa">
        <x-button.button-link text="New Mahasiswa" class="btn-success mb-4" link="{{ route('pengguna.mahasiswa.create') }}" />
        <x-button.button-link text="<i data-feather='upload'></i> Upload Mahasiswa" class="btn-primary mb-4 float-right" link="{{ route('pengguna.mahasiswa.upload_view') }}" />
        <x-table>
            <x-slot name="header">
                <tr>
                    <th scope="row">Mahasiswa</th>
                    <th scope="row">Program Studi</th>
                    <th scope="row">E-mail</th>
                    <th scope="row">No. Telp</th>
                    <th scope="row">Status</th>
                    <th scope="row">Action</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @if ($dataMahasiswaList->total())
                    @foreach ($dataMahasiswaList as $item)
                    <tr>
                        <td scope="col">{{ $item->nama }} <br> <small>NIM: <b>{{ $item->nim }}</b></small> </td>
                        <td scope="col">{{ $item->registrasi_mbkm_aktif->kelas->jurusan->fakultas->jenjang->kode ?? '' }} / {{ $item->registrasi_mbkm_aktif->kelas->jurusan->fakultas->nama ?? '(belum register)' }}</td>
                        <td scope="col">{{ $item->email }}</td>
                        <td scope="col">{{ $item->no_telp }}</td>
                        <td scope="col">{{ str_replace('_', ' ', strtoupper($item->status)) }}</td>
                        <td scope="col">
                            <x-button.button-link text="Detail" class="btn-success"
                                link="{{ route('pengguna.mahasiswa.show', $item->id) }}" />
                            <x-button.button-link text="Edit" class="btn-info"
                                link="{{ route('pengguna.mahasiswa.edit', $item->id) }}" />
                            @if((auth()->guard('mahasiswa')->user()->id ?? NULL) != $item->id)
                            <x-button text="Delete" class="btn-danger" modalTarget="#modal-delete-{{ $item->id }}" />
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <x-table.tr.empty-row colCount="6" />
                @endif
            </x-slot>
        </x-table>
        <div class="d-flex flex-row justify-content-center mt-3">
            {{ $dataMahasiswaList->links() }}
        </div>
    </x-cards.regular-card>
</section>
@endsection

@foreach ($dataMahasiswaList as $item)
<x-modal.modal-delete modalId="modal-delete-{{ $item->id }}" title="Delete Mahasiswa"
    formLink="{{ route('pengguna.mahasiswa.destroy', ['id' => $item->id]) }}" />
@endforeach