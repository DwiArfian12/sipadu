<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_type_id',
        'created_by',
        'updated_by',
    ];

    public function dataType()
    {
        return $this->belongsTo(DataType::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function values()
    {
        return $this->hasMany(DataRecordValue::class, 'data_record_id');
    }

    // Get a key-value map of field_name => value for this record
    public function getDataAttribute(): array
    {
        return $this->values()->with('field')->get()->mapWithKeys(function ($v) {
            return [$v->field->name => $v->value];
        })->toArray();
    }

    // Get a single value by field name
    public function getValue(string $fieldName): ?string
    {
        $value = $this->values->first(function ($v) use ($fieldName) {
            return $v->field && $v->field->name === $fieldName;
        });
        return $value?->value;
    }
}
