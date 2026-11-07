<?php

namespace Modules\Contact\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'phone',
    'email',
    'sales_email',
    'careers_email',
    'address',
    'india_address',
    'maldives_address',
    'map_iframe_url',
])]
class ContactDetails extends Model
{
    use HasFactory;

    protected $table = 'contact_details';
}
