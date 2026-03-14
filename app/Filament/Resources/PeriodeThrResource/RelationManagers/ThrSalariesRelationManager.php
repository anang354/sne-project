<?php

namespace App\Filament\Resources\PeriodeThrResource\RelationManagers;

use App\Filament\Imports\ThrSalaryImporter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class ThrSalariesRelationManager extends RelationManager
{
    protected static string $relationship = 'thrSalaries';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nip')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('thp')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pph21')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('terbilang')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('nip'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\BadgeColumn::make('departemen')
                ->colors([
                    'primary',
                    'success' => static fn ($state) : bool => $state === 'Administrative',
                    'danger' => static fn ($state) : bool => $state === 'Equipment',
                    'violet' => static fn ($state) : bool => $state === 'Finance',
                    'cyan' => static fn ($state) : bool => $state === 'Technology',
                    'lime' => static fn ($state) : bool => $state === 'Warehouse Planning',
                    'pink' => static fn ($state) : bool => $state === 'Quality',
                    'info' => static fn ($state) : bool => $state === 'Production',
                ])
                ->icons([
                    'heroicon-o-tag',
                    'heroicon-o-document-text' => 'Administrative',
                    'heroicon-o-wrench-screwdriver' => 'Equipment',
                    'heroicon-o-currency-yen' => 'Finance',
                    'heroicon-o-computer-desktop' => 'Technology',
                    'heroicon-o-building-storefront' => 'Warehouse Planning',
                    'heroicon-o-beaker' => 'Quality',
                    'heroicon-o-users' => 'Production',
                ])
                ->toggleable(),
                Tables\Columns\TextColumn::make('religion'),
                Tables\Columns\TextColumn::make('join_date')->date(),
                Tables\Columns\TextColumn::make('masa_kerja'),
                Tables\Columns\TextColumn::make('thp')
                    ->formatStateUsing(function ($state) {
                        return 'Rp ' . number_format($state, 0, ',', '.');
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                ImportAction::make()->importer(ThrSalaryImporter::class)
                ->label('Imports')->icon('heroicon-m-arrow-down-on-square-stack')
                ->color('success')  
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('lihatPdf')
                ->label('Lihat Slip')
                ->icon('heroicon-o-document-text')
                ->color('success')
                ->url(function ($record): ?string {
                    if($record->is_pdf && $record->file) {
                        return Storage::disk('public')->url($record->file);
                    }
                    return null;
                })
                ->visible(fn ($record): bool => $record->is_pdf)
                ->openUrlInNewTab(),
                \App\Filament\Actions\ThrSalaries\SendEmailAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    \App\Filament\Actions\ThrSalaries\GenerateSlip::make(),
                ]),
            ]);
    }
}
