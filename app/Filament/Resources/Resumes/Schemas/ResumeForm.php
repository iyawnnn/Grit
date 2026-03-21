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
                \Filament\Forms\Components\FileUpload::make('file_url')->required(),
                \Filament\Forms\Components\Textarea::make('content_raw')->nullable(),
                \Filament\Forms\Components\Toggle::make('is_active')->default(false),
            ]);
    }
}
