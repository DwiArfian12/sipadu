<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_type_id')->constrained('data_types')->cascadeOnDelete();
            $table->string('label'); // Field label e.g., "Judul", "NIM", "Author"
            $table->string('name'); // Field name e.g., "judul", "nim", "author"
            $table->string('type'); // text, number, textarea, date, image, file, dropdown, email, url
            $table->json('options')->nullable(); // For dropdown: ["option1", "option2"]
            $table->boolean('required')->default(false);
            $table->boolean('is_searchable')->default(false); // For table search
            $table->boolean('is_filterable')->default(false); // For table filter
            $table->boolean('is_sortable')->default(true); // For table sort
            $table->boolean('show_in_table')->default(true); // Show in table listing
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_fields');
    }
};