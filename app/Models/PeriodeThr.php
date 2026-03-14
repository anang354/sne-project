<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodeThr extends Model
{
    protected $guarded = ['id'];

    const YEAR_OPTIONS = [
        2023 => '2023',
        2024 => '2024',
        2025 => '2025',
        2026 => '2026',
        2027 => '2027',
        2028 => '2028',
        2029 => '2029',
        2030 => '2030',
    ];
    public function thrSalaries(): HasMany
    {
        return $this->hasMany(ThrSalary::class, 'periode_thr_id');
    }
    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtoupper($value)
        );
    }
    protected function message(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => ucwords($value)
        );
    }
}
