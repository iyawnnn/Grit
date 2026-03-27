<?php

namespace App\Filament\Resources\JobPostings\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Grid;

class JobPostingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Job Title')
                    ->required(),
                    
                TextInput::make('company')
                    ->label('Company Name')
                    ->required(),

                TextInput::make('source_url')
                    ->label('Job URL (Optional - For your reference only)')
                    ->url()
                    ->nullable(),
                    
                // This is the new field where you will paste the text
                RichEditor::make('description')
                    ->label('Job Description (Highlight and paste the text from LinkedIn here)')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'bulletList',
                        'orderedList',
                        'undo',
                        'redo',
                    ])
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}