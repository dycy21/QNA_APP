<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestIDPhoto extends Model
{
    use HasFactory;

    protected $table = 'guest_i_d_photos';
    protected $fillable = ['guest_id', 'file_path'];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}