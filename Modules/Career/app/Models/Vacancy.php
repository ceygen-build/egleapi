<?php

namespace Modules\Career\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'id',
    'title',
    'department',
    'location',
    'type',
    'experience',
    'description',
])]
class Vacancy extends Model
{
    use HasFactory;

    protected $table = 'vacancies';

    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Get applications for the vacancy.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'vacancy_id', 'id');
    }
}
