@extends('layouts.superadmin')
@section('title', 'Field dari ' . $dataType->name)
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold">Field: {{ $dataType->name }}</h2>
        <p class="text-gray-500">Slug: {{ $dataType->slug }}</p>
    </div>
    <div class="space-x-2">
        <a href="{{ route('superadmin.data-types.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
        <button onclick="document.getElementById('addFieldModal').classList.remove('hidden')" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i>Tambah Field
        </button>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b bg-gray-50">
        <p class="text-sm text-gray-500">Drag & drop untuk mengatur urutan field (urutan ini akan digunakan di form dan tabel)</p>
    </div>
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left py-3 px-4">#</th>
                <th class="text-left py-3 px-4">Label</th>
                <th class="text-left py-3 px-4">Nama Field</th>
                <th class="text-left py-3 px-4">Tipe Data</th>
                <th class="text-left py-3 px-4">Required</th>
                <th class="text-left py-3 px-4">Tabel</th>
                <th class="text-left py-3 px-4">Search</th>
                <th class="text-left py-3 px-4">Filter</th>
                <th class="text-left py-3 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody id="fieldsList">
            @foreach($fields as $field)
            <tr class="border-t" data-id="{{ $field->id }}">
                <td class="py-3 px-4 text-gray-500">{{ $loop->iteration }}</td>
                <td class="py-3 px-4 font-medium">{{ $field->label }}</td>
                <td class="py-3 px-4"><code class="bg-gray-100 px-2 py-1 rounded text-sm">{{ $field->name }}</code></td>
                <td class="py-3 px-4">
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $field->type === 'text' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $field->type === 'textarea' ? 'bg-purple-100 text-purple-700' : '' }}
                        {{ $field->type === 'number' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $field->type === 'email' ? 'bg-pink-100 text-pink-700' : '' }}
                        {{ $field->type === 'url' ? 'bg-indigo-100 text-indigo-700' : '' }}
                        {{ $field->type === 'date' ? 'bg-orange-100 text-orange-700' : '' }}
                        {{ $field->type === 'dropdown' ? 'bg-teal-100 text-teal-700' : '' }}
                        {{ $field->type === 'image' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $field->type === 'file' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ $field->type }}
                    </span>
                </td>
                <td class="py-3 px-4">
                    @if($field->required) <i class="fas fa-check text-green-600"></i> @else <i class="fas fa-times text-gray-400"></i> @endif
                </td>
                <td class="py-3 px-4">
                    @if($field->show_in_table) <i class="fas fa-check text-green-600"></i> @else <i class="fas fa-times text-gray-400"></i> @endif
                </td>
                <td class="py-3 px-4">
                    @if($field->is_searchable) <i class="fas fa-check text-green-600"></i> @else <i class="fas fa-times text-gray-400"></i> @endif
                </td>
                <td class="py-3 px-4">
                    @if($field->is_filterable) <i class="fas fa-check text-green-600"></i> @else <i class="fas fa-times text-gray-400"></i> @endif
                </td>
                <td class="py-3 px-4">
                    <div class="flex space-x-2">
                        <button onclick="editField({{ $field->id }}, '{{ $field->label }}', '{{ $field->name }}', '{{ $field->type }}', {{ $field->required ? 'true' : 'false' }}, {{ $field->show_in_table ? 'true' : 'false' }}, {{ $field->is_searchable ? 'true' : 'false' }}, {{ $field->is_filterable ? 'true' : 'false' }}, {{ json_encode($field->options) }})" class="text-yellow-600 hover:text-yellow-800">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('superadmin.data-types.fields.destroy', [$dataType, $field]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus field ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            @if($fields->isEmpty())
            <tr>
                <td colspan="9" class="py-8 text-center text-gray-400">Belum ada field. Klik "Tambah Field" untuk menambahkan.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Add Field Modal -->
<div id="addFieldModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4 p-6">
        <h3 class="text-lg font-semibold mb-4">Tambah Field Baru</h3>
        <form action="{{ route('superadmin.data-types.fields.store', $dataType) }}" method="POST">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Label *</label>
                    <input type="text" name="label" required class="w-full border rounded px-3 py-2" placeholder="Judul Berita">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Field (auto slug)</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2" placeholder="judul_berita">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipe Data *</label>
                    <select name="type" required class="w-full border rounded px-3 py-2" onchange="toggleOptions(this)">
                        <option value="text">Text (Input text pendek)</option>
                        <option value="textarea">Textarea (Text panjang)</option>
                        <option value="number">Number</option>
                        <option value="email">Email</option>
                        <option value="url">URL</option>
                        <option value="date">Date</option>
                        <option value="dropdown">Select/Dropdown</option>
                        <option value="image">Image (Upload gambar)</option>
                        <option value="file">File (Upload file)</option>
                    </select>
                </div>
                <div id="optionsContainer" class="hidden">
                    <label class="block text-sm font-medium text-gray-700">Opsi Dropdown</label>
                    <textarea name="options" rows="4" class="w-full border rounded px-3 py-2" placeholder="Opsi 1&#10;Opsi 2&#10;Opsi 3"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Isi satu pilihan per baris.</p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="required" value="1" class="rounded border-gray-300 text-green-600">
                        <span class="text-sm">Required</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="show_in_table" value="1" checked class="rounded border-gray-300 text-green-600">
                        <span class="text-sm">Tampil di Tabel</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_searchable" value="1" checked class="rounded border-gray-300 text-green-600">
                        <span class="text-sm">Searchable</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_filterable" value="1" class="rounded border-gray-300 text-green-600">
                        <span class="text-sm">Filterable</span>
                    </label>
                </div>
            </div>
            <div class="flex space-x-3 mt-6">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Simpan</button>
                <button type="button" onclick="document.getElementById('addFieldModal').classList.add('hidden')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Field Modal -->
<div id="editFieldModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4 p-6">
        <h3 class="text-lg font-semibold mb-4">Edit Field</h3>
        <form id="editFieldForm" method="POST">
            @csrf @method('PUT')
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Label *</label>
                    <input type="text" name="label" id="editLabel" required class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Field</label>
                    <input type="text" name="name" id="editName" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipe Data *</label>
                    <select name="type" id="editType" required class="w-full border rounded px-3 py-2" onchange="toggleEditOptions(this)">
                        <option value="text">Text</option>
                        <option value="textarea">Textarea</option>
                        <option value="number">Number</option>
                        <option value="email">Email</option>
                        <option value="url">URL</option>
                        <option value="date">Date</option>
                        <option value="dropdown">Select/Dropdown</option>
                        <option value="image">Image</option>
                        <option value="file">File</option>
                    </select>
                </div>
                <div id="editOptionsContainer" class="hidden">
                    <label class="block text-sm font-medium text-gray-700">Opsi Dropdown</label>
                    <textarea name="options" id="editOptions" rows="4" class="w-full border rounded px-3 py-2" placeholder="Opsi 1&#10;Opsi 2&#10;Opsi 3"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Isi satu pilihan per baris.</p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="required" id="editRequired" value="1" class="rounded border-gray-300 text-green-600">
                        <span class="text-sm">Required</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="show_in_table" id="editShowInTable" value="1" class="rounded border-gray-300 text-green-600">
                        <span class="text-sm">Tampil di Tabel</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_searchable" id="editIsSearchable" value="1" class="rounded border-gray-300 text-green-600">
                        <span class="text-sm">Searchable</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_filterable" id="editIsFilterable" value="1" class="rounded border-gray-300 text-green-600">
                        <span class="text-sm">Filterable</span>
                    </label>
                </div>
            </div>
            <div class="flex space-x-3 mt-6">
                <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">Update</button>
                <button type="button" onclick="document.getElementById('editFieldModal').classList.add('hidden')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">Batal</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function toggleOptions(select) {
    document.getElementById('optionsContainer').classList.toggle('hidden', select.value !== 'dropdown');
}
function toggleEditOptions(select) {
    document.getElementById('editOptionsContainer').classList.toggle('hidden', select.value !== 'dropdown');
}
function editField(id, label, name, type, required, showInTable, isSearchable, isFilterable, options) {
    const modal = document.getElementById('editFieldModal');
    modal.classList.remove('hidden');
    document.getElementById('editFieldForm').action = '{{ route("superadmin.data-types.fields.update", [$dataType, "__ID__"]) }}'.replace('__ID__', id);
    document.getElementById('editLabel').value = label;
    document.getElementById('editName').value = name;
    document.getElementById('editType').value = type;
    document.getElementById('editRequired').checked = required;
    document.getElementById('editShowInTable').checked = showInTable;
    document.getElementById('editIsSearchable').checked = isSearchable;
    document.getElementById('editIsFilterable').checked = isFilterable;
    const optionsContainer = document.getElementById('editOptionsContainer');
    if (type === 'dropdown') {
        optionsContainer.classList.remove('hidden');
        // Gabungkan array options dengan newline, bukan koma
        document.getElementById('editOptions').value = options ? options.join('\n') : '';
    } else {
        optionsContainer.classList.add('hidden');
    }
}
</script>
@endpush
@endsection