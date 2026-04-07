<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use App\Services\ResumeParserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ResumeUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_resume_upload_stores_record_with_mocked_cloudinary(): void
    {
        $user = User::factory()->create();

        $mockParser = $this->mock(ResumeParserService::class);
        $mockParser->shouldReceive('processUpload')
            ->once()
            ->andReturn([
                'file_url' => 'https://res.cloudinary.com/test/upload/v1/grit_uploads/mock-resume.pdf',
                'content_raw' => 'Experienced Laravel developer with PHP and MySQL skills.',
            ]);

        $file = UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf');

        $response = $this->actingAs($user)
            ->post(route('resumes.store'), [
                'label' => 'My Test Resume',
                'file' => $file,
            ]);

        $response->assertRedirect(route('resumes.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('resumes', [
            'user_id' => $user->id,
            'label' => 'My Test Resume',
            'file_url' => 'https://res.cloudinary.com/test/upload/v1/grit_uploads/mock-resume.pdf',
            'content_raw' => 'Experienced Laravel developer with PHP and MySQL skills.',
            'is_primary' => false,
        ]);
    }

    public function test_resume_upload_requires_a_label(): void
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf');

        $response = $this->actingAs($user)
            ->post(route('resumes.store'), [
                'file' => $file,
            ]);

        $response->assertSessionHasErrors('label');
    }

    public function test_resume_upload_requires_a_pdf_file(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('resumes.store'), [
                'label' => 'My Resume',
            ]);

        $response->assertSessionHasErrors('file');
    }

    public function test_resume_upload_rejects_non_pdf_files(): void
    {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('document.docx', 100, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $response = $this->actingAs($user)
            ->post(route('resumes.store'), [
                'label' => 'My Resume',
                'file' => $file,
            ]);

        $response->assertSessionHasErrors('file');
    }
}
