<?php

namespace Modules\Career\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'type',
    'name',
])]
class CareerOption extends Model
{
    use HasFactory;

    protected $table = 'career_options';
}
