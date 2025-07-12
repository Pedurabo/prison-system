<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inmate extends Model
{
    use HasFactory;

    protected $fillable = [
        'inmate_number',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'admission_date',
        'release_date',
        'sentence_length',
        'crime_category',
        'security_level',
        'cell_number',
        'block',
        'status',
        'nationality',
        'address_before_incarceration',
        'emergency_contact',
        'next_of_kin',
        'photo_path',
        'fingerprint_data'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
        'release_date' => 'date'
    ];

    // Relationships
    public function securityIncidents()
    {
        return $this->hasMany(SecurityIncident::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function rehabilitationPrograms()
    {
        return $this->belongsToMany(RehabilitationProgram::class, 'inmate_rehabilitation_programs')
                    ->withPivot('enrollment_date', 'completion_date', 'status')
                    ->withTimestamps();
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth->age;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeBySecurityLevel($query, $level)
    {
        return $query->where('security_level', $level);
    }

    public function scopeByBlock($query, $block)
    {
        return $query->where('block', $block);
    }

    public function scopeReleaseInNext($query, $days = 30)
    {
        return $query->where('release_date', '<=', now()->addDays($days))
                     ->where('release_date', '>=', now());
    }
}
