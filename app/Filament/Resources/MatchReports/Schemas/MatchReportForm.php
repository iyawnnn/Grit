<?php

namespace App\Filament\Resources\MatchReports\Schemas;

use Filament\Schemas\Schema;

class MatchReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('resume_id')
                    ->relationship('resume', 'label')
                    ->required(),
                \Filament\Forms\Components\Select::make('job_id')
                    ->relationship('jobPosting', 'title')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('score')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Calculated after saving...'),
                \Filament\Forms\Components\TagsInput::make('missing_keywords')
                    ->separator(','),
            ]);
    }
}
