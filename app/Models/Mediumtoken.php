<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mediumtoken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'medium_user_id',
        'username',
        'name',
        'url',
        'image_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }   
}
