<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    protected $table = 'industries';

    protected $fillable = [
        'name',
        'short',
        'description',
        'image',
        'icon_name',
        'stats',
        'color',
        'bg_color',
        'services',
        'sort_order',
        'is_active',
        'link',
    ];

    protected $casts = [
        'services' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
