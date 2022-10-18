@extends('layouts.backend.master')
@section('title', 'Laporan Registrasi')
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
    <x-cards.regular-card heading="Filter">
        <form action="" method="get">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tahun_ajaran">Tahun Ajaran</label>
                        <select class="form-control" name="tahun_ajaran" id="tahun_ajaran">
                            <option value="">Semua</option>
                            @foreach($listTahunAjaran as $x)
                                <option value="{{ $x->id }}" @if(request('tahun_ajaran') == $x->id) selected @endif>{{ $x->tahun_ajaran . ' - ' . $x->semester }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="program">Program</label>
                        <select class="form-control" name="program" id="program">
                            <option value="">Semua</option>
                            @foreach($listProgram as $x)
                                <option value="{{ $x->id }}" @if(request('program') == $x->id) selected @endif>{{ $x->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status_validasi">Status Validasi</label>
                        <select class="form-control" name="status_validasi" id="status_validasi">
                            <option value="">Semua</option>
                            <option value="mengajukan" @if(request('status_validasi') == "mengajukan") selected @endif>Mengajukan</option>
                            <option value="tervalidasi" @if(request('status_validasi') == "tervalidasi") selected @endif>Tervalidasi</option>
                            <option value="batal" @if(request('status_validasi') == "batal") selected @endif>Batal</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                    <a type="button" class="btn btn-primary" href="{{ route('laporan.registrasi.index') }}"><i class="fa fa-refresh"></i> Reset</a>
                </div>
            </div>
        </form>
    </x-cards.regular-card>
    <x-cards.regular-card heading="Laporan Registrasi">
        <x-table id="registrasi-datatables">
            <x-slot name="header">
                <tr>
                    <th scope="row">No.</th>
                    <th scope="row">ID Reg</th>
                    <th scope="row">Nama Mahasiswa</th>
                    <th scope="row">NIM</th>
                    <th scope="row">Status</th>
                    <th scope="row">Fakultas</th>
                    <th scope="row">Tahun Ajar</th>
                    <th scope="row">Semester</th>
                    <th scope="row">Program</th>
                    <th scope="row">Tgl. Registrasi</th>
                    <th scope="row">Tgl. Validasi</th>
                    <th scope="row">Lampiran</th>
                    <th scope="row">Status Validasi</th>
                </tr>
            </x-slot>
            <x-slot name="body">
            </x-slot>
        </x-table>
        <div class="d-flex flex-row justify-content-center mt-3">
        </div>
    </x-cards.regular-card>
</section>
@endsection

@push('datatable-scripts')
<script>
    var param_tahun_ajaran = "{{ request('tahun_ajaran') }}"; 
    var param_status_validasi = "{{ request('status_validasi') }}"; 
    var param_program = "{{ request('program') }}"; 
    $('#registrasi-datatables').DataTable({
        processing: true,
        serverSide: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend:'pdfHtml5',
                text:'Export PDF',
                orientation:'landscape',
                pageSize: 'LEGAL'
            },
            {
                extend:'excel',
                text:'Export Excel',
            }
        ],
        ajax: {
            url: '{!! url("dashboard/aktivitas/registrasi-mbkm/list-datatable") !!}',
            data: {
                tahun_ajaran_id: param_tahun_ajaran,
                status_validasi: param_status_validasi,
                program_id: param_program,
            },
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
            { data: 'id_registrasi', name: 'id_registrasi', searchable: true, orderable: true },
            { data: 'nama_mahasiswa', name: 'mahasiswa.nama', searchable: true, orderable: true },
            { data: 'nim_mahasiswa', name: 'mahasiswa.nim', searchable: true, orderable: true },
            { data: 'status_mahasiswa', name: 'mahasiswa.status', searchable: true, orderable: true },
            { data: 'fakultas', name: 'fakultas.nama', searchable: true, orderable: true },
            { data: 'tahun_ajaran', name: 'tahun_ajaran.tahun_ajaran', searchable: true, orderable: true },
            { data: 'semester', name: 'semester.nama', searchable: true, orderable: true },
            { data: 'program', name: 'program.nama', searchable: true, orderable: true },
            { data: 'tanggal_registrasi', name: 'tanggal_registrasi', searchable: true, orderable: true },
            { data: 'tanggal_validasi', name: 'tanggal_validasi', searchable: true, orderable: true },
            { data: 'action', name: 'action', searchable: false, orderable: false, // lampiran
                render: function(params) {
                    params = JSON.parse(params)
                    var html = ''
                    if(params.file_khs){
                        html += `<a href="{{ url('storage') }}/storage/${params.file_khs}" target="_blank" class="btn btn-xs btn-success m-2">Berkas 1</a>`
                    }
                    if(params.file_krs){
                        html += `<a href="{{ url('storage') }}/storage/${params.file_krs}" target="_blank" class="btn btn-xs btn-success m-2">Berkas 2</a>`
                    }
                    return html
                }
            },
            { data: 'action', name: 'status_validasi', searchable: true, orderable: true,
                render: function (params) {
                    params = JSON.parse(params)
                    var html = ''

                    if(params.status_validasi == 'mengajukan'){
                        html += `<span class="badge badge-warning">Mengajukan</span>`;
                    } else if(params.status_validasi == 'batal'){
                        html += `<span class="badge badge-danger">Batal</span>`;
                    } else if(params.status_validasi == 'tervalidasi'){
                        html += `<span class="badge badge-success">Valid</span>`;
                    }
                    
                    return html
                }
            },
        ]
    });
</script>
@endpush