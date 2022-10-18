@extends('layouts.backend.master')
@section('title', 'Laporan Akhir DPL')
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
        <x-cards.regular-card heading="Laporan Akhir DPL">
            <x-button.button-link text="New Laporan Akhir" class="btn-success mb-4" link="{{ route('aktivitas.laporan_akhir.dosen_dpl.create') }}" />
            <x-table id="laporan-akhir-dpl-datatables">
                <x-slot name="header">
                    <tr>
                        <th scope="row">No.</th>
                        <th scope="row">ID Laporan Akhir DPL</th>
                        <th scope="row">Nama Dosen</th>
                        <th scope="row">Semester</th>
                        <th scope="row">Tahun Ajar</th>
                        <th scope="row">Total Beban Jam</th>
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
        var is_admin = "{{ auth('admin')->check() }}"
        var is_mahasiswa = "{{ auth('mahasiswa')->check() }}"
        var is_dosen = "{{ auth('dosen')->check() }}"

        console.log(is_admin, is_dosen, is_mahasiswa);
        $('#laporan-akhir-dpl-datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! url('dashboard/aktivitas/laporan-akhir/dosen-dpl/list-datatable') !!}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'id_laporan_akhir_dosen_dpl',
                    name: 'id_laporan_akhir_dosen_dpl',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'nama_dosen',
                    name: 'dosen.nama',
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
                    data: 'tahun_ajaran',
                    name: 'tahun_ajaran.tahun_ajaran',
                    searchable: true,
                    orderable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: true,
                    orderable: true,
                    render: function(params) {
                        params = JSON.parse(params)
                        var html = `${params.jumlah_beban_harian + params.jumlah_beban_mingguan + params.jumlah_beban_laporan_akhir} Jam`
                        console.log(params);

                        return html
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false,
                    render: function(params) {
                        params = JSON.parse(params)
                        var html = ''

                        html += `<x-button.button-link  text="<i class='fa fa-pencil'></i> Edit" class="btn-info" link="{{ url('dashboard/aktivitas/laporan-akhir/dosen-dpl/edit') }}/${params.id}" />`;
                        html += `<x-button.button-link  text="<i class='fa fa-print'></i> Print" class="btn-primary" link="{{ url('dashboard/aktivitas/laporan-akhir/dosen-dpl/print') }}/${params.id}" target="_BLANK" />`;
                        html += `<x-button text="Delete" class="btn-danger" modalTarget="#modal-delete-${params.id}" />`

                        html += `<x-modal.modal-delete modalId="modal-delete-${params.id}" title="Delete Laporan Akhir DPL"
                        formLink="{!! url('dashboard/aktivitas/laporan-akhir/dosen-dpl/destroy') !!}/${params.id}" />`

                        return html
                    }
                },
            ]
        });
    </script>
@endpush
