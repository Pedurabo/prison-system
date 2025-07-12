<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'employee_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'department_id',
        'position',
        'rank',
        'hire_date',
        'salary',
        'status',
        'address',
        'emergency_contact',
        'security_clearance'
    ];

    protected $casts = [
        'hire_date' => 'date',
        'salary' => 'decimal:2'
    ];

    // Relationships
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function managedDepartment()
    {
        return $this->hasOne(Department::class, 'department_head_id');
    }

    public function securityIncidents()
    {
        return $this->hasMany(SecurityIncident::class, 'reported_by_staff_id');
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'attending_staff_id');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeSecurity($query)
    {
        return $query->whereHas('department', function($q) {
            $q->where('name', 'like', '%Security%');
        });
    }
}
