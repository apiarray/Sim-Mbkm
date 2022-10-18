@props([
    'name' => 'tahun_ajaran_id',
    'label' => 'Tahun Ajaran',
    'column' => '',
    'isRequired' => false,
    'data' => [],
    'value' => '',
    'withDescription' => true,
    'descriptionRoute' => ''
])

<div class="form-group">
    @if ($label)
        <label for="{{ $name }}">{{ $label }}</label>
    @endif

    <select class="form-control" name="{{ $name }}" id="{{ $name }}" required="{{ $isRequired }}">
        <option value="">Pilih {{ $value }} {{ strtolower($label) }}</option>
        @isset($data)
            @foreach ($data as $item)
                <option value="{{ $item->id }}" {{ $item->id == ($value ? $value : old($name)) ? 'selected' : '' }}>
                    @if($column != '')
                    {{ $item->{$column} }}
                    @else 
                    {{ $item->tahun_ajaran . ' / ' . $item->semester->nama }}
                    @endif
                </option>
            @endforeach
        @endisset
    </select>

    <div class="d-flex flex-col">
        @if ($withDescription && $descriptionRoute)
            <small>
                Tambah data baru melalui <a target="_blank" href="{{ route($descriptionRoute) }}">data master - {{ $label }}</a>.
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