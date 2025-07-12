<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'department_head_id',
        'budget',
        'status',
        'established_date'
    ];

    protected $casts = [
        'established_date' => 'date',
        'budget' => 'decimal:2'
    ];

    // Relationships
    public function departmentHead()
    {
        return $this->belongsTo(Staff::class, 'department_head_id');
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function securityIncidents()
    {
        return $this->hasMany(SecurityIncident::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('name', 'like', "%{$type}%");
    }
}
