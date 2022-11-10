@extends('layouts.backend.master')
@section('title', 'Aktivitas - Log Book')
@section('content')

    @if (session()->get('message'))
        <x-alert title="Success" message="{{ session()->get('message') }}" />
    @endif

    @if (session()->get('error'))
        <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
    @endif

    <section class="mt-5">
        <x-cards.regular-card heading="Logbook Harian">
            @if (!auth()->guard('dosen')->check())
                <x-button.button-link text="New Logbook Harian" class="btn-success mb-4" link="{{ route('aktivitas.logbook.harian.create') }}" />
            @endif
            <x-table id="logbook-datatables">
                <x-slot name="header">
                    <tr>
                        <th scope="row">ID</th>
                        <th scope="row">ID Log Book Harian</th>
                        <th scope="row">TGL Log Book Harian</th>
                        @if (!auth()->guard('mahasiswa')->check())
                            <th scope="row">NIM</th>
                            <th scope="row">Nama Siswa</th>
                            <th scope="row">Jurusan</th>
                        @endif
                        @if (!auth()->guard('dosen')->check())
                            <th scope="row">Dosen</th>
                        @endif
                        @if (!auth()->guard('mahasiswa')->check())
                            <th scope="row">Kelas</th>
                            <th scope="row">Program</th>
                        @endif
                        <th scope="row">Tahun Ajaran</th>
                        <th scope="row">Deskripsi</th>
                        <th scope="row">Status Log Book Harian</th>
                        <th scope="row">Alokasi Waktu</th>
                        <th scope="row">Dwonload</th>
                        <th scope="row">Action</th>
                    </tr>
                </x-slot>
                <x-slot name="body">

                </x-slot>
            </x-table>
            <div class="d-flex flex-row justify-content-center mt-3">
                {{-- {{ $dataLogBookHarianList->links() }} --}}
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
        $('#logbook-datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! url('dashboard/aktivitas/logbook/harian/list-datatable') !!}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'id_log_harian',
                    name: 'id_log_harian',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'ttanggal',
                    name: 'ttanggal',
                    searchable: true,
                    orderable: true
                },
                @if (!auth()->guard('mahasiswa')->check())
                    {
                        data: 'nim',
                        name: 'nim',
                        searchable: true,
                        orderable: true
                    }, {
                        data: 'mahasiswa_nama',
                        name: 'mahasiswa_nama',
                        searchable: true,
                        orderable: true
                    }, {
                        data: 'jurusan_nama',
                        name: 'jurusan_nama',
                        searchable: true,
                        orderable: true
                    },
                @endif
                @if (!auth()->guard('dosen')->check())
                    {
                        data: 'dosen_dpl_nama',
                        name: 'dosen_dpl_nama',
                        searchable: true,
                        orderable: true
                    },
                @endif
                @if (!auth()->guard('mahasiswa')->check())
                    {
                        data: 'kelas_nama',
                        name: 'kelas_nama',
                        searchable: true,
                        orderable: true
                    }, {
                        data: 'program_nama',
                        name: 'program_nama',
                        searchable: true,
                        orderable: true
                    },
                @endif {
                    data: 'tahun_ajaran',
                    name: 'tahun_ajaran',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'deskripsi',
                    name: 'deskripsi',
                    searchable: true,
                    orderable: true,
                },
                {
                    data: 'action',
                    name: 'status',
                    searchable: true,
                    orderable: true,
                    render: function(params) {
                        params = JSON.parse(params)
                        var html = ''

                        if (params.status == 'tervalidasi') {
                            html += '<span class="badge bg-success">VALID</span>';
                        } else if (params.status == 'dalam_proses') {
                            if(hak_akses == 'Mahasiswa'){
                                html += '<span class="badge bg-info">Readonly</span>';
                            }else{
                                html += `<x-button text="Proses Validasi" class="btn-info" modalTarget="#modal-confirm-proses-validasi-${params.id}" />`;
                            html += `<x-modal.modal-confirm modalId="modal-confirm-proses-validasi-${params.id}" title="Proses Validasi" 
                            formLink="{{ url('dashboard/aktivitas/logbook/harian/validate') }}/${params.id}" >
                    <slot>
                        <div class="form-group">
                            <select name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="tervalidasi">Valid</option>
                                <option value="revisi">Revisi</option>
                            </select>
                        </div>
                    </slot>
                    </x-modal.modal-confirm>`
                            }
                            
                        }else if(hak_akses == 'Mahasiswa' && params.status == 'mengajukan'){
                            html += `<x-button text="Ajukan Validasi" class="btn-warning" modalTarget="#modal-confirm-proses-validasi-${params.id}" />`;
                            html += `<x-modal.modal-confirm modalId="modal-confirm-proses-validasi-${params.id}" title="Proses Validasi" 
                    formLink="{{ url('dashboard/aktivitas/logbook/harian/validates') }}/${params.id}" >
                    <slot>
                        <div class="form-group">
                            <select name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="dalam_proses">Ajukan Ke Dosen</option>
                            </select>
                        </div>
                    </slot>
                    </x-modal.modal-confirm>`                            
                        }
//status pada mahasiswa saat dalam proses

//end status pada mahasiswa
                        else if (params.status == 'mengajukan' && (hak_akses == 'Admin' || hak_akses == 'Dosen')) {
                            // html += '<span class="badge bg-warning">AJUKAN VALIDASI</span>';
                            html += `<x-button text="Ajukan Validasi" class="btn-warning" modalTarget="#modal-confirm-mengajukan-${params.id}" />`;
                            html += `<x-modal.modal-confirm modalId="modal-confirm-mengajukan-${params.id}" title="Ajukan Validasi" formLink="{{ url('dashboard/aktivitas/logbook/harian/validate') }}/${params.id}" >
                    <slot>
                        <div class="form-group">
                            <select name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="dalam_proses">Proses ke Dosen</option>
                            </select>
                        </div>
                    </slot>
                    </x-modal.modal-confirm>`
                        } else if (params.status == 'revisi' && (hak_akses == 'Admin'  || hak_akses == 'Dosen')) {
                            // html += '<span class="badge bg-danger">REVISI DOSEN</span>';
                            html += `<x-button text="Revisi" class="btn-danger" modalTarget="#modal-confirm-revisi-${params.id}" />`;
                            html += `<x-modal.modal-confirm modalId="modal-confirm-revisi-${params.id}" title="Revisi" formLink="{{ url('dashboard/aktivitas/logbook/harian/validate') }}/${params.id}" >
                    <slot>
                        <div class="form-group">
                            <select name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="dalam_proses">Proses ke Dosen</option>
                            </select>
                        </div>
                    </slot>
                    </x-modal.modal-confirm>`
                        }
                        //revisi dari mahasiswa ke dosen 

                        else if ( hak_akses == 'Mahasiswa' && params.status == 'revisi') {
                            // html += '<span class="badge bg-danger">REVISI DOSEN</span>';
                            html += `<x-button text="Revisi" class="btn-danger" modalTarget="#modal-confirm-revisi-${params.id}" />`;
                            html += `<x-modal.modal-confirm modalId="modal-confirm-revisi-${params.id}" title="Revisi" formLink="{{ url('dashboard/aktivitas/logbook/harian/validates') }}/${params.id}" >
                    <slot>
                        <div class="form-group">
                            <select name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="dalam_proses">Proses ke Dosen</option>
                            </select>
                        </div>
                    </slot>
                    </x-modal.modal-confirm>`
                        }

                        //end reviisi
                        return html
                    }
                },

                {
                    data: 'durasi',
                    name: 'durasi',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'link_dokumen',
                    name: 'link_dokumen',
                    searchable: true,
                    orderable: true,
                    render:function(row){
                        if(row){
                            return `<x-button.button-link  text="Dwonload" class="btn-info" link="" />`;
                            
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false,
                    render: function(row) {
                        row = JSON.parse(row)
                        console.log(row);
                        var html = ''
                        html += `<x-button.button-link  text="Detail" class="btn-primary" link="{{ url('dashboard/aktivitas/logbook/harian/detail') }}/${row.id}" />`;
                        if ((row.status == 'mengajukan' || row.status == 'revisi') && (hak_akses == 'Mahasiswa' || hak_akses == 'Admin')) {
                            html += `<x-button.button-link  text="Edit" class="btn-info" link="{{ url('dashboard/aktivitas/logbook/harian/edit') }}/${row.id}" />`;
                            if (row.status == 'mengajukan' && (hak_akses == 'Mahasiswa' || hak_akses == 'Admin')) {
                                html += `<x-button.button-link text="Delete" class="btn-danger" modalTarget="#modal-delete-${row.id}" />`;
                                html += `<x-modal.modal-delete modalId="modal-delete-${row.id}" title="Delete Logbook" formLink="{{ url('dashboard/aktivitas/logbook/harian/destroy') }}/${row.id}" />`
                            }
                        }
                        return html
                    }
                }
            ]
        });
    </script>
@endpush
