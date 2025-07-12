<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodService extends Model
{
    use HasFactory;

    protected $fillable = [
        'meal_type',
        'meal_date',
        'menu_description',
        'nutritional_info',
        'cost_per_serving',
        'servings_prepared',
        'dietary_restrictions',
        'allergen_info',
        'prepared_by_staff_id',
        'approved_by_staff_id',
        'status'
    ];

    protected $casts = [
        'meal_date' => 'date',
        'cost_per_serving' => 'decimal:2'
    ];

    // Relationships
    public function preparedByStaff()
    {
        return $this->belongsTo(Staff::class, 'prepared_by_staff_id');
    }

    public function approvedByStaff()
    {
        return $this->belongsTo(Staff::class, 'approved_by_staff_id');
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('meal_date', today());
    }

    public function scopeByMealType($query, $type)
    {
        return $query->where('meal_type', $type);
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('meal_date', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    // Accessors
    public function getTotalCostAttribute()
    {
        return $this->cost_per_serving * $this->servings_prepared;
    }
}
