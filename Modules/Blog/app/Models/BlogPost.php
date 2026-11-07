<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'id',
    'title',
    'excerpt',
    'category',
    'author',
    'author_role',
    'author_avatar',
    'date',
    'read_time',
    'image',
    'featured',
    'content',
    'key_takeaways',
    'tags',
])]
class BlogPost extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'content' => 'array',
            'key_takeaways' => 'array',
            'tags' => 'array',
        ];
    }
}
