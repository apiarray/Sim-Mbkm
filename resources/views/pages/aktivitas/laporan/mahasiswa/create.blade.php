@extends('layouts.backend.master')
@section('title', 'New Laporan Akhir')
@section('content')

    @if (session()->get('message'))
        <x-alert title="Success" message="{{ session()->get('message') }}" />
    @endif

    @if (session()->get('error'))
        <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
    @endif


    <x-cards.regular-card heading="New Laporan Akhir">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('aktivitas.laporan_akhir.mahasiswa.store') }}" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @method('POST')
            @if (Auth::guard('admin')->check())
                <div class="form-group row">
                    <div class="col">
                        <label>Id Validasi Registrasi</label>
                        <select class="form-control" id="id-validasi-reg" name="id_validasi_reg" onchange="getLaporanAkhir()">

                            <option value='' disabled selected>Silakan pilih</option>
                            @foreach ($listRegistrasiMbkm as $item)
                                <option value="{{ $item->id }}">{{ $item->id_registrasi }}</option>
                            @endforeach

                        </select>
                    </div>
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
                            <input type="hidden" id="id-validasi-reg" name="id_validasi_reg" value="{{ $registrasi->id }}">
                        @else
                            @php break @endphp
                        @endif
                    @endforeach
                @endif
            @endif
            <div class="form-group row">
                <div class="col">
                    <label>Tahun Ajaran</label>
                    <input type="text" id="tahun-ajaran" class="form-control" disabled placeholder="Tahun Ajaran">
                </div>
                <div class="col">
                    <label>Jurusan</label>
                    <input type="text" id="jurusan" class="form-control" disabled name="Jurusan" placeholder="Jurusan">
                </div>

            </div>
            <div class="form-group row">
                <div class="col">
                    <label>NIM</label>
                    <input type="text" id="nim" class="form-control" name="nim" placeholder="NIM" disabled>
                </div>
                <div class="col">
                    <label>Semester</label>
                    <input type="text" id="semester" class="form-control" disabled name="semester" placeholder="Semester">
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <label>Nama Mahasiswa</label>
                    <input type="text" id="nama-mahasiswa" class="form-control" disabled name="nama_siswa" placeholder="Nama Mahasiswa">
                </div>
                <div class="col">
                    <label>Kelas</label>
                    <input type="text" id="kelas" class="form-control" disabled name="kelas" name="kelas" placeholder="Kelas">
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <label>Nama Dosen</label>
                    <input type="text" id="nama-dosen" class="form-control" disabled placeholder="Nama Dosen">
                </div>
                <div class="col">
                    <label>Program</label>
                    <input type="text" id="program" class="form-control" disabled name="program" placeholder="Program">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">Id Log Book Mingguan</div>
                <div class="col-sm-10">
                    <div class="form-check id-log-book-minguaan row">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label>Upload '</label>
                    <p style="color: red;">PDf Materi*</p>
                </div>
                <div class="col-sm-10">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="materi_pdf">
                            <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="form-group row">
                <div class="col-sm-2">
                    <label>Upload '</label>
                    <p style="color: red;">Video Materi*</p>
                </div>
                <div class="col-sm-10">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="link_video">
                            <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                        </div>

                    </div>
                </div>
            </div> --}}
            <div class="form-group row">
                <div class="col">
                    <label>Judul Materi</label>
                    <input type="text" class="form-control" name="judul_materi" placeholder="Judul Materi" value="{{ old('judul_materi') }}">
                </div>
                <div class="col">
                    <div class="custom-file">
                        <label>Link URL Shortener youtube</label>
                        <input type="text" class="form-control" name="link_youtube" value="{{ old('link_youtube') }}">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label>Deskripsi</label>
                </div>
                <div class="col">
                    <textarea class="form-control" name="deskripsi" rows="4" cols="50" value="{{ old('deskripsi') }}"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <label>Pilih Tanggal*</label>
                    <input type="date" class="form-control" name="tanggal_laporan" placeholder="Isi Taanggal" value="{{ old('tanggal_laporan') }}">
                </div>
                <!-- <div class="col">
                                                                                                                                                                    <label>Pilih Semester Laporan Akhir</label>
                                                                                                                                                                    <select class="form-control" name="semester_akhir" aria-label="Default select example">
                                                                                                                                                                        <option selected>Silakan pilih</option>
                                                                                                                                                                       
                                                                                                                                                                        <option value="ajukan_validasi_dpl">Ajukan Validasi DPL</option>
                                                                                                                                                                        <option value="revisi_dpl">Revisi DPL</option>
                                                                                                                                                                        <option value="validasi">Validasi</option>
                                                                                                                                                                    </select>
                                                                                                                                                                </div> -->
            </div>
            <div class="form-group row ml-2">
                <x-button text="Submit" class="btn-success mr-3" id="button_submit" type="submit" />
                <x-button.button-link text="Back" class="btn-danger" link="{{ route('aktivitas.laporan_akhir.mahasiswa.index') }}" />
            </div>
        </form>
    </x-cards.regular-card>
