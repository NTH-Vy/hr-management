<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['username', 'password', 'full_name', 'email', 'role', 'position_id'];
    protected $hidden = ['password'];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class, 'user_id');
    }

    public function rewardsDisciplines()
    {
        return $this->hasMany(RewardsDiscipline::class, 'user_id');
    }
}