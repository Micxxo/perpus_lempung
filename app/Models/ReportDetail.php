<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportDetail extends Model
{
    protected $fillable = ['report_id', 'data_id', 'data_type'];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
