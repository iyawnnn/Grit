<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\JobPosting;
use App\Models\User;
use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobPostingFactory extends Factory
{
    protected $model = JobPosting::class;

    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'title'       => fake()->jobTitle(),
            'company'     => fake()->company(),
            'description' => fake()->paragraphs(3, true),
            'source_url'  => fake()->url(),
            'status'      => ApplicationStatus::Saved->value,
        ];
    }
}