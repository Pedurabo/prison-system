<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number',
        'request_type',
        'priority_level',
        'location',
        'description',
        'reported_by_staff_id',
        'assigned_to_staff_id',
        'estimated_cost',
        'actual_cost',
        'status',
        'request_date',
        'completion_date',
        'notes'
    ];

    protected $casts = [
        'request_date' => 'datetime',
        'completion_date' => 'datetime',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2'
    ];

    // Relationships
    public function reportedByStaff()
    {
        return $this->belongsTo(Staff::class, 'reported_by_staff_id');
    }

    public function assignedToStaff()
    {
        return $this->belongsTo(Staff::class, 'assigned_to_staff_id');
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['pending', 'in_progress']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority_level', 'high');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', '!=', 'completed')
                     ->where('request_date', '<', now()->subDays(7));
    }
}
