<?php

namespace App\Filament\Resources\PeriodeResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Storage;
use App\Filament\Imports\SalaryImporter;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Actions\Salaries\GenerateSlip;
use App\Filament\Actions\Salaries\SendEmailAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SalariesRelationManager extends RelationManager
{
    protected static string $relationship = 'salaries';
    protected static array $defaultPaginationPageOptions = [25,50,100];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('gaji_pokok')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('tunj_jabatan')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('tunj_bahasa')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('tunj_kerajinan')
                ->label('Tunjangan Keahlian')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('tunj_lainnya')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('total_gaji')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('lembur')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('uang_makan')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('potongan_hari')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('potongan_absensi')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('denda')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('bpjs_tk')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('bpjs_ks')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('pph21')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('total_potongan')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('rapel')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('gaji_bersih')
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
            ->recordTitleAttribute('nama')
            ->columns([
                Tables\Columns\TextColumn::make('nik')->toggleable()->searchable(),
                Tables\Columns\TextColumn::make('nama')->searchable(),
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
                Tables\Columns\TextColumn::make('posisi')->toggleable(),
                Tables\Columns\TextColumn::make('gaji_bersih')
                    ->formatStateUsing(function ($state) {
                        return 'Rp ' . number_format($state, 0, ',', '.');
                    }),
                Tables\Columns\TextColumn::make('nomor_surat')->toggleable(),
                Tables\Columns\BooleanColumn::make('isPdf'),
                Tables\Columns\BooleanColumn::make('isEmail'),
            ])
            ->filters([
                Filter::make('Pdf Not Generate')->query(
                    function($query) {
                        return $query->where('isPdf', false);
                    } 
                ),
                Filter::make('Email Not Sent')->query(
                    function($query) {
                        return $query->where('isEmail', false);
                    } 
                ),
                SelectFilter::make('departemen')->options([
                    'Administrative' => 'Aministrative',
                    'Quality' => 'Quality',
                ])->multiple()
            ])
            ->headerActions([
                ImportAction::make()->importer(SalaryImporter::class)
                ->label('Imports')->icon('heroicon-m-arrow-up-tray')
                ->color('cyan')
            ])
            ->actions([
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\EditAction::make()->color('secondary'),
                Tables\Actions\Action::make('viewPdf')->label('Lihat Slip')->icon('heroicon-o-document')->color('success')
                ->url(function ($record): ?string {
                    if ($record->isPdf) {
                        return Storage::disk('public')->url($record->file);
                    }
                    return null;
                })
                ->visible(fn ($record): bool => $record->isPdf)
                ->openUrlInNewTab(),
                SendEmailAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    GenerateSlip::make(),
                ]),
            ]);
    }
}
