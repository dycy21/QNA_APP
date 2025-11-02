<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Property extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'address'];
    
    // One Property can have many Guests
    public function guests()
    {
        return $this->hasMany(Guest::class);
    }
    
    // One Property can have one Check-in Question
    public function question()
    {
        return $this->hasOne(Question::class);
    }
    
    
}
