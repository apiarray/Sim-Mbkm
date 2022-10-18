@extends('layouts.backend.master')
@section('title', 'Detail Dosen')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<section class="mt-5">
    <x-cards.regular-card heading="Detail Dosen">
        <x-table>
            <x-slot name="body">
                <tr>
                    <th scope="row">NIP</th>
                    <th>: {{ $dataDosen->nip }}</th>
                </tr>
                <tr>
                    <th scope="row">Nama</th>
                    <th>: {{ $dataDosen->nama }}</th>
                </tr>
                <tr>
                    <th scope="row">Email</th>
                    <th>: {{ $dataDosen->email }}</th>
                </tr>
                <tr>
                    <th scope="row">Fakultas</th>
                    <th>: {{ $dataDosen->fakultas->nama ?? '' }}</th>
                </tr>
            </x-slot>
        </x-table>
        <div class="d-flex flex-row mt-3">
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('pengguna.dosen.index') }}" />
        </div>
    </x-cards.regular-card>
</section>

@endsection