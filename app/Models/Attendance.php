<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $fillable = ['user_id', 'check_in', 'check_out', 'total_hours', 'date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}