<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataField extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_type_id',
        'label',
        'name',
        'type',
        'options',
        'required',
        'is_searchable',
        'is_filterable',
        'is_sortable',
        'show_in_table',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
        'is_searchable' => 'boolean',
        'is_filterable' => 'boolean',
        'is_sortable' => 'boolean',
        'show_in_table' => 'boolean',
    ];

    public function dataType()
    {
        return $this->belongsTo(DataType::class);
    }

    public function values()
    {
        return $this->hasMany(DataRecordValue::class, 'data_field_id');
    }

    public function getFieldTypeLabelAttribute(): string
    {
        $labels = [
            'text' => 'Teks Pendek',
            'number' => 'Angka',
            'textarea' => 'Teks Panjang',
            'date' => 'Tanggal',
            'image' => 'Gambar',
            'file' => 'File',
            'dropdown' => 'Dropdown',
            'select' => 'Dropdown',
            'email' => 'Email',
            'url' => 'URL',
        ];
        return $labels[$this->type] ?? $this->type;
    }

}
