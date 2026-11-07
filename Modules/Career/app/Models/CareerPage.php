<?php

namespace Modules\Career\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'hero_tag',
    'hero_title',
    'hero_subtitle',
    'hero_image',
    'why_join_label',
    'why_join_title',
    'why_join_subtitle',
    'perks',
    'internship',
    'application_heading',
    'application_subheading',
])]
class CareerPage extends Model
{
    use HasFactory;

    protected $table = 'career_page';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'perks' => 'array',
        'internship' => 'array',
    ];
}

