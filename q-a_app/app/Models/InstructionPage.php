<?php
// app/Models/InstructionPage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructionPage extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'description'];

    // An InstructionPage can have many steps
    public function steps()
    {
        // Order the steps by their 'order' column
        return $this->hasMany(Step::class)->orderBy('order'); 
    }
}