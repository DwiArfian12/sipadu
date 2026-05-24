@extends('layouts.superadmin')
@section('title', 'Tambah Data ' . $dataType->name)
@section('content')
<div class="mb-6">
    <a href="{{ route('superadmin.data-types.records.index', $dataType) }}" class="text-green-600 hover:text-green-800">
        <i class="fas fa-arrow-left mr-1"></i>Kembali
    </a>
    <h2 class="text-2xl font-bold mt-2">Tambah Data {{ $dataType->name }}</h2>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('superadmin.data-types.records.store', $dataType) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($fields as $field)
            <div class="{{ $field->type === 'textarea' ? 'md:col-span-2' : '' }}">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $field->label }}
                    @if($field->required) <span class="text-red-500">*</span> @endif
                </label>

                @if($field->type === 'text' || $field->type === 'number' || $field->type === 'email' || $field->type === 'url')
                    <input type="{{ $field->type }}" name="fields[{{ $field->name }}]" value="{{ old('fields.'.$field->name) }}"
                           class="w-full border rounded px-3 py-2 @error('fields.'.$field->name) border-red-500 @enderror">
                @elseif($field->type === 'textarea')
                    <textarea name="fields[{{ $field->name }}]" rows="5"
                              class="w-full border rounded px-3 py-2 @error('fields.'.$field->name) border-red-500 @enderror">{{ old('fields.'.$field->name) }}</textarea>
                @elseif($field->type === 'date')
                    <input type="date" name="fields[{{ $field->name }}]" value="{{ old('fields.'.$field->name) }}"
                           class="w-full border rounded px-3 py-2 @error('fields.'.$field->name) border-red-500 @enderror">
                @elseif($field->type === 'datetime')
                    <input type="datetime-local" name="fields[{{ $field->name }}]" value="{{ old('fields.'.$field->name) }}"
                           class="w-full border rounded px-3 py-2 @error('fields.'.$field->name) border-red-500 @enderror">
                @elseif($field->type === 'dropdown')
                    <select name="fields[{{ $field->name }}]" class="w-full border rounded px-3 py-2 @error('fields.'.$field->name) border-red-500 @enderror">
                        <option value="">Pilih</option>
                        @foreach((is_array($field->options) ? $field->options : json_decode($field->options, true) ?? []) as $opt)
                            <option value="{{ $opt }}" {{ old('fields.'.$field->name) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                @elseif($field->type === 'image')
                    <input type="file" name="fields[{{ $field->name }}]" accept="image/*"
                           class="w-full border rounded px-3 py-2 @error('fields.'.$field->name) border-red-500 @enderror">
                @elseif($field->type === 'file')
                    <input type="file" name="fields[{{ $field->name }}]"
                           class="w-full border rounded px-3 py-2 @error('fields.'.$field->name) border-red-500 @enderror">
                @else
                    <input type="text" name="fields[{{ $field->name }}]" value="{{ old('fields.'.$field->name) }}"
                           class="w-full border rounded px-3 py-2 @error('fields.'.$field->name) border-red-500 @enderror">
                @endif

                @error('fields.'.$field->name)
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-save mr-2"></i>Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection