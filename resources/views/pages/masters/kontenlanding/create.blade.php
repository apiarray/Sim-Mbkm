@extends('layouts.backend.master')
@section('title', 'New Konten - Landing')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif
<script src="{{url("bl/assets/vendor/php-email-form/validate.js")}}"></script>

<script src="{{url('ckeditor/ckeditor.js')}}"></script>   
<script>
   var konten = document.getElementById("konten");
     CKEDITOR.replace(konten,{
     language:'en-gb'
   });
   CKEDITOR.config.allowedContent = true;
</script>
<x-cards.regular-card heading="Insert New Konten.">
    <form action="{{ route('Konten.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="d-flex flex-row">
        	<div class="form-group flex-grow-1 mr-3">
          	<!--x-inputs.selector class="flex-grow-1 mr-3" :data="$jenisList" name="jenis" label="Jenis Konten" /-->
             <label for="jenis">Jenis Konten</label>
             <select class="form-control" name="jenis" id="jenis">  
            		<option value="">Pilih jenis konten</option>      
					<option value="banner" >Banner</option>       
                    <option value="sambutan">Sambutan</option>
                    <option value="pengumuman" >Pengumuman</option>
              		<option value="download" >Download</option>
                    <option value="pendaftaran" >Pendaftaran</option>
                    <option value="info" >Info</option>
                    <option value="dosen" >Dosen</option>
					
            </select>
            </div>
        </div>
        <div class="d-flex flex-row">
        	<x-inputs.textfield class="flex-grow-1 mr-3" label="Judul" name="judul" placeholder="Judul" />
        </div>
        <div class="d-flex flex-row">
			<!--x-inputs.textfield class="flex-grow-1 mr-3" label="ISI" name="isi" placeholder="isi" /-->
            <div class="form-group flex-grow-1 mr-3"><label for="jenis">Konten</label>
            <textarea id="isi" class="ckeditor form-control" name="isi" rows="10" cols="50"></textarea> </div>
        </div>
        <!-- START SECTION ALAMAT -->
        <!--div class="d-flex flex-row">
            <x-inputs.textfield class="flex-grow-1 mr-3" label="jenis" name="jenis" placeholder="Masukkan Alamat" />
        </div-->
        <div class="d-flex flex-row">
            <!--x-inputs.textfield class="flex-grow-1 mr-3" label="tanggal" name="tanggal" placeholder="tanggal" /-->
            <div class="form-group flex-grow-1 mr-3">
           		 <label for="jenis">Tanggal</label>
           		 <input class="form-control" type="date" id="tanggal" name="tanggal">
            </div>
            <!--x-inputs.textfield class="flex-grow-1 mr-3" label="aktif" name="aktif" placeholder="aktif" /-->
            <div class="form-group flex-grow-1 mr-3">
          	<!--x-inputs.selector class="flex-grow-1 mr-3" :data="$jenisList" name="jenis" label="Jenis Konten" /-->
             <label for="aktif">Aktif</label>
             <select class="form-control" name="aktif" id="aktif">  
            		<option value="0">Tidak Aktif</option>             
                    <option value="1">Aktif</option>
                   
            </select>
            </div>
			
        </div>
        <div class="d-flex flex-row">
            <div class="form-group flex-grow-1 mr-3">
           		 <label for="jenis">Image</label>
           		 <input type="file" class="form-control" id="gambar_upload" name="gambar_upload">
            </div>
        </div>
       
       
        <div class="d-flex flex-row">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('Konten.index') }}" />
        </div>
         <input class="form-control" type="hidden" id="gambar" name="gambar" value=1>
         
    </form>
</x-cards.regular-card>
@endsection