<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionalHub extends Model
{
    use HasFactory;

    protected $table = 'regional_hubs';

    protected $fillable = [
        'name',
        'phone',
        'address',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];
}
