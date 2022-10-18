@extends('layouts.backend.master')
@section('title', 'Update Item')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<x-cards.regular-card heading="Update Data">
    <form action="{{ route('pengguna.admin.update', ['id' => $adminData->id]) }}" method="post" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="Nama Bab Penilaian" name="name" placeholder="Nama Bab Penilaian" value="{{ $adminData->name }}" />
        </div>
        <div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="E-mail" name="email" placeholder="E-mail" value="{{ $adminData->email }}" />
        </div>
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('pengguna.admin.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection