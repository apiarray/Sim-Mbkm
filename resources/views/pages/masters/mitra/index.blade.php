@extends('layouts.backend.master')
@section('title', 'Data Mitra')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<section class="mt-5">
    <x-cards.regular-card heading="Data Mitra">
        <x-button.button-link text="New Item" class="btn-success mb-4" link="{{ route('mitra.create') }}" />
        <x-table>
            <x-slot name="header">
                <tr>
                    <th scope="row">Nama</th>
                    <th scope="row">Action</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @if ($mitraList->total())
                    @foreach ($mitraList as $item)
                    <tr>
                        <td scope="col">{{ $item->nama }}</td>
                        <td scope="col">
                            <x-button.button-link text="Edit" class="btn-info"
                                link="{{ route('mitra.edit', $item->id) }}" />
                            <x-button text="Delete" class="btn-danger" modalTarget="#modal-delete-{{ $item->id }}" />
                        </td>
                    </tr>
                    @endforeach
                @else
                    <x-table.tr.empty-row colCount="2" />
                @endif
            </x-slot>
        </x-table>
        <div class="d-flex flex-row justify-content-center mt-3">
            {{ $mitraList->links() }}
        </div>
    </x-cards.regular-card>
</section>
@endsection

@foreach ($mitraList as $item)
<x-modal.modal-delete modalId="modal-delete-{{ $item->id }}" title="Delete Mitra"
    formLink="{{ route('mitra.destroy', ['id' => $item->id]) }}" />
@endforeach