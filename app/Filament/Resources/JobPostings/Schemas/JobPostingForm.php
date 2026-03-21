<?php

namespace App\Filament\Resources\JobPostings\Schemas;

use Filament\Schemas\Schema;

class JobPostingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('title')->required(),
                \Filament\Forms\Components\TextInput::make('company')->required(),
                \Filament\Forms\Components\Textarea::make('description')->required(),
                \Filament\Forms\Components\TextInput::make('source_url')->url()->required(),
                \Filament\Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'closed' => 'Closed',
                    ])
                    ->default('draft')
                    ->required(),
            ]);
    }
}
