<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Idea;

class Team extends Model
{
    protected $fillable = ['name', 'team_lead_id', 'image'];

    public function leader()
    {
        return $this->belongsTo(User::class, 'team_lead_id');
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/default-team.png');
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
