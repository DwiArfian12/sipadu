<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Berita UNY", "Mahasiswa"
            $table->string('slug')->unique(); // e.g., "berita-uny", "mahasiswa"
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_types');
    }
};