@extends('layouts.admin')
@section('title', 'Tambah Data ' . $dataType->name)
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Tambah Data {{ $dataType->name }}</h2>
    <a href="{{ route('admin.data-types.records.index', $dataType) }}" class="text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-1"></i>Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-3xl">
    <form action="{{ route('admin.data-types.records.store', $dataType) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4">
            @foreach($fields as $field)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $field->label }}
                    @if($field->required) <span class="text-red-500">*</span> @endif
                </label>

                @if($field->type === 'text')
                    <input type="text" name="fields[{{ $field->name }}]" value="{{ old('fields.'.$field->name) }}"
                           {{ $field->required ? 'required' : '' }}
                           class="w-full border rounded px-3 py-2" placeholder="Masukkan {{ $field->label }}">
                
                @elseif($field->type === 'textarea')
                    <textarea name="fields[{{ $field->name }}]" rows="4"
                              {{ $field->required ? 'required' : '' }}
                              class="w-full border rounded px-3 py-2" placeholder="Masukkan {{ $field->label }}">{{ old('fields.'.$field->name) }}</textarea>
                
                @elseif($field->type === 'number')
                    <input type="number" name="fields[{{ $field->name }}]" value="{{ old('fields.'.$field->name) }}"
                           {{ $field->required ? 'required' : '' }}
                           class="w-full border rounded px-3 py-2" placeholder="Masukkan {{ $field->label }}">
                
                @elseif($field->type === 'date')
                    <input type="date" name="fields[{{ $field->name }}]" value="{{ old('fields.'.$field->name) }}"
                           {{ $field->required ? 'required' : '' }}
                           class="w-full border rounded px-3 py-2">
                
                @elseif($field->type === 'dropdown')
                    <select name="fields[{{ $field->name }}]" {{ $field->required ? 'required' : '' }} class="w-full border rounded px-3 py-2">
                        <option value="">Pilih {{ $field->label }}</option>
                        @foreach((is_array($field->options) ? $field->options : json_decode($field->options, true) ?? []) as $option)
                            <option value="{{ $option }}" {{ old('fields.'.$field->name) === $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                
                @elseif($field->type === 'image')
                    <input type="file" name="fields[{{ $field->name }}]" accept="image/*"
                           {{ $field->required ? 'required' : '' }}
                           class="w-full border rounded px-3 py-2">
                    <p class="text-xs text-gray-400 mt-1">Format: jpg, jpeg, png, gif. Max: 2MB</p>
                
                @elseif($field->type === 'file')
                    <input type="file" name="fields[{{ $field->name }}]"
                           {{ $field->required ? 'required' : '' }}
                           class="w-full border rounded px-3 py-2">
                    <p class="text-xs text-gray-400 mt-1">Max: 10MB</p>
                
                @elseif($field->type === 'email')
                    <input type="email" name="fields[{{ $field->name }}]" value="{{ old('fields.'.$field->name) }}"
                           {{ $field->required ? 'required' : '' }}
                           class="w-full border rounded px-3 py-2" placeholder="email@example.com">
                
                @elseif($field->type === 'url')
                    <input type="url" name="fields[{{ $field->name }}]" value="{{ old('fields.'.$field->name) }}"
                           {{ $field->required ? 'required' : '' }}
                           class="w-full border rounded px-3 py-2" placeholder="https://">
                @endif

                @error('fields.'.$field->name)
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            @endforeach
        </div>

        <div class="flex space-x-3 mt-6 pt-4 border-t">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-save mr-2"></i>Simpan Data
            </button>
            <a href="{{ route('admin.data-types.records.index', $dataType) }}" class="bg-gray-300 px-6 py-2 rounded-lg hover:bg-gray-400">Batal</a>
        </div>
    </form>
</div>
@endsection