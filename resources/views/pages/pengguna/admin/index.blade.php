@extends('layouts.backend.master')
@section('title', 'Pengguna - Admin')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<section class="mt-5">
    <x-cards.regular-card heading="Data Pengguna - Admin">
        <x-button.button-link text="New Admin" class="btn-success mb-4" link="{{ route('pengguna.admin.create') }}" />
        <x-table>
            <x-slot name="header">
                <tr>
                    <th scope="row">Nama</th>
                    <th scope="row">Email</th>
                    <th scope="row">Action</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @if ($dataAdminList->total())
                    @foreach ($dataAdminList as $item)
                    <tr>
                        <td scope="col">{{ $item->name }}</td>
                        <td scope="col">{{ $item->email }}</td>
                        <td scope="col">
                            <x-button.button-link text="Edit" class="btn-info"
                                link="{{ route('pengguna.admin.edit', $item->id) }}" />
                            @if(auth()->user()->id != $item->id)
                            <x-button text="Delete" class="btn-danger" modalTarget="#modal-delete-{{ $item->id }}" />
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <x-table.tr.empty-row colCount="2" />
                @endif
            </x-slot>
        </x-table>
        <div class="d-flex flex-row justify-content-center mt-3">
            {{ $dataAdminList->links() }}
        </div>
    </x-cards.regular-card>
</section>
@endsection

@foreach ($dataAdminList as $item)
<x-modal.modal-delete modalId="modal-delete-{{ $item->id }}" title="Delete Admin"
    formLink="{{ route('pengguna.admin.destroy', ['id' => $item->id]) }}" />
@endforeach