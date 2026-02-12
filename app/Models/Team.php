<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Team extends Model
{
    protected $fillable = ['name', 'team_lead_id'];

    public function leader()
    {
        return $this->belongsTo(User::class, 'team_lead_id');
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }
}
