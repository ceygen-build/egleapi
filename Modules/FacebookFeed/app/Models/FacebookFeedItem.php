<?php

namespace Modules\FacebookFeed\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'id',
    'caption',
    'fb_image_url',
    'status',
    'posted_at',
])]
class FacebookFeedItem extends Model
{
    use HasFactory;

    protected $table = 'facebook_feed_items';

    public $incrementing = false;
    protected $keyType = 'string';
}
