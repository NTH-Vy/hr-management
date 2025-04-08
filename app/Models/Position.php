<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions';
    protected $fillable = ['name', 'base_salary', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}