@extends('layouts.backend.master')
@section('title', 'Data Kelas')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<section class="mt-5">
    <x-cards.regular-card heading="Data Kelas">
        <x-button.button-link text="New Item" class="btn-success mb-4" link="{{ route('kelas.create') }}" />
        <x-table>
            <x-slot name="header">
                <tr>
                    <th scope="row">Nama Kelas</th>
                    <th scope="row">Jurusan</th>
                    <th scope="row">Fakultas</th>
                    <th scope="row">Action</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @if ($kelasList->total() > 0)
                    @foreach ($kelasList as $item)
                    <tr>
                        <td scope="col">{{ $item->nama }}</td>
                        <td scope="col">{{ $item->jurusan ? $item->jurusan->nama : '-' }}</td>
                        <td scope="col">
                            {{ $item->jurusan->fakultas->jenjang ? $item->jurusan->fakultas->jenjang->kode : '' }}
                             - 
                            {{ $item->jurusan->fakultas ? $item->jurusan->fakultas->nama : '' }}
                        </td>
                        <td scope="col">
                            <x-button.button-link text="Edit" class="btn-info" link="{{ route('kelas.edit', $item->id) }}" />
                            <x-button text="Delete" class="btn-danger" modalTarget="#modal-delete-{{ $item->id }}" />
                        </td>
                    </tr>
                    @endforeach
                @else
                    <x-table.tr.empty-row colCount="5" />
                @endif
            </x-slot>
        </x-table>
        <div class="d-flex flex-row justify-content-center mt-3">
            {{ $kelasList->links() }}
        </div>
    </x-cards.regular-card>
</section>
@endsection

@foreach ($kelasList as $item)
<x-modal.modal-delete modalId="modal-delete-{{ $item->id }}" title="Delete Kelas"
    formLink="{{ route('kelas.destroy', ['id' => $item->id]) }}" />
@endforeach