<?php

namespace Modules\Service\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'slug',
    'page_name',
    'hero_tag',
    'hero_title',
    'hero_subtitle',
    'hero_image',
    'intro_label',
    'intro_title',
    'intro_description',
    'intro_image',
    'stats',
    'sections_data',
    'cta_title',
    'cta_desc',
    'cta_btn_text',
    'cta_btn_url',
])]
class ServicePage extends Model
{
    use HasFactory;

    protected $table = 'service_pages';

    protected $fillable = [
        'slug',
        'page_name',
        'hero_tag',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'intro_label',
        'intro_title',
        'intro_description',
        'intro_image',
        'stats',
        'sections_data',
        'cta_title',
        'cta_desc',
        'cta_btn_text',
        'cta_btn_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'stats' => 'array',
            'sections_data' => 'array',
        ];
    }
}

