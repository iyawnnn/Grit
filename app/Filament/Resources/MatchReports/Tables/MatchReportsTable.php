<?php

namespace App\Filament\Resources\MatchReports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class MatchReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('score')
                    ->badge()
                    ->color(fn (string|int|null $state): string => match (true) {
                        (int) $state >= 80 => 'success',
                        (int) $state >= 50 => '#D97706',
                        default => 'danger',
                    })
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('missing_keywords')
                    ->badge()
                    ->searchable(),
            ])
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
