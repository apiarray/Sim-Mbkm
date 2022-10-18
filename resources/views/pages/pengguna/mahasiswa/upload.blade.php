@extends('layouts.backend.master')
@section('title', 'Pengguna - Upload Mahasiswa')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

@if($errors->any())
    <x-alert type="danger" title="Error" message="
    {!! implode('', $errors->all('<div>:message</div>')) !!}"
    />
@endif

<section class="mt-5">
    <x-cards.regular-card heading="Data Pengguna - Upload Mahasiswa">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('pengguna.mahasiswa.upload') }}" method="post" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label>Upload Data Mahasiswa</label>
                        <input type="file" class="form-control" name="file" required="true">
                        @error('file')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-flex flex-row">
                        <x-button text="Submit" class="btn-success mr-3" type="submit" />
                        <x-button.button-link text="Back" class="btn-danger" link="{{ route('pengguna.mahasiswa.index') }}" />
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h6>Template upload mahasiswa</h6>
                <a href="{{ url('/document-template/template_upload_mahasiswa.xlsx') }}" class="btn btn-primary"><i data-feather="download"></i> Download</a>
            </div>
        </div>
    </x-cards.regular-card>
</section>

@endsection