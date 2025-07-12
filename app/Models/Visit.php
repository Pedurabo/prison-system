<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'inmate_id',
        'visitor_name',
        'visitor_relationship',
        'visitor_id_number',
        'visitor_phone',
        'visit_date',
        'visit_time',
        'duration_minutes',
        'visit_type',
        'status',
        'approved_by_staff_id',
        'notes',
        'visitor_address'
    ];

    protected $casts = [
        'visit_date' => 'date',
        'visit_time' => 'datetime'
    ];

    // Relationships
    public function inmate()
    {
        return $this->belongsTo(Inmate::class);
    }

    public function approvedByStaff()
    {
        return $this->belongsTo(Staff::class, 'approved_by_staff_id');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('visit_date', today());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('visit_date', '>=', now());
    }
}
