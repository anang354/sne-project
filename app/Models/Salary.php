<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salary extends Model
{
    protected $guarded = ['id'];

    public function periode() : BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }
    const DEPARTEMEN = [
        'Administrative' => 'Administrative',
        'Finance' => 'Finance',
        'Quality' => 'Quality',
        'Equipment' => 'Equipment',
        'Production' => 'Production',
        'Technology' => 'Technology',
        'Warehouse Planning' => 'Warehouse Planning',
        'Customs' => 'Customs',
        'Purchase' => 'Purchase',
    ];
}
