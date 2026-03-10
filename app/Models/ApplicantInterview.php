<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantInterview extends Model
{
    protected $fillable = [
        'applicant_id',
        'interview_date',
        'interview_time',
        'interviewer_name',
        'result',
        'rating',
        'strengths',
        'weaknesses',
        'notes',
        'recommended',
        'status_after_interview',
    ];

    protected $casts = [
        'interview_date' => 'date',
        'recommended' => 'boolean',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }
}
