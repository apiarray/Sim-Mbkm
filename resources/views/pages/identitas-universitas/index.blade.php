@extends('layouts.backend.master')
@section('title', 'Data Identitas Universitas')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<section class="mt-5">
    <x-cards.regular-card heading="Data Identitas Universitas">
        <x-button.button-link text="New Item" class="btn-success mb-4" link="{{ route('identitas_universitas.create') }}" />
        <x-table>
            <x-slot name="header">
                <tr>
                    <th scope="row">Property</th>
                    <th scope="row">Value</th>
                    <th scope="row">Action</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @if ($identitas->total() > 0)
                    @foreach ($identitas as $item)
                    <tr>
                        <td scope="col">{{ $item->property }}</td>
                        <td scope="col">{{ $item->value }}</td>
                        <td scope="col">
                            <x-button.button-link text="Edit" class="btn-info"
                                link="{{ route('identitas_universitas.edit', $item->id) }}" />
                            <x-button text="Delete" class="btn-danger" modalTarget="#modal-delete-{{ $item->id }}" />
                        </td>
                    </tr>
                    @endforeach
                @else
                    <x-table.tr.empty-row/>
                @endif
            </x-slot>
        </x-table>
        <div class="d-flex flex-row justify-content-center mt-3">
            {{ $identitas->links() }}
        </div>
    </x-cards.regular-card>
</section>
@endsection

@foreach ($identitas as $item)
    <x-modal.modal-delete modalId="modal-delete-{{ $item->id }}" title="Delete Identitas Universitas"
        formLink="{{ route('identitas_universitas.destroy', ['id' => $item->id]) }}" />
@endforeach