<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_record_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_record_id')->constrained('data_records')->cascadeOnDelete();
            $table->foreignId('data_field_id')->constrained('data_fields')->cascadeOnDelete();
            $table->longText('value')->nullable(); // Store all values as text
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_record_values');
    }
};