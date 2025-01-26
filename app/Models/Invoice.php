<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function fine()
    {
        return $this->belongsTo(Fine::class);
    }
}
