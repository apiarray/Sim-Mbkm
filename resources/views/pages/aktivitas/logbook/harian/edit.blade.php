@extends('layouts.backend.master')
@section('title', 'Edit Logbook Harian')
@section('content')

    @if (session()->get('message'))
        <x-alert title="Success" message="{{ session()->get('message') }}" />
    @endif

    @if (session()->get('error'))
        <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
    @endif

    <x-cards.regular-card heading="Edit Logbook Harian">
        <form action="{{ route('aktivitas.logbook.harian.update', ['id' => $dataLogbookHarian->id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (Auth::guard('admin')->check())
                <div class="mb-3">
                    <label for="id_validasi_registrasi">ID Registrasi Validasi</label>
                    <select class="form-control" name="registrasi_mbkm_id" id="id_validasi_registrasi" onchange="getIdRegistrasiData(this)">
                        <option value="">Pilih ID Registrasi Validasi</option>
                        @foreach ($listRegistrasiMbkm as $reg)
                            <option value="{{ $reg->id }}" {{ (old('registrasi_mbkm_id') ?? ($dataLogbookMingguan->registrasi_mbkm_id ?? null)) == $reg->id ? 'selected' : '' }}>
                                {{ $reg->id_registrasi . ' ' . (($reg->mahasiswa->nama ?? '') != '' ? '(' . $reg->mahasiswa->nama . ')' : '') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @elseif(Auth::guard('mahasiswa')->check())
                @php
                    $dataRegistrasi = $listRegistrasiMbkm->where('mahasiswa_id', '=', Auth::guard('mahasiswa')->user()->id);
                    $percobaan = 0;
                @endphp
                @if ($listRegistrasiMbkm->isNotEmpty())
                    @foreach ($dataRegistrasi as $key => $registrasi)
                        @if ($percobaan == 0)
                            @php $percobaan++ @endphp
                            <input type="hidden" id="id_validasi_registrasi" name="registrasi_mbkm_id" value="{{ $registrasi->id }}">
                        @else
                            @php break @endphp
                        @endif
                    @endforeach
                @endif
            @endif
            <div class="mb-3">
                <table class="table w-100">
                    <tr>
                        <th>Nama</th>
                        <td>: <span id="nama_mahasiswa"></span></td>
                        <td></td>
                        <th>Dosen</th>
                        <td>: <span id="nama_dosen"></span></td>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td>: <span id="nim_mahasiswa"></span></td>
                        <td></td>
                        <th>Kelas</th>
                        <td>: <span id="kelas_mahasiswa"></span></td>
                    </tr>
                    <tr>
                        <th>Program</th>
                        <td>: <span id="nama_program"></span></td>
                        <td></td>
                        <th>Jurusan</th>
                        <td>: <span id="nama_jurusan"></span></td>
                    </tr>
                    <tr>
                        <th>Tahun Ajaran</th>
                        <td>: <span id="tahun_ajaran"></span></td>
                        <td></td>
                        <th>Fakultas</th>
                        <td>: <span id="nama_fakultas"></span></td>
                    </tr>
                </table>
            </div>
            <div class="d-flex flex-row">
                <x-inputs.textfield class="flex-grow-1 mr-3" label="Upload PDF" name="link_dokumen" type="file">
                    @if ($dataLogbookHarian->link_dokumen)
                        <div>
                            <h6>Dokumen ter-upload</h6>
                            <a href="{{ url('storage/' . $dataLogbookHarian->link_dokumen) }}" target="_blank" class="btn btn-success">Lihat</a>
                        </div>
                    @endif
                </x-inputs.textfield>
                {{-- <x-inputs.textfield class="flex-grow-1 mr-3" label="Upload Foto/Gambar" name="link_video" type="file">
                </x-inputs.textfield> --}}
            </div>
            <div class="d-flex flex-row">
            </div>
            <div class="d-flex flex-row">
                <x-inputs.textfield class="flex-grow-1 mr-3" label="Judul" name="judul" isRequired="true" value="{{ old('judul') ?? ($dataLogbookHarian->judul ?? null) }}" />
            </div>
            <div class="d-flex flex-row">
                <x-inputs.textfield class="flex-grow-1 mr-3" label="Deskripsi" name="deskripsi" value="{{ old('deskripsi') ?? ($dataLogbookHarian->deskripsi ?? null) }}" />
            </div>
            <div class="d-flex flex-row">
                <!-- <x-inputs.textfield class="flex-grow-1 mr-3" label="Tanggal" name="" /> -->
                <div class="flex-grow-1 mr-3 mb-3">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="{{ old('tanggal') ?? (($dataLogbookHarian->tanggal ? \Carbon\Carbon::parse($dataLogbookHarian->tanggal)->format('Y-m-d') : null) ?? null) }}">
                    @error('tanggal')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="d-flex flex-row">
                <x-button text="Submit" class="btn-success mr-3" type="submit" />
                <x-button.button-link text="Back" class="btn-danger" link="{{ route('aktivitas.logbook.harian.index') }}" />
            </div>
        </form>
    </x-cards.regular-card>
@endsection

@section('js')
    @if (Auth::guard('mahasiswa')->check())
        <script>
            $(document).ready(function() {
                getIdRegistrasiData($('#id_validasi_registrasi'))
            })
        </script>
    @endif
    <script>
        function getIdRegistrasiData(e) {
            let id = $(e).val()
            console.log(id);

            if (id) {
                // ajax
                console.log('get data...');
                $.ajax({
                    url: "{{ url('dashboard/aktivitas/registrasi-mbkm/detail') }}/" + id,
                    // accepts: 'application/json',
                    success: function(resp) {
                        console.log(resp);
                        if (resp.isOk) {
                            console.log('success get data...');
                            $('#nama_mahasiswa').html(resp.data.mahasiswa.nama)
                            $('#nim_mahasiswa').html(resp.data.mahasiswa.nim)
                            $('#nama_dosen').html(resp.data.dosen_dpl.nama)
                            $('#kelas_mahasiswa').html(resp.data.kelas.nama)
                            $('#nama_jurusan').html(resp.data.kelas.jurusan.nama)
                            $('#nama_fakultas').html(resp.data.kelas.jurusan.fakultas.nama)
                            $('#tahun_ajaran').html(resp.data.tahun_ajaran.tahun_ajaran)
                            $('#nama_program').html(resp.data.program.nama)
                        }
                    }
                })
            } else {
                $('#nama_mahasiswa').html('')
                $('#nim_mahasiswa').html('')
                $('#nama_dosen').html('')
                $('#kelas_mahasiswa').html('')
                $('#nama_jurusan').html('')
                $('#nama_fakultas').html('')
                $('#tahun_ajaran').html('')
                $('#nama_program').html('')
            }
        }

        $.ajax({
            url: "{{ url('dashboard/aktivitas/registrasi-mbkm/detail') . '/' . $dataLogbookHarian->registrasi_mbkm_id }}",
            // accepts: 'application/json',
            success: function(resp) {
                console.log(resp);
                if (resp.isOk) {
                    console.log('success get data...');
                    $('#nama_mahasiswa').html(resp.data.mahasiswa.nama)
                    $('#nim_mahasiswa').html(resp.data.mahasiswa.nim)
                    $('#nama_dosen').html(resp.data.dosen_dpl.nama)
                    $('#kelas_mahasiswa').html(resp.data.kelas.nama)
                    $('#nama_jurusan').html(resp.data.kelas.jurusan.nama)
                    $('#nama_fakultas').html(resp.data.kelas.jurusan.fakultas.nama)
                    $('#tahun_ajaran').html(resp.data.tahun_ajaran.tahun_ajaran)
                    $('#nama_program').html(resp.data.program.nama)
                }
            }
        })
    </script>
@endsection
