<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DataType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'created_by',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($dataType) {
            if (empty($dataType->slug)) {
                $dataType->slug = Str::slug($dataType->name);
            }
        });
    }

    public function fields()
    {
        return $this->hasMany(DataField::class)->orderBy('order');
    }

    public function records()
    {
        return $this->hasMany(DataRecord::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'data_type_user');
    }
}