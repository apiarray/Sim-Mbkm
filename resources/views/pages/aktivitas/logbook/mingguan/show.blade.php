@extends('layouts.backend.master')
@section('title', 'Detail Logbook Mingguan')
@section('content')

    @if (session()->get('message'))
        <x-alert title="Success" message="{{ session()->get('message') }}" />
    @endif

    @if (session()->get('error'))
        <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
    @endif

    <x-cards.regular-card heading="Detail Logbook Mingguan">
        <div class="d-flex flex-row">
            <div class="flex-grow-1 mr-3 mb-3">
                <h6>Judul</h6>
                {{ $dataLogbookMingguan->judul ?? null }}
            </div>
        </div>
        <div class="d-flex flex-row">
            <div class="flex-grow-1 mr-3 mb-3">
                <h6>Deskripsi</h6>
                {{ $dataLogbookMingguan->deskripsi ?? null }}
            </div>
        </div>
        <div class="d-flex flex-row">
            <div class="flex-grow-1 mr-3 mb-3">
                <h6>Minggu Ke {{ $dataLogbookMingguan->minggu ?? null }}</h6>
            </div>
        </div>
        <div class="d-flex flex-row">
            <div class="flex-grow-1 mr-3 mb-3">
                <h6>Data Mahasiswa</h6>
            </div>
        </div>
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
        <hr>
        <div class="d-flex flex-row mb-5">
            <div class="flex-grow-1 mr-3 mb-3">
                <div>
                    <h6>Dokumen ter-upload</h6>
                    @if ($dataLogbookMingguan->link_dokumen)
                        <a href="{{ url('storage/' . $dataLogbookMingguan->link_dokumen) }}" target="_blank" class="btn btn-success">Lihat</a>
                    @else
                        Tidak ada dokumen ter-upload
                    @endif
                </div>
            </div>
            <div class="flex-grow-1 mr-3 mb-3">
            </div>
            <div class="flex-grow-1 mr-3 mb-3">
            </div>
        </div>
        <div class="d-flex flex-row">
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('aktivitas.logbook.mingguan.index') }}" />
        </div>
    </x-cards.regular-card>
@endsection

@section('js')
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
            url: "{{ url('dashboard/aktivitas/registrasi-mbkm/detail') . '/' . $dataLogbookMingguan->registrasi_mbkm_id }}",
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
