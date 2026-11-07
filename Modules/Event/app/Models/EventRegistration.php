<?php

namespace Modules\Event\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'event_id',
    'event_name',
    'name',
    'email',
    'company',
    'registered_date',
    'phone',
])]
class EventRegistration extends Model
{
    use HasFactory;

    protected $table = 'event_registrations';

    /**
     * Get the event this registration belongs to.
     */
    public function eventItem(): BelongsTo
    {
        return $this->belongsTo(EventItem::class, 'event_id', 'id');
    }
}
