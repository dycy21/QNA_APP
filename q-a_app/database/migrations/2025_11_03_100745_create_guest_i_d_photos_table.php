<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guest_i_d_photos', function (Blueprint $table) {
            $table->id();
            // We use the correct column name 'guest_id' but point to the problematic table name
            $table->foreignId('guest_id')->constrained()->onDelete('cascade'); 
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_i_d_photos');
    }
};
