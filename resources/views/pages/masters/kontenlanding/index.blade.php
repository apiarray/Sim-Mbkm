@extends('layouts.backend.masterdatatable')
@section('title', 'Daftar  Konten')
@section('content')

@if (session()->get('message'))
    <x-alert title="Success" message="{{ session()->get('message') }}" />
@endif

@if (session()->get('error'))
    <x-alert type="danger" title="Error" message="{{ session()->get('error') }}" />
@endif

<section class="mt-5">
    <x-cards.regular-card heading="Data Konten">
	  
        <x-button.button-link text="New Konten" class="btn-success mb-4" link="{{ route('Konten.create') }}" />
		
        <x-table class=" tabelkujos" id="tabelkujos">
            <x-slot name="header">
                <tr>
                    <th scope="row">Judul Konten</th>
                    <th scope="row">ISI</th>
                    <th scope="row">Jenis</th>
                    <th scope="row">tanggal</th>
                    <th scope="row">Status</th>
                    <th scope="row">Action</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                @if ($dataKontenList->total())
                    @foreach ($dataKontenList as $item)
                    <tr>
                        <td scope="col">{{ $item->judul }} </td>
                        <td scope="col">-{!! strip_tags(substr($item->isi,0,100)) !!}-</td>
                        <td scope="col">-{{ $item->jenis }}-</td>
                        <td scope="col">{{ date('d/m/Y', strtotime($item->tanggal)) }}</td>
                        <td scope="col"> <?php $is_aktif = ($item->aktif== 1) ? 'Aktif' : 'Tidak Aktif'; ?>
								{{ str_replace('_', ' ', strtoupper($is_aktif )) }}
						</td>
                        <td scope="col">
                            <x-button.button-link text="Detail" class="btn-success"
                                link="{{ route('Konten.show', $item->id) }}" />
                            <x-button.button-link text="Edit" class="btn-info"
                                link="{{ route('Konten.edit', $item->id) }}" />
                            @if((auth()->guard('admin')->user()->id ?? NULL) != $item->id)
                            <x-button text="Delete" class="btn-danger" modalTarget="#modal-delete-{{ $item->id }}" />
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <x-table.tr.empty-row colCount="6" />
                @endif
            </x-slot>
        </x-table>
        <div class="d-flex flex-row justify-content-center mt-3">
            {{ $dataKontenList->links() }}
        </div>
    </x-cards.regular-card>
</section>

<script type="text/javascript">
  
  $('#tabelkujos2').dataTable( {
	  "searching": true
  } );
  
  $(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#tabelkujos thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#tabelkujos thead');
    
	
    
	var table = $('#tabelkujos').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();
 
            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    
 					console.log('tanggal' + title);
					if (title == 'tanggal')
						$(cell).html('<input type="date" placeholder="' + title + '" />');
					else 
						$(cell).html('<input type="text" placeholder="' + title + '" />');
                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('change', function (e) {
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();
 
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
                        })
                        .on('keyup', function (e) {
                            e.stopPropagation();
 
                            $(this).trigger('change');
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },
    });
	$("#tabelkujos tfoot th:nth-child(3) input[type='date']").datepicker();
});
</script>

@endsection


@foreach ($dataKontenList as $item)
<x-modal.modal-delete modalId="modal-delete-{{ $item->id }}" title="Delete Konten"
    formLink="{{ route('Konten.destroy', ['id' => $item->id]) }}" />
@endforeach

