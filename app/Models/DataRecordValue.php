<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRecordValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_record_id',
        'data_field_id',
        'value',
    ];

    public function record()
    {
        return $this->belongsTo(DataRecord::class, 'data_record_id');
    }

    public function field()
    {
        return $this->belongsTo(DataField::class, 'data_field_id');
    }
}