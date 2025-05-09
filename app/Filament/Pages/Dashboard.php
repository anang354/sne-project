<?php

namespace App\Filament\Pages;

use Filament\Widgets;
use App\Filament\Widgets\SalaryWidget;
use App\Filament\Widgets\PeriodeChartWidget;
use App\Filament\Widgets\EmployeeChartWidget;
use App\Filament\Widgets\EmployeeStatsWidget;


class Dashboard extends \Filament\Pages\Dashboard
{
    public function getWidgets(): array
    {
        return [
            Widgets\AccountWidget::class,
            Widgets\FilamentInfoWidget::class,
            SalaryWidget::class,
            PeriodeChartWidget::class,
            EmployeeChartWidget::class,
        ];
    }
    public function getColumns(): int | string | array
    {
        // Atau, Anda dapat menggunakan array untuk kontrol yang lebih canggih:
        return [
            'sm' => 1,
            'md' => 2, // Mengatur 2 kolom untuk layar medium ke atas
            'lg' => 2,
            'xl' => 2,
            '2xl' => 2,
        ];
    }
}