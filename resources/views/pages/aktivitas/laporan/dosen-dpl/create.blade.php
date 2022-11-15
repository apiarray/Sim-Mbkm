@extends('layouts.backend.master')
@section('title', 'New Laporan Akhir')
@section('content')

@if (session()->get('message'))
<x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
<x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif


<x-cards.regular-card heading="Insert Laporan Akhir DPL">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('aktivitas.laporan_akhir.dosen_dpl.store') }}" method="post" autocomplete="off">
        @csrf
        @method('POST')
        <div class="form-group row">
            <div class="col">
                <label>Nomor Laporan Akhir <span class="small">(Auto Generate)</span></label>
                <input type="text" class="form-control" value="(Auto Generate)" readonly>
            </div>
        </div>
        @if (Auth::guard('admin')->check())
        <div class="form-group row">
            <div class="col">
                <label>Dosen</label>
                <select class="form-control" id="dosen_dpl_id" name="dosen_dpl_id" onchange="getListRegistrasi()" required>
                    <option value='' disabled selected>Silakan pilih</option>
                    @foreach ($listDosen as $item)
                    <option value="{{ $item->id }}" {{ old('dosen_dpl_id') ?? null == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @elseif(Auth::guard('dosen')->check())
        <input type="hidden" class="form-control" id="dosen_dpl_id" name="dosen_dpl_id" value="{{ Auth::guard('dosen')->user()->id }}" required>
        @endif
        <div class="form-group row">
            <div class="col">
                <label>Tahun Ajaran - Semester</label>
                <select class="form-control" id="tahun_ajaran_id" name="tahun_ajaran_id" onchange="getListRegistrasi()" required>
                    <option value='' disabled selected>Silakan pilih</option>
                    @foreach ($listTahunAjaran as $item)
                    <option value="{{ $item->id }}" {{ old('tahun_ajaran_id') ?? null == $item->id ? 'selected' : '' }}>{{ $item->tahun_ajaran . ' - ' . $item->semester }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">Rincian Laporan Akhir</div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Validasi Registrasi</th>
                                    <th>ID Penilaian</th>
                                    <th>Tanggal Penilaian</th>
                                    <th>NIM - Mahasiswa</th>
                                    <th>Log Book Harian</th>
                                    <th>Beban Jam</th>
                                    <th>Log Book Mingguan</th>
                                    <th>Beban Jam</th>
                                    <th>Laporan Akhir</th>
                                    <th>Beban Jam</th>

                                </tr>
                            </thead>
                            <tbody id="rincian-laporan-akhir"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col">
                <label>Pilih Tanggal*</label>
                <input type="date" class="form-control" name="tanggal_laporan" placeholder="Isi Tanggal" value="{{ old('tanggal_laporan') }}" required>
            </div>
        </div>
        <div class="form-group row ml-2">
            <x-button text="Submit" class="btn-success mr-3" type="submit" />
            <x-button.button-link text="Back" class="btn-danger" link="{{ route('aktivitas.laporan_akhir.dosen_dpl.index') }}" />
        </div>
    </form>
</x-cards.regular-card>
@endsection

@section('js')
@if (Auth::guard('dosen')->check())
<script>
    $(document).ready(function() {
        getListRegistrasi()
    })
</script>
@endif
<script>
    function getListRegistrasi() {
        var data = {
            status_validasi: 'tervalidasi',
            is_accepted: 1,
            has_penilaian: 1,
            tahun_ajaran_id: parseInt($('#tahun_ajaran_id').val()),
            dosen_dpl_id: parseInt($('#dosen_dpl_id').val())
        }
        console.log(data);

        if (data.tahun_ajaran_id && data.dosen_dpl_id) {
            $.ajax({
                url: "{{ route('aktivitas.registrasi_mbkm.list_registrasi_all') }}",
                // accepts: 'application/json',
                data: data,
                success: function(resp) {
                    console.log(resp);
                    var htmlTable = ''
                    if (resp.length > 0) {
                        for (let i in resp) {
                            htmlTable += `<tr>
                                <td>
                                    ${resp[i].id_registrasi}
                                </td>
                                <td>
                                    ${resp[i].id_penilaian}
                                </td>
                                <td>
                                    ${resp[i].tanggal_penilaian}
                                </td>
                                <td>
                                    ${resp[i].nim_mahasiswa} - ${resp[i].nama_mahasiswa}
                                </td>
                                <td>
                                    ${resp[i].count_logbook_harian}
                                </td>
                                <td>
                                    <input class="form-control" type="hidden" required name="registrasi_mbkm_id[]" value="${resp[i].id}">
                                    <input class="form-control" type="number" required name="beban_jam_log_harian[]" min=0>
                                </td>
                                <td>
                                    ${resp[i].count_logbook_mingguan}
                                </td>
                                <td>
                                    <input class="form-control" type="number" required name="beban_jam_log_mingguan[]" min=0>
                                </td>
                                <td>
                                    ${resp[i].id_laporan_akhir_mahasiswa}
                                </td>
                                <td>
                                    <input class="form-control" type="number" required name="beban_jam_laporan_akhir[]" min=0>
                                </td>

                            </tr>`
                        }
                    } else {
                        htmlTable = '<tr><td colspan=10><span class="text-danger">Tidak ada Data Registrasi yang VALID dan TELAH DINILAI</span></td></tr>'
                    }

                    $('#rincian-laporan-akhir').html(htmlTable)
                }
            })
        } else if (!data.tahun_ajaran_id && data.dosen_dpl_id) {
            $('#rincian-laporan-akhir').html('<tr><td colspan=10><span class="text-danger">Harap Pilih Tahun Ajaran</span></td></tr>')
        } else if (data.tahun_ajaran_id && !data.dosen_dpl_id) {
            $('#rincian-laporan-akhir').html('<tr><td colspan=10><span class="text-danger">Harap Pilih Dosen</span></td></tr>')
        } else {
            $('#rincian-laporan-akhir').html('<tr><td colspan=10><span class="text-danger">Harap Pilih Dosen dan Tahun Ajaran</span></td></tr>')
        }
    }
</script>
@endsection