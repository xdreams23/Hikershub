<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'mountain_id',
        'title',
        'start_date',
        'end_date',
        'duration_days',
        'meeting_point',
        'price',
        'max_participants',
        'min_participants',
        'status',
        'itinerary',
        'include_items',
        'exclude_items',
        'terms_conditions',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
    ];

    // Relationships
    public function mountain()
    {
        return $this->belongsTo(Mountain::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'open' => '<span class="badge bg-success">Open</span>',
            'full' => '<span class="badge bg-warning">Full</span>',
            'closed' => '<span class="badge bg-secondary">Closed</span>',
            'cancelled' => '<span class="badge bg-danger">Cancelled</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getCurrentParticipantsAttribute()
    {
        return $this->bookings()
            ->whereIn('status', ['confirmed', 'paid'])
            ->sum('participants_count');
    }

    public function getAvailableSlotsAttribute()
    {
        return $this->max_participants - $this->current_participants;
    }

    public function getIsFullAttribute()
    {
        return $this->available_slots <= 0;
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open')
                    ->where('start_date', '>=', Carbon::today());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', Carbon::today())
                    ->orderBy('start_date', 'asc');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhereHas('mountain', function($mq) use ($search) {
                  $mq->where('name', 'like', "%{$search}%");
              });
        });
    }

    public function scopeFilterByDifficulty($query, $difficulty)
    {
        return $query->whereHas('mountain', function($q) use ($difficulty) {
            $q->where('difficulty_level', $difficulty);
        });
    }

    public function scopeFilterByPrice($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }
}