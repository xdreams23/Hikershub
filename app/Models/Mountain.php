<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mountain extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'altitude',
        'difficulty_level',
        'description',
        'image',
        'facilities',
    ];

    // Relationships
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    // Accessors
    public function getFormattedAltitudeAttribute()
    {
        return number_format($this->altitude, 0, ',', '.') . ' MDPL';
    }

    public function getDifficultyBadgeAttribute()
    {
        return match($this->difficulty_level) {
            'easy' => '<span class="badge bg-success">Easy</span>',
            'medium' => '<span class="badge bg-info">Medium</span>',
            'hard' => '<span class="badge bg-warning">Hard</span>',
            'extreme' => '<span class="badge bg-danger">Extreme</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    // Scopes
    public function scopeByDifficulty($query, $level)
    {
        return $query->where('difficulty_level', $level);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%");
        });
    }
}