@props([
    'name' => 'fakultas_id',
    'label' => 'Jenis Fakultas',
    'isRequired' => false,
    'data' => [],
    'value' => '',
    'withDescription' => true
])

<div class="form-group">
    @if ($label)
        <label for="{{ $name }}">{{ $label }}</label>
    @endif

    <select class="form-control" name="{{ $name }}" id="{{ $name }}" required="{{ $isRequired }}">
        <option>Pilih {{ $value }} {{ strtolower($label) }}</option>
        @isset($data)
            @foreach ($data as $item)
                <option value="{{ $item->id }}" {{ $item->id == ($value ? $value : old($name)) ? 'selected' : '' }}>
                    {{ $item->nama }} - {{ $item->kode }}
                </option>
            @endforeach
        @endisset
    </select>

    <div class="d-flex flex-col">
        @if ($withDescription)
            <small>
                Tambah data baru melalui <a target="_blank" href="{{ route('fakultas.create') }}">data master - fakultas</a>.
            </small>
        @endif

        @if ($slot)
            {{ $slot }}
        @endif

        @error($name)
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>