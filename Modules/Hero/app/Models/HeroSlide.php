<?php

namespace Modules\Hero\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'is_active',
    'target_page',
    'is_multiple',
    'image',
    'title',
    'subtitle',
    'description',
    'images',
    'cta_label',
    'cta_href',
    'stat_value',
    'stat_label',
    'category',
    'sub_slides',
])]
class HeroSlide extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_multiple' => 'boolean',
            'images' => 'array',
            'sub_slides' => 'array',
        ];
    }
}
