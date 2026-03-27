<?php

namespace App\Filament\Resources\MatchReports\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Grouping\Group;

class MatchReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('jobPosting.title')
                    ->label('Job Title')
                    ->searchable(),
                
                TextColumn::make('score')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        $state >= 85 => 'success',
                        $state >= 70 => 'warning',
                        default => 'danger',
                    }),

                // Use a simple array instead of the Enum
                SelectColumn::make('status')
                    ->options([
                        'matched' => '1. Matched',
                        'applied' => '2. Applied',
                        'interviewing' => '3. Interviewing',
                        'offered' => '4. Offer Received',
                        'hired' => '5. Hired',
                        'rejected' => 'Rejected',
                    ])
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultGroup(
                Group::make('status')
                    ->titlePrefixedWithLabel(false)
            );
    }
}