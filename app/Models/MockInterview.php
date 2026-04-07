<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MockInterview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_posting_id',
        'resume_id',
        'questions',
    ];

    protected $casts = [
        'questions' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobPosting(): BelongsTo
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }
}
