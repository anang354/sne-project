<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periode extends Model
{
    protected $guarded = ['id'];

    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class);
    }
}
