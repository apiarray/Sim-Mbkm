@extends('layouts.backend.master')
@section('title', 'Pengguna - Dosen')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<section class="mt-5">
    <x-cards.regular-card heading="Data Pengguna - Dosen">
        <x-button.button-link text="New Dosen" class="btn-success mb-4" link="{{ route('pengguna.dosen.create') }}" />
        <x-table>
            <x-slot name="header">
                <tr>
                    <th scope="row">NIP</th>
                    <th scope="row">Nama Dosen</th>
                    <th scope="row">E-mail</th>
                    <th scope="row">Fakultas</th>
                    <th scope="row">Action</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @if ($dataDosenList->total())
                    @foreach ($dataDosenList as $item)
                    <tr>
                        <td scope="col">{{ $item->nip }}</td>
                        <td scope="col">{{ $item->nama }}</td>
                        <td scope="col">{{ $item->email }}</td>
                        <td scope="col">{{ $item->fakultas->nama ?? '' }}</td>
                        <td scope="col">
                            <x-button.button-link text="Detail" class="btn-success"
                                link="{{ route('pengguna.dosen.show', $item->id) }}" />
                            <x-button.button-link text="Edit" class="btn-info"
                                link="{{ route('pengguna.dosen.edit', $item->id) }}" />
                            @if((auth()->guard('dosen')->user()->id ?? NULL) != $item->id)
                            <x-button text="Delete" class="btn-danger" modalTarget="#modal-delete-{{ $item->id }}" />
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <x-table.tr.empty-row colCount="5" />
                @endif
            </x-slot>
        </x-table>
        <div class="d-flex flex-row justify-content-center mt-3">
            {{ $dataDosenList->links() }}
        </div>
    </x-cards.regular-card>
</section>
@endsection

@foreach ($dataDosenList as $item)
<x-modal.modal-delete modalId="modal-delete-{{ $item->id }}" title="Delete Dosen"
    formLink="{{ route('pengguna.dosen.destroy', ['id' => $item->id]) }}" />
@endforeach