@extends('layouts.superadmin')

@section('title', 'Edit Field - ' . $field->label)

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('superadmin.data-types.index') }}">Jenis Data</a></li>
        <li class="breadcrumb-item"><a href="{{ route('superadmin.data-types.fields.index', $dataType) }}">{{ $dataType->name }}</a></li>
        <li class="breadcrumb-item active">Edit Field</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Edit Field: {{ $field->label }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('superadmin.data-types.fields.update', [$dataType, $field]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="label" class="form-label">Label Field <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label" value="{{ old('label', $field->label) }}" required>
                    @error('label') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama Field (Slug)</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $field->name) }}">
                    <div class="form-text">Kosongkan untuk generate otomatis dari Label.</div>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="type" class="form-label">Tipe Data <span class="text-danger">*</span></label>
                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required onchange="toggleOptionsField()">
                        <option value="text" {{ old('type', $field->type) === 'text' ? 'selected' : '' }}>Text (Input Teks)</option>
                        <option value="number" {{ old('type', $field->type) === 'number' ? 'selected' : '' }}>Number (Angka)</option>
                        <option value="textarea" {{ old('type', $field->type) === 'textarea' ? 'selected' : '' }}>Textarea (Teks Panjang)</option>
                        <option value="date" {{ old('type', $field->type) === 'date' ? 'selected' : '' }}>Date (Tanggal)</option>
                        <option value="email" {{ old('type', $field->type) === 'email' ? 'selected' : '' }}>Email</option>
                        <option value="url" {{ old('type', $field->type) === 'url' ? 'selected' : '' }}>URL</option>
                        <option value="image" {{ old('type', $field->type) === 'image' ? 'selected' : '' }}>Image (Gambar)</option>
                        <option value="file" {{ old('type', $field->type) === 'file' ? 'selected' : '' }}>File</option>
                        <option value="dropdown" {{ old('type', $field->type) === 'dropdown' ? 'selected' : '' }}>Dropdown (Pilihan)</option>
                    </select>
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="order" class="form-label">Urutan</label>
                    <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $field->order) }}" min="0">
                    @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4 mb-3 d-flex align-items-center">
                    <div class="form-check form-switch me-3">
                        <input class="form-check-input" type="checkbox" id="required" name="required" value="1" {{ old('required', $field->required) ? 'checked' : '' }}>
                        <label class="form-check-label" for="required">Wajib Diisi</label>
                    </div>
                </div>
            </div>

            <div class="mb-3" id="optionsField" style="display: {{ old('type', $field->type) === 'dropdown' ? 'block' : 'none' }};">
                <label for="options" class="form-label">Pilihan Dropdown</label>
                <textarea class="form-control @error('options') is-invalid @enderror" id="options" name="options" rows="5" placeholder="Masukkan satu pilihan per baris">{{ old('options', is_array($field->options) ? implode("\n", $field->options) : $field->options) }}</textarea>
                <div class="form-text">Isi satu pilihan per baris.</div>
                @error('options') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <hr>
            <h6>Pengaturan Tabel</h6>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="show_in_table" name="show_in_table" value="1" {{ old('show_in_table', $field->show_in_table) ? 'checked' : '' }}>
                        <label class="form-check-label" for="show_in_table">Tampilkan di Tabel</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_searchable" name="is_searchable" value="1" {{ old('is_searchable', $field->is_searchable) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_searchable">Bisa Dicari (Search)</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_sortable" name="is_sortable" value="1" {{ old('is_sortable', $field->is_sortable) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_sortable">Bisa Diurutkan (Sort)</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_filterable" name="is_filterable" value="1" {{ old('is_filterable', $field->is_filterable) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_filterable">Bisa Difilter</label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('superadmin.data-types.fields.index', $dataType) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleOptionsField() {
        const type = document.getElementById('type').value;
        const optionsField = document.getElementById('optionsField');
        optionsField.style.display = (type === 'dropdown') ? 'block' : 'none';
    }
</script>
@endpush