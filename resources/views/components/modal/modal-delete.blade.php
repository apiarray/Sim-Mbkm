@props([
    'modalId' => '',
    'formLink' => '',
    'title' => '',
    'message' => 'Apa anda yakin ingin menghapus data ini?'
])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ $formLink }}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ $message }}
                </div>
                <div class="modal-footer">
                    <x-button text="Cancel" class="btn-light" dataDismiss="modal" />
                    <x-button text="Delete" class="btn-danger" type="submit" />
                </div>
            </form>
        </div>
    </div>
</div>