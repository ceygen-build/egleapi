<?php

namespace Modules\Blog\Models;

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
class BlogPage extends Model
{
    use HasFactory;

    protected $table = 'blog_pages';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'stats' => 'array',
        'sections_data' => 'array',
    ];
}

