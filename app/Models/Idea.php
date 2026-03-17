<?php

namespace App\Models;

use App\Enums\IdeaStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Idea extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'team_id',
        'title',
        'description',
        'category',
        'impact_level',
        'status',
        'reviewed_at',
        'submitted_at',
        'review_remark',
        'reviewed_by',
    ];

    protected $casts = [
        'status' => IdeaStatus::class,
        'submitted_at' => 'datetime',
    ];

    public  function user()
    {
        return $this->belongsTo(User::class);
    }
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function attachments()
    {
        return $this->hasMany(IdeaAttachment::class);
        
    }
    
}
