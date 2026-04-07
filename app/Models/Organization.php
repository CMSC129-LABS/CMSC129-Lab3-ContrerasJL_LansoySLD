<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'status',
        'email',
        'members',
        'logo',
        'cover',
        'is_archived',
        'archived_at',
    ];

    protected $casts = [
        'archived_at' => 'datetime',
        'is_archived' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }
        public function getDaysLeftAttribute()
    {
        return $this->archived_at 
            ? max(0, 30 - (int) $this->archived_at->diffInDays(now())) 
            : null;
    }
    

}
