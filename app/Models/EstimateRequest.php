<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateRequest extends Model
{
    use HasFactory;

    protected $table = 'estimate_requests';

    protected $fillable = [
        'phone',
        'email',
        'city_departure',
        'delivery_city',
        'weight',
        'length',
        'width',
        'height',
        'status',
        'quoted_amount',
        'admin_notes',
    ];

    protected $casts = [
        'quoted_amount' => 'decimal:2',
    ];
}

