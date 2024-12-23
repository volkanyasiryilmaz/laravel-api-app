<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password',
        'machine_code',
        'name',
        'surname',
        'start_date',
        'end_date',
        'license_type',
        'addition_status',
        'status',
        'confirmed',
        'confirm_code',
        'credit',
        'credits_enable',
        'created_at'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'created_at' => 'datetime',
        'status' => 'boolean',
        'confirmed' => 'boolean',
        'credits_enable' => 'boolean',
        'addition_status' => 'boolean'
    ];
}
