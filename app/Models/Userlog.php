<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'login_time',
        'created_at'
    ];
    protected $casts = [
        'created_at' => 'datetime'
    ];
}
