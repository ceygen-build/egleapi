<?php

namespace Modules\Career\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'vacancy_id',
    'job_title',
    'candidate_name',
    'candidate_email',
    'candidate_phone',
    'cover_letter',
    'cv_url',
    'applied_date',
])]
class JobApplication extends Model
{
    use HasFactory;

    protected $table = 'job_applications';

    /**
     * Get the vacancy this application belongs to.
     */
    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class, 'vacancy_id', 'id');
    }
}
