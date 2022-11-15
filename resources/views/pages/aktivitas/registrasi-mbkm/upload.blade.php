@extends('layouts.backend.master')
@section('title', 'Form Upload')
@section('content')

@if (session()->get('message'))
<x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
<x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif


<x-cards.regular-card heading="Form Upload Berkas">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('aktivitas.registrasi_mbkm.store_upload_file')}}" method="post" autocomplete="off" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="form-group row">
            <div class="col">
                <label>Nama Mahasiswa</label>
                <input type="text" id="nama-mahasiswa" class="form-control" disabled placeholder="Nama Mahasiswa" value="{{ $dataRegistrasi->data->mahasiswa->nama }}">
                <input type="hidden" name="id_mahasiswa" class="form-control" placeholder="Nama Mahasiswa" value="{{ $dataRegistrasi->data->id }}">
            </div>
        </div>

        <div class="form-group row">
            <div class="col">
                <x-inputs.textfield class="flex-grow-1 mr-3" label="Surat Pernyataan" name="file_khs" type="file">
                    @if($dataRegistrasi->data->file_khs)
                    <div>
                        <h6>Dokumen ter-upload</h6>
                        <a href="{{ url('storage/' . $dataRegistrasi->data->file_khs) }}" target="_blank" class="btn btn-success">Lihat</a>
                    </div>
                    @endif
                </x-inputs.textfield>
            </div>
            <div class="col">
                <x-inputs.textfield class="flex-grow-1 mr-3" label="Surat Rekomendasi" name="file_krs" type="file">
                    @if($dataRegistrasi->data->file_krs)
                    <div>
                        <h6>Dokumen ter-upload</h6>
                        <a href="{{ url('storage/' . $dataRegistrasi->data->file_krs) }}" target="_blank" class="btn btn-success">Lihat</a>
                    </div>
                    @endif
                </x-inputs.textfield>
            </div>
        </div>

        <div class="form-group row ml-2">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('aktivitas.registrasi_mbkm.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection

@section('js')
<script>
    // function test(nama){
    //     var data = {
    //         nama : nama,
    //     }
    //     $.ajax({
    //         url: "{{ route('aktivitas.laporan_akhir.mahasiswa.create') }}",
    //         data : data,
    //         type: 'GET',
    //         dataType: 'json', // added data type
    //         success: function(res) {
    //             console.log(res);
    //         }
    //     });
    // }
</script>
@endsection