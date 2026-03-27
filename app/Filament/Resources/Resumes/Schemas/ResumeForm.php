<?php

namespace App\Filament\Resources\Resumes\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;
use App\Services\ResumeParserService;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ResumeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('label')
                    ->label('Resume Title (e.g., Full Stack Developer)')
                    ->required(),
                    
                Toggle::make('is_active')
                    ->label('Set as Default Resume')
                    ->default(false)
                    ->inline(false),
                    
                FileUpload::make('file_url')
                    ->label('Upload Resume (PDF)')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('cloudinary')
                    ->directory('grit_resumes')
                    ->getUploadedFileNameForStorageUsing(
                        // Generates a unique filename without nested folders
                        fn ($file): string => 'resume-' . Str::random(9) . '-' . time() . '.' . $file->getClientOriginalExtension()
                    )
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state instanceof TemporaryUploadedFile) {
                            $parser = new ResumeParserService();
                            $text = $parser->parse($state->getRealPath());
                            $set('content_raw', $text);
                        }
                    })
                    ->required()
                    ->columnSpanFull(),
                    
                Textarea::make('content_raw')
                    ->label('Parsed Resume Text (Edit to fix any missing details)')
                    ->rows(15) 
                    ->dehydrated(true)
                    ->columnSpanFull()
                    ->nullable(),
            ]);
    }
}