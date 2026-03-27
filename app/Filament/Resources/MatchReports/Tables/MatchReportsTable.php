<?php

namespace App\Filament\Resources\MatchReports\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Grouping\Group;
use App\Enums\ApplicationStatus;

use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class MatchReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('jobPosting.title')
                    ->label('Job Title')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('score')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        $state >= 85 => 'success',
                        $state >= 70 => 'warning',
                        default => 'danger',
                    })
                    ->sortable(),

                SelectColumn::make('status')
                    ->options(ApplicationStatus::class)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultGroup(
                Group::make('status')
                    ->titlePrefixedWithLabel(false)
            )
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    // Explicitly maps the edit button to your MatchReport resource
                    ->url(fn (\App\Models\MatchReport $record): string => \App\Filament\Resources\MatchReports\MatchReportResource::getUrl('edit', ['record' => $record])),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}