<?php

namespace Modules\About\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'year',
    'title',
    'description',
    'sort_order',
])]
class AboutTimeline extends Model
{
    use HasFactory;

    protected $table = 'about_timeline';
}
