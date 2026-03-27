<?php

namespace App\Filament\Resources\MatchReports;

use App\Filament\Resources\MatchReports\Pages\CreateMatchReport;
use App\Filament\Resources\MatchReports\Pages\EditMatchReport;
use App\Filament\Resources\MatchReports\Pages\ListMatchReports;
use App\Filament\Resources\MatchReports\Schemas\MatchReportForm;
use App\Filament\Resources\MatchReports\Tables\MatchReportsTable;
use App\Models\MatchReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth; 

class MatchReportResource extends Resource
{
    protected static ?string $model = MatchReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'score';

    public static function form(Schema $schema): Schema
    {
        return MatchReportForm::configure($schema);
    }

    public static function getEloquentQuery(): Builder
    {
        // Using Auth::id() fixes the IDE warning
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function table(Table $table): Table
    {
        return MatchReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMatchReports::route('/'),
            'create' => CreateMatchReport::route('/create'),
            'edit' => EditMatchReport::route('/{record}/edit'),
        ];
    }
}