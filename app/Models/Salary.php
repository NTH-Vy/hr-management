<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salary';
    protected $fillable = [
    'user_id',
    'month',
    'base_salary',
    'bonus',
    'deduction',
    'total_hours',
    'total_salary',
    'status',
    'payment_date'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}