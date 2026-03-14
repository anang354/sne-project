<?php

namespace App\Filament\Resources\PeriodeThrResource\Pages;

use App\Filament\Resources\PeriodeThrResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeriodeThr extends EditRecord
{
    protected static string $resource = PeriodeThrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
