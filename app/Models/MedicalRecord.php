<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'inmate_id',
        'attending_staff_id',
        'visit_date',
        'diagnosis',
        'symptoms',
        'treatment',
        'medications',
        'notes',
        'follow_up_required',
        'follow_up_date',
        'medical_condition',
        'allergies',
        'emergency_contact',
        'blood_type',
        'height',
        'weight'
    ];

    protected $casts = [
        'visit_date' => 'datetime',
        'follow_up_date' => 'date',
        'follow_up_required' => 'boolean',
        'height' => 'decimal:2',
        'weight' => 'decimal:2'
    ];

    // Relationships
    public function inmate()
    {
        return $this->belongsTo(Inmate::class);
    }

    public function attendingStaff()
    {
        return $this->belongsTo(Staff::class, 'attending_staff_id');
    }

    // Scopes
    public function scopeRequiresFollowUp($query)
    {
        return $query->where('follow_up_required', true)
                     ->where('follow_up_date', '<=', now());
    }

    public function scopeRecentVisits($query, $days = 30)
    {
        return $query->where('visit_date', '>=', now()->subDays($days));
    }

    public function scopeByCondition($query, $condition)
    {
        return $query->where('medical_condition', 'like', "%{$condition}%");
    }
}
