<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterviewSlot extends Model
{
    protected $fillable = [
        'interview_date',
        'interview_time',
        'is_active',
        'booked_applicant_id',
    ];

    protected $casts = [
        'interview_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function bookedApplicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class, 'booked_applicant_id');
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->whereNull('booked_applicant_id')
            ->whereDate('interview_date', '>=', now()->toDateString());
    }
}
