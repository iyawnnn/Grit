<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\MatchReport;
use App\Models\Resume;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MatchReportFactory extends Factory
{
    protected $model = MatchReport::class;

    public function definition(): array
    {
        return [
            'user_id'          => User::factory(),
            'resume_id'        => Resume::factory(),
            'job_id'           => JobPosting::factory(),
            'score'            => fake()->numberBetween(0, 100),
            'missing_keywords' => ['React', 'Docker'],
            'reasoning'        => fake()->sentence(),
            'status'           => 'processing',
        ];
    }
}
