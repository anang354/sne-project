<?php

namespace App\Filament\Widgets;

use App\Models\Periode;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class EmployeeStatsWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 1;
    protected function getStats(): array
    {
        $latestPeriod = Periode::latest()->first();
        $latestEmployee = $latestPeriod->salaries()->count();

        $previousPeriod = Periode::where('id', '<', $latestPeriod->id)
        ->latest()
        ->first();
        if($previousPeriod) {
            $previousEmployee = $previousPeriod->salaries()->count();
            $difference = $latestEmployee - $previousEmployee;
            $percentage = ($previousEmployee != 0) ? ($difference / $previousEmployee) * 100 : ($difference > 0 ? 100 : 0);

            if ($difference > 0) {
                $description = number_format($percentage, 0) . '% increase';
                $heroIcon = "heroicon-m-arrow-trending-up";
                $color = "success";
            } elseif ($difference < 0) {
                $description = number_format(abs($percentage), 0) . '% decrease';
                $heroIcon = "heroicon-m-arrow-trending-down";
                $color = "danger";
            } else {
                $description = ' (Tidak ada perubahan)';
                $heroIcon = "heroicon-m-arrow-long-right";
                $color = "info";
            }
        }

        return [
            Stat::make('Total Karyawan', $latestEmployee)
            ->description($description)
            ->descriptionIcon($heroIcon)
            ->chart([$previousEmployee, $latestEmployee])
            ->color($color),
        ];
    }
    
}
