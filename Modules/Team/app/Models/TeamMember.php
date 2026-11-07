<?php

namespace Modules\Team\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'name',
    'role',
    'group',
    'image',
    'order_index',
    'show_on_home',
    'bio',
    'linkedin',
    'twitter',
    'email',
    'education',
])]
class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'group',
        'image',
        'order_index',
        'show_on_home',
        'bio',
        'linkedin',
        'twitter',
        'email',
        'education',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'education' => 'array',
            'order_index' => 'integer',
            'show_on_home' => 'boolean',
        ];
    }
}
