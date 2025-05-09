<?php

namespace App\Filament\Widgets;

use App\Models\Periode;
use Filament\Widgets\ChartWidget;

class EmployeeChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Total Karyawan';

    protected function getData(): array
    {
        $periodes = Periode::all();
        $months = [];
        $value = [];
        foreach($periodes as $periode) {
            array_push($value, $periode->salaries->count());
            array_push($months, $periode->month);
        }
        return [
            'datasets' => [
                [
                    'label' => 'Total Karyawan',
                    'data' => $value,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
