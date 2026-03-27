<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resume_id',
        'job_id',
        'score',
        'missing_keywords',
        'reasoning',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'missing_keywords' => 'array',
        ];
    }

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class, 'resume_id');
    }

    public function jobPosting(): BelongsTo
    {
        return $this->belongsTo(JobPosting::class, 'job_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
