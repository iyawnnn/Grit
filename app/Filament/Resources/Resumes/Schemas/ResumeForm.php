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
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('local') 
                    ->directory('resumes')
                    ->visibility('private') 
                    ->getUploadedFileNameForStorageUsing(
                        fn ($file): string => (string) str($file->getClientOriginalName())
                            ->prepend(now()->timestamp . '_' . str()->random(8) . '_')
                    )
                    ->required(),
                    
                \Filament\Forms\Components\Textarea::make('content_raw')
                    ->readOnly()
                    ->columnSpanFull()
                    ->nullable(),
                    
                \Filament\Forms\Components\Toggle::make('is_active')->default(false),
            ]);
    }
}