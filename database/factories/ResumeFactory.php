<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResumeFactory extends Factory
{
    protected $model = Resume::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'label' => fake()->sentence(3),
            'file_url' => 'https://res.cloudinary.com/test/upload/v1/grit_uploads/'.fake()->uuid().'.pdf',
            'content_raw' => fake()->paragraphs(3, true),
            'is_active' => true,
        ];
    }
}
