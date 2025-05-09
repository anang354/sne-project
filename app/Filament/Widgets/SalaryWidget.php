<?php

namespace App\Filament\Widgets;

use App\Models\Periode;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SalaryWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 6;
    protected function getStats(): array
    {
        $latestPeriod = Periode::latest()->first();
        
        $latestSalaryCount = $latestPeriod->salaries()->sum('gaji_bersih');
        $latestSalary = "Rp. ".number_format($latestSalaryCount, 0, ',', '.');

        $previousPeriod = Periode::where('id', '<', $latestPeriod->id)
        ->latest()
        ->first();
        if($previousPeriod) {
            $previousSalaryCount = $previousPeriod->salaries()->sum('gaji_bersih');
            $difference = $latestSalaryCount - $previousSalaryCount;
            $percentage = ($previousSalaryCount != 0) ? ($difference / $previousSalaryCount) * 100 : ($difference > 0 ? 100 : 0);

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

        $latestEmployee = $latestPeriod->salaries()->count();

        if($previousPeriod) {
            $previousEmployee = $previousPeriod->salaries()->count();
            $differenceEmp = $latestEmployee - $previousEmployee;
            $percentageEmp = ($previousEmployee != 0) ? ($differenceEmp / $previousEmployee) * 100 : ($differenceEmp > 0 ? 100 : 0);

            if ($differenceEmp > 0) {
                $descriptionEmp = number_format($percentageEmp, 0) . '% increase';
                $heroIconEmp = "heroicon-m-arrow-trending-up";
                $colorEmp = "success";
            } elseif ($differenceEmp < 0) {
                $descriptionEmp = number_format(abs($percentageEmp), 0) . '% decrease';
                $heroIconEmp = "heroicon-m-arrow-trending-down";
                $colorEmp = "danger";
            } else {
                $descriptionEmp = ' (Tidak ada perubahan)';
                $heroIconEmp = "heroicon-m-arrow-long-right";
                $colorEmp = "info";
            }
        }
        

        return [
            Stat::make('Gaji Bersih', $latestSalary)
            ->description($description)
            ->descriptionIcon($heroIcon)
            ->chart([$previousSalaryCount, $latestSalaryCount])
            ->color($color),
            Stat::make('Total Karyawan', $latestEmployee)
            ->description($descriptionEmp)
            ->descriptionIcon($heroIconEmp)
            ->chart([$previousEmployee, $latestEmployee])
            ->color($colorEmp),
        ];
    }
    
}
