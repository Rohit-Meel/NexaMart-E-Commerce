<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'button_text',
        'button_url',
        'sort_order',
        'status',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'status' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];
}