@extends('layouts.backend.master')
@section('title', 'Pengisian Penilaian Dosen')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<x-cards.regular-card heading="Pengisian Penilaian Dosen">
    <form action="{{ route('aktivitas.penilaian_dosen_dpl.store_penilaian', ['id' => $dataPenilaianDosen->id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf
        @method('POST')
        @if($dataPenilaianDosen->status == 'tervalidasi')
        <div class="row mb-5">
            <div class="col">
                <h3>Hasil Penilaian</h3>
                <ol type="A">
                    @foreach($dataSoal as $bab)
                        @php
                            $sum = 0;
                        @endphp
                        @foreach($dataJawaban as $j)
                            @php
                            if($j->penilaian->bab_penilaian->id == $bab->id){
                                $sum += ($j->bobot * $j->penilaian->bab_penilaian->bobot);
                            }
                            @endphp
                        @endforeach
                        <h6><li>{{ $bab->nama_bab }} : {{ $sum }}</li></h6>
                    @endforeach
                </ol>
                <h5>Total Nilai : {{ $dataPenilaianDosen->nilai }}</h5>
                <h5>Nilai Konversi : {{ ($dataPenilaianDosen->nilai / 23.8)*100 }}</h5>
            </div>
        </div>
        <hr>
        @endif
        <div class="row mb-3">
            <div class="col">
                <label for="tanggal_penilaian">Tanggal Penilaian</label>
                <input type="date" class="form-control" name="tanggal_penilaian" id="tanggal_penilaian" value="{{ old('tanggal_penilaian') ?? $dataPenilaianDosen->tanggal_penilaian ?? NULL }}" required {{ $dataPenilaianDosen->status == 'tervalidasi' ? 'disabled' : '' }}>
                @error('tanggal_penilaian')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="row">
            <ol type="A">
                @php
                    $counter = 0;
                @endphp
                @foreach($dataSoal as $bab)
                <h4 class="mt-3"><li>{{$bab->nama_bab}}</li></h4>
                <ol>
                    @foreach($bab->penilaian as $soal)
                    <h6><li>{{$soal->soal_penilaian}}</li></h6>
                        @foreach($soal->pilihan_penilaian as $idx => $pilihan)
                        <div class="form-check">
                            <input type="radio" class="form-check-input" 
                                    name="jawaban[{{$soal->id}}]" id="jawaban-{{$counter}}" 
                                    value="{{$pilihan->id}}" {{ $idx == 0 ? 'required' : '' }}
                                    {{ $dataJawaban->where('pilihan_penilaian_id', $pilihan->id)->first() ? 'checked' : '' }}
                                    {{ $dataPenilaianDosen->status == 'tervalidasi' ? 'disabled' : '' }}
                            >
                            @if($dataPenilaianDosen->status == 'tervalidasi' && $dataJawaban->where('pilihan_penilaian_id', $pilihan->id)->first())
                            <b>
                            @endif
                            <label for="jawaban-{{$counter}}" class="form-check-label">{{ $pilihan->isi_pilihan }}</label>
                            @if($dataPenilaianDosen->status == 'tervalidasi' && $dataJawaban->where('pilihan_penilaian_id', $pilihan->id)->first())
                            </b>
                            @endif
                        </div>
                        @php
                            $counter++;
                        @endphp
                        @endforeach
                    @endforeach
                </ol>
                @endforeach
            </ol>
        </div>
        <div class="row">
            @if($dataPenilaianDosen->status != 'tervalidasi')
            <x-button text="Submit" class="btn-success mr-3" type="submit" id="btn-submit" />
            @endif
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('aktivitas.penilaian_dosen_dpl.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection

@section('js')
<script>

</script>
@endsection