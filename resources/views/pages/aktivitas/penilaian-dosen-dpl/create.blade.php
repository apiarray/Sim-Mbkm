@extends('layouts.backend.master')
@section('title', 'Add Penilaian Dosen')
@section('content')

    @if (session()->get('message'))
        <x-alert title="Success" message="{{ session()->get('message') }}" />
    @endif

    @if (session()->get('error'))
        <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
    @endif

    <x-cards.regular-card heading="Add Penilaian Dosen">
        <form action="{{ route('aktivitas.penilaian_dosen_dpl.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="id_validasi_registrasi">ID Registrasi Validasi</label>
                <select class="form-control" name="registrasi_mbkm_id" id="id_validasi_registrasi" onchange="getIdRegistrasiData(this); getLogbookMingguan(this); getLaporanAkhirMahasiswa(this)">
                    <option value="">Pilih ID Registrasi Validasi</option>
                    @foreach ($listRegistrasiMbkm as $reg)
                        <option value="{{ $reg->id }}" {{ (old('registrasi_mbkm_id') ?? null) == $reg->id ? 'selected' : '' }}>
                            {{ $reg->id_registrasi . ' ' . (($reg->mahasiswa->nama ?? '') != '' ? '(' . $reg->mahasiswa->nama . ')' : '') }}
                        </option>
                    @endforeach
                </select>
                @error('registrasi_mbkm_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <table class="table w-100 mb-3">
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
                <br>
                <h6>Daftar Logbook Mingguan</h6>
                <div id="div_logbook_mingguan" class="flex-grow-1 mr-3"></div>
                <br>
                <h6>Laporan Akhir Mahasiswa</h6>
                <div id="div_laporan_akhir" class="flex-grow-1 mr-3"></div>
            </div>

            <div class="d-flex flex-row">
                <a href="" class="btn btn-info mb-3 d-none">Lembar Penilaian</a>
            </div>
            <div class="d-flex flex-row">
                <x-button text="Submit" class="btn-success mr-3" type="submit" id="btn-submit" />
                <x-button.button-link text="Back" class="btn-danger" link="{{ route('aktivitas.penilaian_dosen_dpl.index') }}" />
            </div>
        </form>
    </x-cards.regular-card>
@endsection

@section('js')
    <script>
        function getIdRegistrasiData(e) {
            let id = $(e).val()
            console.log(id);

            if (id) {
                // ajax
                console.log('registrasi data...');
                $.ajax({
                    url: "{{ url('dashboard/aktivitas/registrasi-mbkm/detail') }}/" + id,
                    // accepts: 'application/json',
                    success: function(resp) {
                        console.log(resp);
                        if (resp.isOk) {
                            console.log('success get data... registrasi data');
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

        function getLogbookMingguan(e) {
            let id = $(e).val()
            console.log('logbook mingguan', id);

            if (id) {
                // ajax
                console.log('get data...');
                $('#btn-submit').removeAttr('disabled')
                $.ajax({
                    url: "{{ url('dashboard/aktivitas/logbook/mingguan/list-all') }}",
                    // accepts: 'application/json',
                    type: 'GET',
                    data: {
                        registrasi_mbkm_id: id
                    },
                    success: function(resp) {
                        console.log(resp);
                        console.log('success get data... logbook mingguan');
                        let htmlTable = ''
                        if (resp && resp.length > 0) {
                            htmlTable += '<table class="table w-100 mb-3"><tr><th>Item Penilaian</th><th>Status</th><th>Action</th></tr>';
                            for (var i in resp) {
                                console.log(resp[i]);

                                htmlTable += '<tr>'
                                htmlTable += `<td>${resp[i].judul}</td>`
                                if (resp[i].status == 'tervalidasi') {
                                    htmlTable += `<td><span class="badge badge-success">${resp[i].status}</span></td>`
                                } else {
                                    htmlTable += `<td><span class="badge badge-warning">${resp[i].status}</span></td>`
                                }
                                htmlTable += `<td><a href="{{ url('dashboard/aktivitas/logbook/mingguan/detail') }}/${resp[i].id}" target="_BLANK" class="btn btn-info">Lihat</a></td>`
                                htmlTable += '</tr>'
                            }
                            htmlTable += '</table>'
                        } else {
                            $('#btn-submit').attr('disabled', 'disabled')
                        }
                        $('#div_logbook_mingguan').html(htmlTable)
                    }
                })
            } else {
                $('#div_logbook_mingguan').html('')
            }
        }

        function getLaporanAkhirMahasiswa(e) {
            let id = $(e).val()
            console.log('laporan akhir', id);

            if (id) {
                // ajax
                console.log('get data...');
                $('#btn-submit').removeAttr('disabled')
                $.ajax({
                    url: "{{ url('dashboard/aktivitas/laporan-akhir/mahasiswa/get-by-registrasi-id') }}/" + id,
                    // accepts: 'application/json',
                    // data: function(d){
                    //     d.registrasi_mbkm_id = id
                    // },
                    success: function(resp) {
                        console.log('success get data... laporan akhir');
                        console.log(resp);

                        let htmlTable = ''

                        if (resp) {
                            htmlTable = '<table class="table w-100 mb-3"><tr><th>Item Penilaian</th><th>Status</th><th>Action</th></tr>';
                            htmlTable += '<tr>'
                            htmlTable += `<td>${resp.judul_materi}</td>`
                            if (resp.status_laporan_akhir == 'validasi') {
                                htmlTable += `<td><span class="badge badge-success">${resp.status_laporan_akhir}</span></td>`
                            } else {
                                htmlTable += `<td><span class="badge badge-warning">${resp.status_laporan_akhir}</span></td>`
                            }
                            htmlTable += `<td><a href="{{ url('dashboard/aktivitas/laporan-akhir/mahasiswa/detail') }}/${resp.id}" target="_BLANK" class="btn btn-info">Lihat</a></td>`
                            htmlTable += '</tr>'
                            htmlTable += '</table>'
                        } else {
                            $('#btn-submit').attr('disabled', 'disabled')
                        }
                        $('#div_laporan_akhir').html(htmlTable)
                    }
                })
            } else {
                $('#div_laporan_akhir').html('')
            }
        }
    </script>
    @if (old('registrasi_mbkm_id'))
        <script>
            $.ajax({
                url: "{{ url('dashboard/aktivitas/registrasi-mbkm/detail') . '/' . old('registrasi_mbkm_id') }}",
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

            $.ajax({
                url: "{{ url('dashboard/aktivitas/logbook/mingguan/list-all') }}",
                // accepts: 'application/json',
                data: {
                    registrasi_mbkm_id: "{{ old('registrasi_mbkm_id') }}"
                },
                success: function(resp) {
                    console.log(resp);
                    console.log('success get data... logbook mingguan');
                    let htmlTable = ''
                    if (resp && resp.length > 0) {
                        htmlTable += '<table class="table w-100 mb-3"><tr><th>Item Penilaian</th><th>Status</th><th>Action</th></tr>';
                        for (var i in resp) {
                            console.log(resp[i]);

                            htmlTable += '<tr>'
                            htmlTable += `<td>${resp[i].judul}</td>`
                            if (resp[i].status == 'tervalidasi') {
                                htmlTable += `<td><span class="badge badge-success">${resp[i].status}</span></td>`
                            } else {
                                htmlTable += `<td><span class="badge badge-warning">${resp[i].status}</span></td>`
                            }
                            htmlTable += `<td><a href="{{ url('dashboard/aktivitas/logbook/mingguan/detail') }}/${resp[i].id}" target="_BLANK" class="btn btn-info">Lihat</a></td>`
                            htmlTable += '</tr>'
                        }
                        htmlTable += '</table>'
                    }
                    $('#div_logbook_mingguan').html(htmlTable)
                }
            })

            $.ajax({
                url: "{{ url('dashboard/aktivitas/laporan-akhir/mahasiswa/get-by-registrasi-id') . '/' . old('registrasi_mbkm_id') }}",
                // accepts: 'application/json',
                // data: function(d){
                //     d.registrasi_mbkm_id = id
                // },
                success: function(resp) {
                    console.log('success get data... laporan akhir');
                    console.log(resp);

                    let htmlTable = ''

                    if (resp) {
                        htmlTable = '<table class="table w-100 mb-3"><tr><th>Item Penilaian</th><th>Status</th><th>Action</th></tr>';
                        htmlTable += '<tr>'
                        htmlTable += `<td>${resp.judul_materi}</td>`
                        if (resp.status_laporan_akhir == 'validasi') {
                            htmlTable += `<td><span class="badge badge-success">${resp.status_laporan_akhir}</span></td>`
                        } else {
                            htmlTable += `<td><span class="badge badge-warning">${resp.status_laporan_akhir}</span></td>`
                        }
                        htmlTable += `<td><a href="{{ url('dashboard/aktivitas/laporan-akhir/mahasiswa/detail') }}/${resp.id}" target="_BLANK" class="btn btn-info">Lihat</a></td>`
                        htmlTable += '</tr>'
                        htmlTable += '</table>'
                    }
                    $('#div_laporan_akhir').html(htmlTable)
                }
            })
        </script>
    @endif
@endsection
