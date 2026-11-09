<?php

namespace Modules\Analytics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteVisitor extends Model
{
    use HasFactory;

    protected $table = 'site_visitors';

    protected $fillable = [
        'session_id',
        'ip_address',
        'country',
        'country_code',
        'city',
        'region',
        'page_url',
        'page_title',
        'referrer',
        'device_type',
        'browser',
        'os',
        'screen_resolution',
        'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

