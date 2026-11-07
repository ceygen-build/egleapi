<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HowItWorksStep extends Model
{
    use HasFactory;

    protected $table = 'how_it_works_steps';

    protected $fillable = [
        'step',
        'title',
        'description',
        'image',
        'image_only',
        'text_only',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'image_only' => 'boolean',
        'text_only' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}

