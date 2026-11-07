<?php

namespace Modules\Faq\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'question',
    'answer',
])]
class FaqItem extends Model
{
    use HasFactory;

    protected $table = 'faqs';
}
