@extends('layouts.backend.master')
@section('title', 'Data Tahun Ajaran')
@section('content')

@if (session('message'))
    <x-alert title="Success" message="{{ session('message') }}" />
@endif

@if (session('error'))
    <x-alert type="danger" title="Error" message="{{ session('error') }}" />
@endif

<section class="mt-5">
    <x-cards.regular-card heading="Data Tahun Ajaran">
        <x-button.button-link text="New Item" class="btn-success mb-4" link="{{ route('tahun_ajaran.create') }}" />
        <x-table>
            <x-slot name="header">
                <tr>
                    <th scope="row">Nama Tahun Ajaran</th>
                    <th scope="row">Semester</th>
                    <th scope="row">Status</th>
                    <th scope="row">Action</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @if ($tahunAjaranList->total() > 0)
                @foreach ($tahunAjaranList as $item)
                <tr>
                    <td scope="col">{{ $item->tahun_ajaran }}</td>
                    <td scope="col">{{ $item->semester ? $item->semester->nama : '-' }}</td>
                    <td scope="col">
                        {!! $item->status == 'aktif' ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Non-Aktif</span>' !!}
                        @if($item->status != 'aktif')
                        <x-button text="Aktifkan" class="btn-warning"
                            modalTarget="#modal-status-{{ $item->id }}" />
                        @endif
                    </td>
                    <td scope="col">
                        <x-button.button-link text="Edit" class="btn-info"
                            link="{{ route('tahun_ajaran.edit', $item->id) }}" />
                        
                        <x-button text="Delete" class="btn-danger" modalTarget="#modal-delete-{{ $item->id }}" />
                    </td>
                </tr>
                @endforeach
                @else
                <x-table.tr.empty-row colCount="4" />
                @endif
            </x-slot>
        </x-table>
        <div class="d-flex flex-row justify-content-center mt-3">
            {{ $tahunAjaranList->links() }}
        </div>
    </x-cards.regular-card>
</section>
@endsection

@foreach ($tahunAjaranList as $item)
<x-modal.modal-status-tahun modalId="modal-status-{{ $item->id }}"
    formLink="{{ route('tahun_ajaran.update_status', ['id' => $item->id]) }}" />

<x-modal.modal-delete modalId="modal-delete-{{ $item->id }}" title="Delete Tahun Ajaran"
    formLink="{{ route('tahun_ajaran.destroy', ['id' => $item->id]) }}" />
@endforeach