<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeriodeThrResource\Pages;
use App\Filament\Resources\PeriodeThrResource\RelationManagers;
use App\Filament\Resources\PeriodeThrResource\RelationManagers\ThrSalariesRelationManager;
use App\Models\PeriodeThr;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use RelationManagers\SalariesRelationManager;

class PeriodeThrResource extends Resource
{
    protected static ?string $model = PeriodeThr::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'THR';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('year')
                    ->required()
                    ->options(PeriodeThr::YEAR_OPTIONS),
                Forms\Components\TextInput::make('message')
                    ->maxLength(255),
                Forms\Components\Toggle::make('isComplete')
                    ->label('Is Complete')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                PeriodeThr::query()->withCount('thrSalaries')
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('year')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('isComplete')
                    ->boolean()
                    ->label('Complete')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_thr_amount')
                    ->label('Total THR')
                    ->getStateUsing(function (PeriodeThr $record) {
                        return 'Rp ' . number_format($record->thrSalaries()->sum('thp'), 0, ',', '.');
                    }),
                Tables\Columns\TextColumn::make('thr_salaries_count')
                    ->label('Jumlah Penerima THR')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ThrSalariesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeriodeThrs::route('/'),
            'create' => Pages\CreatePeriodeThr::route('/create'),
            'edit' => Pages\EditPeriodeThr::route('/{record}/edit'),
        ];
    }
}
