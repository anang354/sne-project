<?php

namespace App\Filament\Imports;

use App\Models\ThrSalary;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ThrSalaryImporter extends Importer
{
    protected static ?string $model = ThrSalary::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('periode_thr_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('nip')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('departemen')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('position')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('religion')
                ->requiredMapping()
                ->rules(['max:255']),
            ImportColumn::make('join_date')
                ->requiredMapping()
                ->rules(['max:255', 'date']),
            ImportColumn::make('masa_kerja')
                ->requiredMapping()
                ->rules(['max:255']),
            ImportColumn::make('pph21')
                ->requiredMapping()
                ->rules(['max:255', 'nullable']),
            ImportColumn::make('thp')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('terbilang')
                ->requiredMapping()
                ->rules(['max:255']),
            ImportColumn::make('nomor_surat')
                ->requiredMapping()
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?ThrSalary
    {
        // return ThrSalary::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new ThrSalary();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your thr salary import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
