<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['report_type', 'start_date', 'end_date'];
    protected $table = 'reports';

    public function details()
    {
        return $this->hasMany(ReportDetail::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
