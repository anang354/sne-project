<?php

namespace App\Filament\Resources;

use App\Filament\Actions\Periodes\DownloadZip;
use App\Filament\Imports\PeriodeImporter;
use App\Filament\Resources\PeriodeResource\Pages;
use App\Filament\Resources\PeriodeResource\RelationManagers;
use App\Filament\Resources\PeriodeResource\RelationManagers\SalariesRelationManager;
use App\Models\Periode;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PeriodeResource extends Resource
{
    protected static ?string $model = Periode::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Periode Gaji';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->label('ID Periode')
                    ->disabledOn('edit')
                    ->visibleOn('edit')
                    ->maxLength(255),
                Select::make('month')
                ->label('Bulan')
                ->options([
                    'januari' => 'Januari',
                    'februari' => 'Februari',
                    'maret' => 'Maret',
                    'april' => 'April',
                    'mei' => 'Mei',
                    'juni' => 'Juni',
                    'juli' => 'Juli',
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
                // TextColumn::make('id')->label('id periode')->color('danger'),
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
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                 ->color('info')
                 ->icon('heroicon-o-eye')
                 ->label('Lihat Detail'),
                Tables\Actions\DeleteAction::make(),
                DownloadZip::make(),
            ])
            ->headerActions([
                ImportAction::make()->importer(PeriodeImporter::class)->label('Imports')->icon('heroicon-m-arrow-down-on-square-stack')
                ->color('success')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()->isAdmin()),
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
