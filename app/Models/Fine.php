<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id', 'id');
    }
}
