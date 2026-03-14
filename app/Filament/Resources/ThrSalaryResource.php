<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ThrSalaryResource\Pages;
use App\Filament\Resources\ThrSalaryResource\RelationManagers;
use App\Models\ThrSalary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ThrSalaryResource extends Resource
{
    protected static ?string $model = ThrSalary::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'THR';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListThrSalaries::route('/'),
            'create' => Pages\CreateThrSalary::route('/create'),
            'edit' => Pages\EditThrSalary::route('/{record}/edit'),
        ];
    }
}
