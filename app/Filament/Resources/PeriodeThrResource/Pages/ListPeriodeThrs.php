<?php

namespace App\Filament\Resources\PeriodeThrResource\Pages;

use App\Filament\Resources\PeriodeThrResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeriodeThrs extends ListRecords
{
    protected static string $resource = PeriodeThrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
