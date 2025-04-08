<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'employee_code', 'name', 'email', 'password', 'phone', 
        'address', 'birthday', 'gender', 'position_id', 
        'start_date', 'status', 'role'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'birthday' => 'date',
        'start_date' => 'date',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function rewardsDisciplines()
    {
        return $this->hasMany(RewardDiscipline::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}