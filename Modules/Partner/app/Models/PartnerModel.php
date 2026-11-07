<?php

namespace Modules\Partner\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'name',
    'logo_path',
])]
class PartnerModel extends Model
{
    use HasFactory;

    protected $table = 'partners';
}
