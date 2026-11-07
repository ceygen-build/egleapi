<?php

namespace Modules\Service\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'slug',
    'title',
    'subtitle',
    'description',
    'icon_name',
    'category',
    'image',
    'overview',
    'key_benefits',
    'capabilities',
    'process',
    'specifications',
])]
class ServiceItem extends Model
{
    use HasFactory;

    protected $table = 'services';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'key_benefits' => 'array',
            'capabilities' => 'array',
            'process' => 'array',
            'specifications' => 'array',
        ];
    }
}
