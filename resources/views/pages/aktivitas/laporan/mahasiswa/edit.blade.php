@extends('layouts.backend.master')
@section('title', 'Update Laporan Akhir')
@section('content')

    @if (session()->get('message'))
        <x-alert title="Success" message="{{ session()->get('message') }}" />
    @endif

    @if (session()->get('error'))
        <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
    @endif


    <x-cards.regular-card heading="Update Laporan Akhir">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('aktivitas.laporan_akhir.mahasiswa.update', ['id' => $dataLogbookmingguan->id]) }}" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (Auth::guard('admin')->check())
                <div class="form-group row">
                    <div class="col">
                        <label>Id Validasi Registrasi</label>
                        <select class="form-control" id="id-validasi-reg" name="id_validasi_reg" onchange="getLaporanAkhir()">

                            <option value='' disabled selected>Silakan pilih</option>
                            @foreach ($listRegistrasiMbkm as $item)
                                <option value="{{ $item->id }}" {{ (old('registrasi_mbkm_id') ?? ($dataLogbookmingguan->registrasi_mbkm_id ?? null)) == $item->id ? 'selected' : '' }}>{{ $item->id_registrasi }}</option>
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
                    <div class="form-check id-log-book-minguaan">
                        @php
                        $no = 1; @endphp
                        @foreach ($dataLogbookmingguanDetail as $item)
                            <div class="col">
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="id_logbook_mingguan" value="{{ $item->id }}" {{ (old('id_logbook_mingguan') ?? null) == $item->id || $item->id_log_book_mingguan ? 'checked' : '' }}>
                                <label class="form-check-label" for="gridCheck1">
                                    {{ $item->judul }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label>Upload '</label>
                <p style="color: red;">PDf Materi*</p>
                <div class="input-group">
                    <div class="col">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="materi_pdf">
                            <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                        </div>
                    </div>
                    <div class="col">
                        @if ($dataLogbookmingguan->materi_pdf)
                            <div>
                                <a href="{{ url('storage/' . $dataLogbookmingguan->matseri_pdf) }}" target="_blank" class="btn btn-success">Dokumen ter-upload</a>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            {{-- <div class="form-group row">
                <label>Upload '</label>
                <p style="color: red;">Video Materi*</p>
                <div class="input-group">
                    <div class="col">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="link_video">
                            <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                        </div>
                    </div>
                    <div class="col">
                        @if ($dataLogbookmingguan->link_video)
                            <div>
                                <a href="{{ url('storage/' . $dataLogbookmingguan->link_video) }}" target="_blank" class="btn btn-success">Video ter-upload</a>
                            </div>
                        @endif
                    </div>

                </div>
            </div> --}}
            <div class="form-group row">
                <div class="col">
                    <label>Judul Materi</label>
                    <input type="text" class="form-control" name="judul_materi" placeholder="Judul Materi" value="{{ old('link_youtube') ?? ($dataLogbookmingguan->judul_materi ?? null) }}">
                </div>
                <div class="col">
                    <div class="custom-file">
                        <label>Link URL Shortener youtube</label>
                        <input type="text" class="form-control" name="link_youtube" value="{{ old('link_youtube') ?? ($dataLogbookmingguan->link_youtube ?? null) }}">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi" rows="4" cols="50" value="{{ old('deskripsi') ?? ($dataLogbookmingguan->deskripsi ?? null) }}">{{ old('deskripsi') ?? ($dataLogbookmingguan->deskripsi ?? null) }}</textarea>
            </div>
            <div class="form-group row">
                <div class="col">
                    <label>Pilih Tanggal*</label>
                    <input type="date" class="form-control" name="tanggal_laporan" placeholder="Isi Taanggal" value="{{ old('tanggal_laporan') ?? (($dataLogbookmingguan->tanggal_laporan_akhir ? \Carbon\Carbon::parse($dataLogbookmingguan->tanggal_laporan_akhir)->format('Y-m-d') : null) ?? null) }}">
                </div>
                <!-- <div class="col">
                                        <label>Pilih Semester Laporan Akhir</label>
                                        <select class="form-control" name="semester_akhir" aria-label="Default select example">
                                            <option selected>Silakan pilih</option>
                                            @foreach ($dataRegistrasiMbkm as $item)
    <option value="{{ $item->id_semester }}}">{{ $item->nama_semester }}</option>
    @endforeach
                                        </select>
                                    </div> -->
            </div>
            <div class="form-group row">
                <x-button text="Submit" class="btn-success mr-3" type="submit" />
                <x-button.button-link text="Back" class="btn-danger" link="{{ route('aktivitas.laporan_akhir.mahasiswa.index') }}" />
            </div>
        </form>
    </x-cards.regular-card>
@endsection

@section('js')
    <script>
        function getLaporanAkhir() {
            var data = {
                registrasi_mbkm_id: parseInt($('#id-validasi-reg option:selected').val()),
                status: 'tervalidasi'
            }
            console.log(data);

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
                    console.log(res);

                    var html_log_book = "";

                    $.each(res, function(index, value) {
                        console.log(value.id);
                        index += 1;
                        html_log_book += '<div class="col">';
                        html_log_book += '<input class="form-check-input" type="checkbox" id="gridCheck' + index + '" name="id_logbook_mingguan[]" value="' + value.id + '">';
                        html_log_book += '<label class="form-check-label" for="gridCheck' + index + '">';
                        html_log_book += '' + value.judul + '';
                        html_log_book += '</label>';
                        html_log_book += '</div>';
                    });

                    $('.id-log-book-minguaan').html(html_log_book);
                }
            });

        }

        // INITIATE DATA EDIT
        $.ajax({
            url: "{{ url('dashboard/aktivitas/registrasi-mbkm/detail') . '/' . $dataLogbookmingguan->registrasi_mbkm_id }}",
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

        var dataEdit = {
            registrasi_mbkm_id: "{{ $dataLogbookmingguan->registrasi_mbkm_id }}",
            status: 'tervalidasi'
        }

        // $.ajax({
        //     url: "{{ route('aktivitas.logbook.mingguan.listlogmingguan.all') }}",
        //     data : dataEdit,
        //     type: 'GET',
        //     dataType: 'json', // added data type
        //     success: function(res) {
        //         console.log(res);

        //         var html_log_book = "";

        //         $.each(res,function(index,value){
        //             console.log(value.id);
        //             index += 1;
        //             html_log_book += '<div class="col">';
        //             html_log_book += '<input class="form-check-input" type="checkbox" id="gridCheck'+index+'" name="id_logbook_mingguan[]" value="'+value.id+'">';
        //             html_log_book += '<label class="form-check-label" for="gridCheck'+index+'">';
        //             html_log_book += ''+value.judul+'';
        //             html_log_book += '</label>';    
        //             html_log_book += '</div>';
        //         });

        //         $('.id-log-book-minguaan').html(html_log_book);
        //     }
        // });
    </script>
@endsection
