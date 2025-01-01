<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function scopeFilter(Builder $query): void
    {
        $query->where('name', 'like', '%' . request('search') . '%');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
