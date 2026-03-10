<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantHistory extends Model
{
    protected $fillable = [
        'applicant_id',
        'action',
        'performed_by',
        'note',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }
}
