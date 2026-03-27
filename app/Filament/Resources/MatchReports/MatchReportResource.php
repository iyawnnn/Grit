<?php

namespace App\Filament\Resources\MatchReports;

use App\Filament\Resources\MatchReports\Pages\CreateMatchReport;
use App\Filament\Resources\MatchReports\Pages\EditMatchReport;
use App\Filament\Resources\MatchReports\Pages\ListMatchReports;
use App\Filament\Resources\MatchReports\Pages\ViewMatchReport;
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

// FIXED: Section is now a global Schema layout component
use Filament\Schemas\Components\Section; 
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;

class MatchReportResource extends Resource
{
    protected static ?string $model = MatchReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'score';

    public static function form(Schema $schema): Schema
    {
        return MatchReportForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('AI Match Analysis')
                    ->description('Detailed breakdown of your resume against the job description.')
                    ->schema([
                        ViewEntry::make('score')
                            ->view('infolists.components.circular-score')
                            ->columnSpanFull(),
                            
                        TextEntry::make('jobPosting.title')
                            ->label('Target Job')
                            ->weight('bold'),
                            
                        TextEntry::make('status')
                            ->badge(),
                            
                        TextEntry::make('reasoning')
                            ->label('AI Reasoning')
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id())
            ->with('jobPosting');
    }

    public static function table(Table $table): Table
    {
        return MatchReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMatchReports::route('/'),
            'create' => CreateMatchReport::route('/create'),
            'view' => ViewMatchReport::route('/{record}'),
            'edit' => EditMatchReport::route('/{record}/edit'),
        ];
    }
}  