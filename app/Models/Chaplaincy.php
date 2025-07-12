<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chaplaincy extends Model
{
    use HasFactory;

    protected $table = 'chaplaincies';

    protected $fillable = [
        'service_type',
        'religion',
        'service_date',
        'service_time',
        'location',
        'chaplain_staff_id',
        'description',
        'capacity',
        'attendees_count',
        'notes',
        'status'
    ];

    protected $casts = [
        'service_date' => 'date',
        'service_time' => 'datetime'
    ];

    // Relationships
    public function chaplain()
    {
        return $this->belongsTo(Staff::class, 'chaplain_staff_id');
    }

    public function attendees()
    {
        return $this->belongsToMany(Inmate::class, 'chaplaincy_attendances')
                    ->withPivot('attendance_date', 'notes')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('service_date', '>=', now());
    }

    public function scopeByReligion($query, $religion)
    {
        return $query->where('religion', $religion);
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('service_date', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    // Accessors
    public function getAvailableSpotsAttribute()
    {
        return $this->capacity - $this->attendees_count;
    }
}
