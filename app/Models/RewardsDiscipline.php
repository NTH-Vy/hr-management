<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardsDiscipline extends Model
{
    protected $table = 'rewards_disciplines';
    protected $fillable = ['user_id', 'type', 'amount', 'reason', 'date', 'issued_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}