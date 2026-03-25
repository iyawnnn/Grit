<?php

namespace App\Filament\Resources\Resumes\Schemas;

use Filament\Schemas\Schema;

class ResumeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('label')->required(),
                
                \Filament\Forms\Components\FileUpload::make('file_url')
                    ->label('Resume (PDF)')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('cloudinary')
                    ->directory('grit_uploads')
                    ->getUploadedFileNameForStorageUsing(
                        fn ($file): string => 'grit_uploads/resume-' . \Illuminate\Support\Str::random(9) . '-' . time() . '.' . $file->getClientOriginalExtension()
                    )
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                            $parser = new \App\Services\ResumeParserService();
                            $text = $parser->parse($state->getRealPath());
                            $set('content_raw', $text);
                        }
                    })
                    ->required(),
                    
                \Filament\Forms\Components\Textarea::make('content_raw')
                    ->readOnly()
                    ->dehydrated(true)
                    ->columnSpanFull()
                    ->nullable(),
                    
                \Filament\Forms\Components\Toggle::make('is_active')->default(false),
            ]);
    }
}