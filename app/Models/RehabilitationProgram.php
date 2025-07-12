<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RehabilitationProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'program_type',
        'description',
        'instructor_staff_id',
        'capacity',
        'duration_weeks',
        'start_date',
        'end_date',
        'status',
        'cost',
        'location',
        'prerequisites',
        'certificate_provided'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'cost' => 'decimal:2',
        'certificate_provided' => 'boolean'
    ];

    // Relationships
    public function instructor()
    {
        return $this->belongsTo(Staff::class, 'instructor_staff_id');
    }

    public function inmates()
    {
        return $this->belongsToMany(Inmate::class, 'inmate_rehabilitation_programs')
                    ->withPivot('enrollment_date', 'completion_date', 'status', 'progress_notes')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('program_type', $type);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    // Accessors
    public function getAvailableSpotsAttribute()
    {
        return $this->capacity - $this->inmates()->count();
    }
}
