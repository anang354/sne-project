<?php

namespace App\Filament\Resources\ThrSalaryResource\Pages;

use App\Filament\Resources\ThrSalaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListThrSalaries extends ListRecords
{
    protected static string $resource = ThrSalaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
