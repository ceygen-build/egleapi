<?php

namespace Modules\Service\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'title',
    'description',
    'image',
    'icon',
    'featured',
    'sort_order',
    'link',
    'is_active',
])]
class ServiceFeature extends Model
{
    use HasFactory;

    protected $table = 'service_features';

    protected $fillable = [
        'title',
        'description',
        'image',
        'icon',
        'featured',
        'sort_order',
        'link',
        'is_active',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
