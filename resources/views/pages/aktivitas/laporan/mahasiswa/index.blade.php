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
        <x-cards.regular-card heading="Laporan Akhir Mahasiswa">
            @if (!auth()->guard('dosen')->check())
                <x-button.button-link text="New Laporan Akhir" class="btn-success mb-4" link="{{ route('aktivitas.laporan_akhir.mahasiswa.create') }}" />
            @endif
            <x-table id="logbook-datatables">
                <x-slot name="header">
                    <tr>
                        <th scope="row">ID Validasi Reg</th>
                        <th scope="row">ID Laporan Akhir</th>
                        <th scope="row">Semester</th>
                        @if (!auth()->guard('mahasiswa')->check())
                            <th scope="row">NIM</th>
                            <th scope="row">Nama Siswa</th>
                            <th scope="row">Jurusan</th>
                        @endif
                        <th scope="row">Nama Dosen</th>
                        @if (!auth()->guard('mahasiswa')->check())
                            <th scope="row">Kelas</th>
                            <th scope="row">Program</th>
                        @endif
                        <th scope="row">Tahun Ajaran</th>
                        <th scope="row">Deskripsi</th>
                        <th scope="row">Status Laporan Akhir</th>
                        <th scope="row">Dokumen</th>
                        <th scope="row">Link Youtube</th>
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
                url: '{!! url('dashboard/aktivitas/laporan-akhir/mahasiswa/list-datatable') !!}',
            },
            columns: [{
                    data: 'registrasi_mbkm_id',
                    name: 'registrasi_mbkm_id',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'id_laporan_akhir_mahasiswa',
                    name: 'id_laporan_akhir_mahasiswa',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'semester',
                    name: 'semester',
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
                @endif {
                    data: 'dosen_dpl_nama',
                    name: 'dosen_dpl_nama',
                    searchable: true,
                    orderable: true
                },
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
                    orderable: true
                },
                {
                    data: 'action',
                    name: 'status_laporan_akhir',
                    searchable: true,
                    orderable: true,
                    render: function(row) {
                        row = JSON.parse(row)
                        var html = ''

                        if (row.status_laporan_akhir == 'dalam_proses') {
                            if(hak_akses == 'Dosen' || hak_akses == 'Admin'){
                                html += `<x-button text="Proses Validasi" class="btn-info" modalTarget="#modal-confirm-proses-validasi-${row.id}" />`;
                            html += `<x-modal.modal-confirm modalId="modal-confirm-proses-validasi-${row.id}" title="Proses Validasi" 
                    formLink="{{ url('dashboard/aktivitas/laporan-akhir/mahasiswa/validate') }}/${row.id}" >
                    <slot>
                        <div class="form-group">
                            <select name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="validasi">Valid</option>
                                <option value="revisi">Revisi</option>
                            </select>
                        </div>
                    </slot>
                    </x-modal.modal-confirm>`
                            }else{
                                html+=`<span class="badge badge-info">Readonly</span>`
                            }

                        }else if (row.status_laporan_akhir == 'mengajukan' && ( hak_akses == 'Admin' || hak_akses == 'Mahasiswa')) {
                            html += `<x-button text="Ajukan Validasi" class="btn-warning" modalTarget="#modal-confirm-proses-validasi-${row.id}" />`;
                            html += `<x-modal.modal-confirm modalId="modal-confirm-proses-validasi-${row.id}" title="Proses Validasi" 
                    formLink="{{ url('dashboard/aktivitas/laporan-akhir/mahasiswa/validate') }}/${row.id}" >
                    <slot>
                        <div class="form-group">
                            <select name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="dalam_proses">Proses Ke Dosen</option>
                            </select>
                        </div>
                    </slot>
                    </x-modal.modal-confirm>`
                        }

                        else if (row.status_laporan_akhir == 'mengajukan' && hak_akses == 'Dosen') {
                            html += `<x-button text="Ajukan Validasi" class="btn-warning" />`;
                        }


                        else if (row.status_laporan_akhir == 'revisi' && (hak_akses == 'Mahasiswa' || hak_akses == 'Admin' || hak_akses == 'Dosen')) {
                            html += `<x-button text="Revisi" class="btn-danger" modalTarget="#modal-confirm-kirim-revisi-${row.id}" />`;
                            html += `<x-modal.modal-confirm modalId="modal-confirm-kirim-revisi-${row.id}" title="Kirim Revisi" 
                    formLink="{{ url('dashboard/aktivitas/laporan-akhir/mahasiswa/validate') }}/${row.id}" >
                    <slot>
                        <div class="form-group">
                            <select name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="dalam_proses">Kirim Revisi</option>
                            </select>
                        </div>
                    </slot>
                    </x-modal.modal-confirm>`
                        } else if (row.status_laporan_akhir == 'validasi') {
                            html += '<span class="badge bg-success">VALID</span>';
                        }else if(hak_akses == 'Mahasiswa'){
                            html += '<span class="badge bg-warning">MENUNGGU VALIDASI</span>';
                        }

                        return html
                    }
                },
                {
                    data: 'materi_pdf',
                    name: 'materi_pdf',
                    searchable: true,
                    orderable: true,
                    render:function(row){
                        if(row){
                            return `<x-button.button-link  text="Download" class="btn-success" link="{{ url('storage') }}/${row}" />`;
                            
                        }
                    }
                },
                {
                    data: 'link_youtube',
                    name: 'link_youtube',
                    searchable: true,
                    orderable: true,
                    render:function(row){
                        if(row){
                            return `<x-button.button-link  text="Video" class="btn-success" link="${row}" />`;
                            
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

                        html += `<x-button.button-link  text="Detail" class="btn-success" link="{{ url('dashboard/aktivitas/laporan-akhir/mahasiswa/detail') }}/${row.id}" />`;
                        if ((row.status_laporan_akhir == 'mengajukan' || row.status_laporan_akhir == 'revisi') && (hak_akses == 'Mahasiswa' || hak_akses == 'Admin')) {
                            html += `<x-button.button-link  text="Edit" class="btn-info" link="{{ url('dashboard/aktivitas/laporan-akhir/mahasiswa/edit') }}/${row.id}" />`;
                            if (row.status_laporan_akhir == 'mengajukan' && (hak_akses == 'Mahasiswa' || hak_akses == 'Admin')) {
                                html += `<x-button.button-link  text="delete" class="btn-danger" link="{{ url('dashboard/aktivitas/laporan-akhir/mahasiswa/destroy') }}/${row.id}" />`;
                            }
                        }
                        return html
                    }
                }
            ]
        });
    </script>
@endpush
