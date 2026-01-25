<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'service_id',
        'client_id',
        'staff_id',
        'start_at',
        'end_at',
        'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public static function hasStaffConflict(int $businessId, int $staffId, $startAt, $endAt, ?int $ignoreAppointmentId = null): bool
    {
        $query = static::query()
            ->where('business_id', $businessId)
            ->where('staff_id', $staffId)
            ->where('start_at', '<', $endAt)
            ->where('end_at', '>', $startAt);

        if ($ignoreAppointmentId) {
            $query->where('id', '!=', $ignoreAppointmentId);
        }

        return $query->exists();
    }
}
