<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['property_id', 'text'];

    // Question belongs to a Property
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Question has many Answers
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}