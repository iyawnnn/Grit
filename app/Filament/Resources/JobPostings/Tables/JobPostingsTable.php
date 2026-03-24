<?php

namespace App\Filament\Resources\JobPostings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class JobPostingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\Layout\Stack::make([
                    \Filament\Tables\Columns\TextColumn::make('title')
                        ->weight('bold')
                        ->size('lg'),

                    \Filament\Tables\Columns\TextColumn::make('company')
                        ->color('gray'),

                    \Filament\Tables\Columns\TextColumn::make('latestMatchScore')
                        ->badge()
                        ->state(function (\App\Models\JobPosting $record) {
                            return $record->matchReports()->latest()->first()?->score;
                        })
                        ->formatStateUsing(fn($state) => $state ? $state . '% Match' : 'No Report')
                        ->color(fn($state) => $state >= 80 ? 'success' : ($state >= 50 ? 'warning' : 'danger')),

                    \Filament\Tables\Columns\TextColumn::make('status')
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'Bookmarked' => 'gray',
                            'Applied' => 'info',
                            'Interviewing' => 'warning',
                            'Offered' => 'success',
                            'Rejected' => 'danger',
                            default => 'primary',
                        }),
                ])->space(3),
            ])
            // The magic that creates the Grid/Board
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            // The magic that groups them like a Kanban board
            ->defaultGroup('status')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
