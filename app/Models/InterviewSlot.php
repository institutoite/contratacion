<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class InterviewSlot extends Model
{
    protected $fillable = [
        'interview_date',
        'interview_time',
        'is_active',
    ];

    protected $casts = [
        'interview_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function scopeAvailable(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->whereDate('interview_date', '>=', now()->toDateString());
    }
}
