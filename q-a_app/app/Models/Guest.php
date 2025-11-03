<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GuestIDPhoto;

class Guest extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'property_id', 
        'name', 
        'email', 
        'phone', 
        'check_in_date', 
        'check_out_date', 
        'magic_link_token',
        'info_updated',
        'answer_id',
    ];
    
    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'info_updated' => 'boolean',
    ];


    // Guest belongs to one Property
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    
    // Guest can have one ID Photo
    public function idPhoto()
    {
        return $this->hasOne(GuestIDPhoto::class);
    }
    
    // Guest has one Answer once they complete the flow
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

}