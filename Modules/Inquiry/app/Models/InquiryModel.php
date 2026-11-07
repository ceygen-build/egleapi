<?php

namespace Modules\Inquiry\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'name',
    'email',
    'phone',
    'subject',
    'message',
    'status',
    'date',
])]
class InquiryModel extends Model
{
    use HasFactory;

    protected $table = 'inquiries';
}
