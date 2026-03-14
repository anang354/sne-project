<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThrSalary extends Model
{
    //
    protected $guarded = ['id'];

    public function periodeThr(): BelongsTo
    {
        return $this->belongsTo(PeriodeThr::class, 'periode_thr_id');
    }
    const DEPARTEMEN = [
        'Administrative' => 'Administrative',
        'Finance' => 'Finance',
        'Quality Control' => 'Quality Control',
        'Equipment' => 'Equipment',
        'Production' => 'Production',
        'Technology' => 'Technology',
        'Warehouse' => 'Warehouse',
        'Customs' => 'Customs',
        'Purchase' => 'Purchase',
    ];
}
