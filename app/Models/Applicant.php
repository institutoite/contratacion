<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Applicant extends Model
{
    public const STATUSES = [
        'Nuevo',
        'Pendiente de entrevista',
        'Entrevistado',
        'En evaluacion',
        'Aprobado',
        'Rechazado',
        'En base de datos para futuras vacantes',
    ];

    public const WORK_MODALITIES = [
        'tiempo completo',
        'medio tiempo',
        'por horas',
    ];

    protected $fillable = [
        'position_id',
        'full_name',
        'identity_number',
        'birth_date',
        'age',
        'address',
        'city_zone',
        'primary_phone',
        'whatsapp',
        'email',
        'reference_name',
        'reference_phone',
        'reference_relationship',
        'application_date',
        'work_modality',
        'availability_schedule',
        'availability_immediate',
        'salary_expectation',
        'vacancy_source',
        'has_experience',
        'experience_years',
        'experience_summary',
        'education_level',
        'educational_institution',
        'courses_certifications',
        'main_skills',
        'portfolio_link',
        'status',
        'overall_rating',
        'strengths',
        'weaknesses',
        'internal_notes',
        'recommended',
        'last_interview_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'application_date' => 'date',
        'availability_immediate' => 'boolean',
        'has_experience' => 'boolean',
        'salary_expectation' => 'decimal:2',
        'experience_years' => 'decimal:1',
        'recommended' => 'boolean',
        'last_interview_at' => 'datetime',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function interviews(): HasMany
    {
        return $this->hasMany(ApplicantInterview::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ApplicantAttachment::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(ApplicantHistory::class);
    }
}
