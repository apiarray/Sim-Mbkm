@extends('layouts.backend.master')
@section('title', 'Update Pilohan Penilaian')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<x-cards.regular-card heading="Detail Penilaian">
    <x-table>
        <x-slot name="body">
            <tr>
                <th scope="row">Soal Penilaian</th>
                <th>: {{$penilaian->soal_penilaian}}</th>
            </tr>
        </x-slot>
    </x-table>
</x-cards.regular-card>
<x-cards.regular-card heading="Insert New Pilihan Penilaian">
    <form action="{{ route('penilaian.pilihan_penilaian.update', ['id'=> $penilaian->id, 'id_pilihan' => $pilihanPenilaian->id]) }}" method="post" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" name="penilaian_id" value="{{ $penilaian->id }}" type="hidden"/>
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Teks Pilihan" name="isi_pilihan" placeholder="Teks Pilihan" value="{{ $pilihanPenilaian->isi_pilihan }}"/>
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Bobot" type="number" name="bobot" min="1" max="10" step="1" placeholder="Bobot" value="{{ $pilihanPenilaian->bobot }}">
                <span class="small mt-2">Antara 1 s/d 10</span>
            </x-inputs.textfield>
        </div>
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('penilaian.show', ['id'=> $penilaian->id]) }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection