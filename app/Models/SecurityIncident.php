<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityIncident extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_number',
        'incident_type',
        'severity_level',
        'location',
        'description',
        'incident_date',
        'reported_by_staff_id',
        'inmate_id',
        'department_id',
        'status',
        'investigation_notes',
        'resolution',
        'resolved_date',
        'resolved_by_staff_id'
    ];

    protected $casts = [
        'incident_date' => 'datetime',
        'resolved_date' => 'datetime'
    ];

    // Relationships
    public function reportedByStaff()
    {
        return $this->belongsTo(Staff::class, 'reported_by_staff_id');
    }

    public function resolvedByStaff()
    {
        return $this->belongsTo(Staff::class, 'resolved_by_staff_id');
    }

    public function inmate()
    {
        return $this->belongsTo(Inmate::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeHighPriority($query)
    {
        return $query->where('severity_level', 'high');
    }

    public function scopeRecentIncidents($query, $days = 7)
    {
        return $query->where('incident_date', '>=', now()->subDays($days));
    }
}
