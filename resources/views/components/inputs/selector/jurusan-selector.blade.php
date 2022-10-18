@props([
    'name' => 'jurusan_id',
    'label' => 'Nama Jurusan',
    'isRequired' => false,
    'data' => [],
    'value' => '',
    'withDescription' => true
])

<div {{ $attributes->merge(['class' => 'form-group']) }}>
    @if ($label)
        <label for="{{ $name }}">{{ $label }}</label>
    @endif

    <select class="form-control" name="{{ $name }}" id="{{ $name }}" required="{{ $isRequired }}">
        <option>Pilih {{ $value }} {{ strtolower($label) }}</option>
        @isset($data)
            @foreach ($data as $item)
                <option value="{{ $item->id }}" {{ $item->id == ($value ? $value : old($name)) ? 'selected' : '' }}>{{ $item->fakultas->kode }} - {{ $item->nama }}</option>
            @endforeach
        @endisset
    </select>

    <div class="d-flex flex-col">
        @if ($withDescription)
            <small>
                Tambah data baru melalui <a target="_blank" href="{{ route('jurusan.create') }}">data master - jurusan</a>.
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