@extends('layouts.backend.master')
@section('title', 'Data Semester')
@section('content')
<section class="mt-5">
    <x-cards.regular-card heading="Data Semester">
        <x-button.button-link text="New Item" class="btn-success mb-4" link="{{ route('semester.create') }}" />
        <x-table>
            <x-slot name="header">
                <tr>
                    <th scope="row">Nama Semester</th>
                    <th scope="row">Action</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @if ($semesterList->total())
                    @foreach ($semesterList as $item)
                    <tr>
                        <td scope="col">{{ $item->nama }}</td>
                        <td scope="col">
                            <x-button.button-link text="Edit" class="btn-info"
                                link="{{ route('semester.edit', $item->id) }}" />
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
            {{ $semesterList->links() }}
        </div>
    </x-cards.regular-card>
</section>
@endsection

@foreach ($semesterList as $item)
<x-modal.modal-delete modalId="modal-delete-{{ $item->id }}" title="Delete Semester"
    formLink="{{ route('semester.destroy', ['id' => $item->id]) }}" />
@endforeach