@extends('layouts.backend.master')
@section('title', 'New Pengguna - Admin')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<x-cards.regular-card heading="Insert New Admin">
    <form action="{{ route('pengguna.admin.store') }}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nama" name="name" placeholder="Nama" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="E-mail" name="email" placeholder="E-mail" >
            </x-inputs.textfield>
        </div>
        <div class="d-flex flex-row">
            <span>* Password untuk akun baru menggunakan alamat email yang diinput</span>
        </div>
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('pengguna.admin.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection