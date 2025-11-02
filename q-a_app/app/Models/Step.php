<?php
// app/Models/Step.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Step extends Model
{
    use HasFactory;

    protected $fillable = [
        'instruction_page_id', 
        'order', 
        'heading', 
        'content', 
        'image_path'
    ];
    
    // Step belongs to one InstructionPage
    public function instructionPage()
    {
        return $this->belongsTo(InstructionPage::class);
    }
    
    // Accessor to easily get the public URL for the image
    public function getImageUrlAttribute()
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }
}