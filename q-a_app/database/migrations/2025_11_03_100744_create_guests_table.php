<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->string('magic_link_token')->unique(); 
            $table->boolean('info_updated')->default(false); 
            
            // Including the answer_id here to prevent the ALTER TABLE error
            $table->foreignId('answer_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};