@endsection

@section('js')
    @if (Auth::guard('mahasiswa')->check())
        <script>
            $(document).ready(function() {
                getLaporanAkhir()
            })
        </script>
    @endif
    <script>
        function getLaporanAkhir() {
            var data = {
                registrasi_mbkm_id: @if (Auth::guard('admin')->check())
                    parseInt($('#id-validasi-reg option:selected').val())
                @elseif (Auth::guard('mahasiswa')->check())
                    parseInt($('#id-validasi-reg').val())
                @endif ,
                status: 'tervalidasi'
            }
            console.log(data);

            if (data.registrasi_mbkm_id) {
                $.ajax({
                    url: "{{ url('dashboard/aktivitas/registrasi-mbkm/detail') }}/" + data.registrasi_mbkm_id,
                    // accepts: 'application/json',
                    success: function(resp) {
                        console.log(resp);
                        if (resp.isOk) {
                            console.log('success get data...');

                            $('#tahun-ajaran').val(resp.data.tahun_ajaran.tahun_ajaran);
                            $('#jurusan').val(resp.data.kelas.jurusan.nama);
                            $('#nim').val(resp.data.mahasiswa.nim);
                            $('#semester').val(resp.data.tahun_ajaran.semester.nama);
                            $('#nama-mahasiswa').val(resp.data.mahasiswa.nama);
                            $('#kelas').val(resp.data.kelas.nama);
                            $('#nama-dosen').val(resp.data.dosen_dpl.nama);
                            $('#program').val(resp.data.program.nama);
                        }
                    }
                })

                $.ajax({
                    url: "{{ route('aktivitas.logbook.mingguan.listlogmingguan.all') }}",
                    data: data,
                    type: 'GET',
                    dataType: 'json', // added data type
                    success: function(res) {
                        // $('#tahun-ajaran').val(res.content[0].tahun_ajaran);
                        // $('#jurusan').val(res.content[0].nama_jurusan);
                        // $('#nim').val(res.content[0].nim_mahasiswa);
                        // $('#semester').val(res.content[0].nama_semester);
                        // $('#nama-mahasiswa').val(res.content[0].nama_mahasiswa);
                        // $('#kelas').val(res.content[0].nama_kelas);
                        // $('#nama-dosen').val(res.content[0].nama_dosen);
                        // $('#program').val(res.content[0].nama_program);
                        var html_log_book = "";

                        if (res != null && res.length > 0) {
                            $.each(res, function(index, value) {
                                index += 1;
                                html_log_book += '<div class="col">';
                                html_log_book += '<input class="form-check-input" type="checkbox" id="gridCheck' + index + '" name="id_logbook_mingguan[]" value="' + value.id + '" checked>';
                                html_log_book += '<label class="form-check-label" for="gridCheck' + index + '">';
                                html_log_book += '' + value.judul + '';
                                html_log_book += '</label>';
                                html_log_book += '</div>';
                                
                            });
                            html_log_book += '<span class="text-danger">*Logbook yang sudah diverifikasi tidak dapat diubah</span>';
                            $('.id-log-book-minguaan').html(html_log_book);
                            $('#button_submit').prop('disabled', false)
                        } else {
                            $('.id-log-book-minguaan').html('<span class="text-danger">Tidak ada logbook mingguan yang tervalidasi!</span>')
                            $('#button_submit').prop('disabled', true)
                        }
                        // var mahasiswa = {
                        //     nama :  $('#nama-mahasiswa').val(res.content[0].nama_mahasiswa),
                        // }
                        // console.log(mahasiswa)
                        // test(mahasiswa.nama);
                    }
                });
            }
        }
    </script>
@endsection
