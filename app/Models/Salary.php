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
}
