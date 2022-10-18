@extends('layouts.backend.master')
@section('title', 'Detail Penilaian')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<section class="mt-5">
    <x-cards.regular-card heading="Detail Penilaian">
        <x-table>
            <x-slot name="body">
                <tr>
                    <th scope="row">Bab Penilaian</th>
                    <th>: {{ $penilaian->bab_penilaian->nama_bab ?? '' }}</th>
                </tr>
                <tr>
                    <th scope="row">Soal Penilaian</th>
                    <th>: {{$penilaian->soal_penilaian}}</th>
                </tr>
                <!-- <tr>
                    <th scope="row">Bobot <span class="small">(Jika ada)</span></th>
                    <th>:</th>
                </tr> -->
            </x-slot>
        </x-table>
        <div class="d-flex flex-row mt-3">
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('penilaian.index') }}" />
        </div>
    </x-cards.regular-card>
    <x-cards.regular-card heading="Daftar Pilihan">
        <x-button.button-link text="New Pilihan" class="btn-success mb-4" link="{{ route('penilaian.pilihan_penilaian.create', ['id' => $penilaian->id]) }}" />
        <x-table>
            <x-slot name="header">
                <tr>
                    <th scope="row">Isi Pilihan Penilaian</th>
                    <th scope="row">Bobot</th>
                    <th scope="row">Action</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @if ($pilihanPenilaianList->count() > 0)
                    @foreach ($pilihanPenilaianList as $item)
                    <tr>
                        <td scope="col">{{ $item->isi_pilihan }}</td>
                        <td scope="col">{{ $item->bobot }}</td>
                        <td scope="col">
                            <x-button.button-link text="Edit" class="btn-info"
                                link="{{ route('penilaian.pilihan_penilaian.edit', ['id' => $penilaian->id, 'id_pilihan' => $item->id]) }}" />
                            <x-button text="Delete" class="btn-danger" modalTarget="#modal-delete-{{ $item->id }}" />
                        </td>
                    </tr>
                    @endforeach
                @else
                    <x-table.tr.empty-row colCount="5" />
                @endif
            </x-slot>
        </x-table>
    </x-cards.regular-card>
</section>
@endsection

@foreach ($pilihanPenilaianList as $item)
<x-modal.modal-delete modalId="modal-delete-{{ $item->id }}" title="Delete Bab Penilaian"
    formLink="{{ route('penilaian.pilihan_penilaian.destroy', ['id' => $penilaian->id, 'id_pilihan' => $item->id]) }}" />
@endforeach