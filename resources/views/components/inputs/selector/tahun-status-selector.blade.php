@props([
    'value' => '',
    'name' => 'status'
])

<div class="form-group">
    <label>Status</label>
    <select class="form-control" name="{{ $name }}">
        <option>Pilih Status</option>
        <option value="aktif" {{ ($value ? $value : old($name)) == 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="tidak_aktif" {{ ($value ? $value : old($name)) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
    </select>
</div>