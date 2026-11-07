<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'id',
    'title',
    'category',
    'date',
    'time',
    'location',
    'city',
    'image',
    'description',
    'speakers',
    'status',
])]
class EventItem extends Model
{
    use HasFactory;

    protected $table = 'events';

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
            'speakers' => 'array',
        ];
    }

    /**
     * Get registrations for the event.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'event_id', 'id');
    }
}
