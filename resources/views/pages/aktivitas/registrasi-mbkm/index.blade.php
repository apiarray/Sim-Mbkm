@extends('layouts.backend.master')
@section('title', 'Data Registrasi MBKM')
@section('content')

    @if (session()->get('message'))
        <x-alert title="Success" message="{{ session()->get('message') }}" />
    @endif

    @if (session()->get('error'))
        <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
    @endif

    @if ($errors->any())
        <x-alert type="danger" title="Error" message="
                                                                                {!! implode('', $errors->all('<div>:message</div>')) !!}" />
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
                                @foreach ($listTahunAjaran as $x)
                                    <option value="{{ $x->id }}" @if (request('tahun_ajaran') == $x->id) selected @endif>{{ $x->tahun_ajaran . ' - ' . $x->semester }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="program">Program</label>
                            <select class="form-control" name="program" id="program">
                                <option value="">Semua</option>
                                @foreach ($listProgram as $x)
                                    <option value="{{ $x->id }}" @if (request('program') == $x->id) selected @endif>{{ $x->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status_validasi">Status Validasi</label>
                            <select class="form-control" name="status_validasi" id="status_validasi">
                                <option value="">Semua</option>
                                <option value="mengajukan" @if (request('status_validasi') == 'mengajukan') selected @endif>Mengajukan</option>
                                <option value="tervalidasi" @if (request('status_validasi') == 'tervalidasi') selected @endif>Tervalidasi</option>
                                <option value="batal" @if (request('status_validasi') == 'batal') selected @endif>Batal</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                        <a type="button" class="btn btn-primary" href="{{ route('aktivitas.registrasi_mbkm.index') }}"><i class="fa fa-refresh"></i> Reset</a>
                    </div>
                </div>
            </form>
        </x-cards.regular-card>
        <x-cards.regular-card heading="Data Pendaftaran">
            <x-table id="registrasi-datatables">
                <x-slot name="header">
                    <tr>
                        <th scope="row">No.</th>
                        <th scope="row">ID Reg</th>
                        @if (!auth()->guard('mahasiswa')->check())
                            <th scope="row">Nama Mahasiswa</th>
                            <th scope="row">NIM</th>
                        @endif
                        <th scope="row">Status</th>
                        <th scope="row">Fakultas</th>
                        <th scope="row">Tahun Ajar</th>
                        <th scope="row">Semester</th>
                        <th scope="row">Program</th>
                        <th scope="row">Tgl. Registrasi</th>
                        <th scope="row">Tgl. Validasi</th>
                        <th scope="row">Lampiran</th>
                        <th scope="row">Status Validasi</th>
                        @if (auth()->guard('admin')->check())
                            <th scope="row">Tolak Registrasi</th>
                        @endif
                        @if (!auth()->guard('dosen')->check())
                            <th scope="row">Dosen DPL</th>
                        @endif
                        <th scope="row">Action</th>
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
        @if (auth()->guard('mahasiswa')->check())
            let hak_akses = 'Mahasiswa';
        @elseif (auth()->guard('dosen')->check())
            let hak_akses = 'Dosen';
        @elseif (auth()->guard('admin')->check())
            let hak_akses = 'Admin';
        @endif

        var param_tahun_ajaran = "{{ request('tahun_ajaran') }}";
        var param_status_validasi = "{{ request('status_validasi') }}";
        var param_program = "{{ request('program') }}";

        $('#registrasi-datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! url('dashboard/aktivitas/registrasi-mbkm/list-datatable') !!}',
                data: {
                    tahun_ajaran_id: param_tahun_ajaran,
                    status_validasi: param_status_validasi,
                    program_id: param_program,
                },
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'id_registrasi',
                    name: 'id_registrasi',
                    searchable: true,
                    orderable: true
                },
                @if (!auth()->guard('mahasiswa')->check())
                    {
                        data: 'nama_mahasiswa',
                        name: 'mahasiswa.nama',
                        searchable: true,
                        orderable: true
                    }, {
                        data: 'nim_mahasiswa',
                        name: 'mahasiswa.nim',
                        searchable: true,
                        orderable: true
                    },
                @endif {
                    data: 'status_mahasiswa',
                    name: 'mahasiswa.status',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'fakultas',
                    name: 'fakultas.nama',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'tahun_ajaran',
                    name: 'tahun_ajaran.tahun_ajaran',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'semester',
                    name: 'semester.nama',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'program',
                    name: 'program.nama',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'ttanggal_registrasi',
                    name: 'ttanggal_registrasi',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'ttanggal_validasi',
                    name: 'ttanggal_validasi',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false, // lampiran
                    render: function(params) {
                        params = JSON.parse(params)
                        var html = ''
                        if (params.file_khs && params.file_krs) {
                            html += `<a href="{{ url('storage') }}/${params.file_khs}" target="_blank" class="btn btn-xs btn-success m-2">Berkas 1</a>`
                            html += `<a href="{{ url('storage') }}/${params.file_krs}" target="_blank" class="btn btn-xs btn-success m-2">Berkas 2</a>`
                        } else if ((params.file_khs || params.file_krs) && (hak_akses == 'Admin' || hak_akses == 'Mahasiswa')) {
                            html += `<x-button.button-link text="Upload Kurang" class="btn-warning" link="{{ url('dashboard/aktivitas/registrasi-mbkm/form-upload-file') }}/${params.id}" title="Melakukan upload file untuk ${params.nama_mahasiswa }"/>`
                        } else {
                            if ((hak_akses == 'Admin' || hak_akses == 'Mahasiswa')) {
                                html += `<x-button.button-link text="Belum Upload" class="btn-primary" link="{{ url('dashboard/aktivitas/registrasi-mbkm/form-upload-file') }}/${params.id}" title="Melakukan upload file untuk ${params.nama_mahasiswa }"/>`
                            }
                        }

                        return html
                    }
                },
                {
                    data: 'action',
                    name: 'status_validasi',
                    searchable: true,
                    orderable: true,
                    render: function(params) {
                        params = JSON.parse(params)
                        var html = `<span><b>${params.status_validasi.toUpperCase()}</b><span><br><br>`

                        if (hak_akses == 'Admin') {
                            if (params.status_validasi == 'mengajukan') {
                                html += `<x-button text="Validasi" class="btn-xs btn-success" modalTarget="#modal-confirm-validate-${params.id}" title="Mem-validasi registrasi untuk ${params.nama_mahasiswa}"/>`
                            } else if (params.status_validasi == 'batal') {
                                html += `<x-button text="Ajukan Validasi" class="btn-xs btn-warning" modalTarget="#modal-confirm-propose-${params.id}" title="Mengembalikan menjadi ajukan validasi registrasi untuk ${params.nama_mahasiswa}"/>`
                            } else if (params.status_validasi == 'tervalidasi') {
                                html += `<x-button text="Batalkan Validasi" class="btn-xs btn-danger" modalTarget="#modal-confirm-cancel-${params.id}" title="Membatalkan validasi registrasi untuk ${params.nama_mahasiswa}"/>`
                            }
                        }

                        return html
                    }
                },
                @if (auth()->guard('admin')->check())
                    {
                        data: 'action',
                        name: 'is_accepted',
                        searchable: false,
                        orderable: false,
                        render: function(params) {
                            params = JSON.parse(params)
                            var html = ''
                            var txtBtn = ''
                            var titleBtn = ''
                            var classBtn = ''
                            if (params.is_accepted == 1) {
                                txtBtn = 'No'
                                titleBtn = 'Tolak Registrasi'
                                classBtn = 'btn-warning'
                            } else {
                                txtBtn = 'Yes'
                                titleBtn = 'Setujui Registrasi'
                                classBtn = 'btn-success'
                            }
                            html += `<x-button text="${txtBtn}" class="btn-xs ${classBtn}" modalTarget="#modal-confirm-accept-reject-registration-${params.id}" title="${titleBtn}"/>`
                            return html
                        }
                    },
                @endif
                @if (!auth()->guard('dosen')->check())
                    {
                        data: 'nama_dosen_dpl',
                        name: 'dosen_dpl.nama',
                        searchable: true,
                        orderable: true
                    },
                @endif {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false,
                    render: function(params) {
                        params = JSON.parse(params)
                        var html = ''

                        if (params.status_validasi == 'mengajukan' && hak_akses == 'Admin') {
                            html += `<x-button text="Delete" class="btn-danger" modalTarget="#modal-delete-${params.id}" />`
                        }

                        html += `<x-modal.modal-delete modalId="modal-delete-${params.id}" title="Delete Registrasi MBKM"
                        formLink="{!! url('dashboard/aktivitas/registrasi-mbkm/destroy') !!}/${params.id}" />`
                        html += `<x-modal.modal-confirm modalId="modal-confirm-validate-${params.id}" title="Apakah Anda yakin?"  message="Apakah Anda yakin ingin melakukan validasi terhadap <b>${params.nama_mahasiswa}</b>?"
                        formLink="{!! url('dashboard/aktivitas/registrasi-mbkm/validate-registrasi') !!}/${params.id}" >
                        <slot>
                            <div class="form-group">
                                <x-inputs.selector name="dosen_dpl_id" label="Dosen" isRequired="true" :data="$dataDosenDpl"></x-inputs.selector>
                            </div>
                            <div class="form-group">
                                <x-inputs.selector name="kelas_id" label="Kelas" isRequired="true" :data="$dataKelas" value="${params.kelas_id}"></x-inputs.selector>
                            </div>
                        </slot>
                    </x-modal.modal-confirm>`
                        html += `<x-modal.modal-confirm modalId="modal-confirm-cancel-${params.id}" title="Apakah Anda yakin?"  message="Apakah Anda yakin ingin melakukan pembatalan validasi terhadap <b>${params.nama_mahasiswa}</b>?"
                        formLink="{!! url('dashboard/aktivitas/registrasi-mbkm/validate-registrasi') !!}/${params.id}" />`
                        html += `<x-modal.modal-confirm modalId="modal-confirm-propose-${params.id}" title="Apakah Anda yakin?"  message="Apakah Anda yakin ingin melakukan pengajuan validasi terhadap <b>${params.nama_mahasiswa}</b>?"
                        formLink="{!! url('dashboard/aktivitas/registrasi-mbkm/validate-registrasi') !!}/${params.id}" />`
                        html += `<x-modal.modal-confirm modalId="modal-confirm-accept-reject-registration-${params.id}" title="Apakah Anda yakin?"  message="Apakah Anda yakin ingin ${params.is_accepted == 1 ? 'menolak' : 'menyetujui' } registrasi <b>${params.nama_mahasiswa}</b>?"
                        formLink="{!! url('dashboard/aktivitas/registrasi-mbkm/accept-reject-registrasi') !!}/${params.id}" />`

                        return html
                    }
                },
            ]
        });
    </script>
@endpush
