<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantAttachment extends Model
{
    protected $fillable = [
        'applicant_id',
        'type',
        'original_name',
        'stored_path',
        'mime_type',
        'size_bytes',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }
}
