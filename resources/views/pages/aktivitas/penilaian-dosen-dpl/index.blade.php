@extends('layouts.backend.master')
@section('title', 'Aktivitas - Penilaian Dosen DPL')
@section('content')

    @if (session()->get('message'))
        <x-alert title="Success" message="{{ session()->get('message') }}" />
    @endif

    @if (session()->get('error'))
        <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
    @endif

    <section class="mt-5">
        <x-cards.regular-card heading="Penilaian Dosen DPL">
            <x-button.button-link text="Add Penilaian" class="btn-success mb-4" link="{{ route('aktivitas.penilaian_dosen_dpl.create') }}" />
            <x-table id="logbook-datatables">
                <x-slot name="header">
                    <tr>
                        <th scope="row">ID</th>
                        <th scope="row">ID Penilaian</th>
                        <th scope="row">Tgl. Penilaian</th>
                        <th scope="row">NIM</th>
                        <th scope="row">Nama Siswa</th>
                        <th scope="row">Jurusan</th>
                        @if (!auth()->guard('dosen')->check())
                            <th scope="row">Dosen</th>
                        @endif
                        <th scope="row">Kelas</th>
                        <th scope="row">Program</th>
                        <th scope="row">Tahun Ajaran</th>
                        <th scope="row">Logbook Mingguan</th>
                        <th scope="row">Laporan Akhir</th>
                        <th scope="row">Status Penilaian</th>
                        <th scope="row">Penilaian</th>
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
        $('#logbook-datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! url('dashboard/aktivitas/penilaian-dosen-dpl/list-datatable') !!}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'id_penilaian',
                    name: 'id_penilaian',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'tanggal_penilaian',
                    name: 'tanggal_penilaian',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'nim',
                    name: 'mahasiswa.nim',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'mahasiswa_nama',
                    name: 'mahasiswa.nama',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'jurusan_nama',
                    name: 'jurusan.nama',
                    searchable: true,
                    orderable: true
                },
                @if (!auth()->guard('dosen')->check())
                    {
                        data: 'dosen_dpl_nama',
                        name: 'dosen_dpl.nama',
                        searchable: true,
                        orderable: true
                    },
                @endif {
                    data: 'kelas_nama',
                    name: 'kelas.nama',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'program_nama',
                    name: 'program.nama',
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
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false, // LOGBOOK MINGGUAN
                    render: function(params) {
                        params = JSON.parse(params)
                        var html = `Valid : ${params.count_logbook_mingguan_valid} <br> Total : ${params.count_logbook_mingguan_all}`
                        return html
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: true,
                    orderable: true, // LAPORAN AKHIR
                    render: function(params) {
                        params = JSON.parse(params)
                        var html = `Valid : ${params.count_laporan_akhir_mahasiswa_valid} <br> Total : ${params.count_laporan_akhir_mahasiswa_all}`
                        return html
                    }
                },
                {
                    data: 'action',
                    name: 'status',
                    searchable: true,
                    orderable: true,
                    render: function(params) {
                        params = JSON.parse(params)
                        var html = ''

                        if (params.status == 'mengajukan') {
                            html += `<span class="badge badge-warning">Mengajukan</span>`;
                        } else if (params.status == 'dalam_proses') {
                            html += `<span class="badge badge-info">Dalam Proses</span>`;
                        } else if (params.status == 'revisi') {
                            html += `<span class="badge badge-danger">Revisi</span>`;
                        } else if (params.status == 'tervalidasi') {
                            html += `<span class="badge badge-success">Valid</span>`;
                        }

                        return html
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
                        var valid_logbook = ((row.count_logbook_mingguan_valid == row.count_logbook_mingguan_all) && (row.count_logbook_mingguan_all > 0))
                        if (row.status != 'tervalidasi') {
                            if (valid_logbook) {
                                html += `<x-button.button-link  text="Lakukan Penilaian" class="btn btn-warning" link="{{ url('dashboard/aktivitas/penilaian-dosen-dpl/detail') }}/${row.id}" />`;
                            } else {
                                html += `<span class="badge badge-danger">Belum dapat melakukan penilaian</span>`
                            }
                        } else {
                            html += `<x-button.button-link  text="Lihat Penilaian" class="btn btn-success" link="{{ url('dashboard/aktivitas/penilaian-dosen-dpl/detail') }}/${row.id}" />`
                        }
                        return html
                    }
                },
                {
                    data: 'nilai',
                    name: 'nilai',
                    searchable: false,
                    orderable: false,
                    render: function(row) {
                        row = JSON.parse(row)
                        console.log(row);
                        return Math.round((row / 23.8) * 10000) / 100
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
                        if (row.status == 'mengajukan' || row.status == 'revisi') {
                            html += `<x-button.button-link  text="Edit" class="btn-info" link="{{ url('dashboard/aktivitas/penilaian-dosen-dpl/edit') }}/${row.id}" />`;
                            if (row.status == 'mengajukan') {
                                html += `<x-button text="Delete" class="btn-danger" modalTarget="#modal-delete-${row.id}" />`;
                                html += `<x-modal.modal-delete modalId="modal-delete-${row.id}" title="Delete Logbook" formLink="{{ url('dashboard/aktivitas/penilaian-dosen-dpl/destroy') }}/${row.id}" />`
                            }
                        }
                        return html
                    }
                }
            ]
        });
    </script>
@endpush
