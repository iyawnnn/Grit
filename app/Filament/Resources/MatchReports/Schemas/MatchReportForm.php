<?php

namespace App\Filament\Resources\MatchReports\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TagsInput;

class MatchReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('resume_id')
                    ->relationship('resume', 'label')
                    ->required(),
                
                Select::make('job_posting_id') // Fixed from job_id to match your database
                    ->relationship('jobPosting', 'title')
                    ->required(),
                
                TextInput::make('score')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Calculated by AI after saving...'),
                
                TagsInput::make('missing_keywords')
                    ->separator(',')
                    ->disabled() // Keeps the AI's findings read-only
                    ->placeholder('Identified by AI after saving...'),
                    
                Textarea::make('reasoning')
                    ->label('AI Analysis & Reasoning')
                    ->disabled()
                    ->columnSpanFull()
                    ->placeholder('The AI will explain your match score here after you click Create.'),
            ]);
    }
}