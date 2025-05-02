<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Periode;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Imports\PeriodeImporter;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Actions\Periodes\DownloadZip;
use App\Filament\Resources\PeriodeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PeriodeResource\RelationManagers;
use App\Filament\Resources\PeriodeResource\RelationManagers\SalariesRelationManager;

class PeriodeResource extends Resource
{
    protected static ?string $model = Periode::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('month')
                ->label('Bulan')
                ->options([
                    'januari' => 'Januari',
                    'februari' => 'Februari',
                    'maret' => 'Maret',
                    'april' => 'April',
                    'mei' => 'Mei',
                    'juni' => 'Juni',
                    'agustus' => 'Agustus',
                    'september' => 'September',
                    'oktober' => 'Oktober',
                    'november' => 'November',
                    'desember' => 'Desember',
                ])
                ->searchable(),
                Select::make('year')
                ->label('Tahun')
                ->options([
                    '2025' => '2025',
                    '2026' => '2026',
                    '2027' => '2027',
                    '2028' => '2028',
                ]),
                Checkbox::make('isComplete')
                ->visibleOn('edit'),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('id periode')->color('danger'),
                TextColumn::make('month')
                ->label('Bulan')
                ->formatStateUsing(fn (string $state): string => Str::ucfirst($state)),
                TextColumn::make('year')
                ->label('Tahun'),
                TextColumn::make('salaries_count')
                ->label('Jumlah Karyawan')->counts('salaries'),
                TextColumn::make('total_gaji_bersih') // Tambahkan kolom ini
                    ->label('Total Gaji Bersih')
                    ->getStateUsing(function (Periode $record) {
                        return 'Rp ' . number_format($record->salaries()->sum('gaji_bersih'), 0, ',', '.');
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                DownloadZip::make(),
            ])
            ->headerActions([
                ImportAction::make()->importer(PeriodeImporter::class)->label('Imports')->icon('heroicon-m-arrow-down-on-square-stack')
                ->color('success')
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
            SalariesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeriodes::route('/'),
            'create' => Pages\CreatePeriode::route('/create'),
            'edit' => Pages\EditPeriode::route('/{record}/edit'),
        ];
    }
}
