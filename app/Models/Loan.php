<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model
{
    protected $fillable = [
        'book_id',
        'member_id',
        'borrowing_date',
        'return_date',
        'created_at',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function fines()
    {
        return $this->hasMany(Fine::class, 'loan_id', 'id');
    }

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('d - m - Y');
    }

    public function getFormattedReturnDateAttribute()
    {
        return Carbon::parse($this->return_date)->format('d - m - Y');
    }
}
