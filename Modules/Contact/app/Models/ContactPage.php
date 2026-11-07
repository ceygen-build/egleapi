<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPage extends Model
{
    use HasFactory;

    protected $table = 'contact_page';

    protected $fillable = [
        'hero_tag',
        'hero_title',
        'hero_subtitle',
        'hero_image',
        'stats',
        'form_label',
        'form_title',
        'form_desc',
        'direct_phone',
        'direct_email',
        'business_hours',
        'departments',
        'offices',
    ];

    protected $casts = [
        'stats' => 'array',
        'departments' => 'array',
        'offices' => 'array',
    ];
}

