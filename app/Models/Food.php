<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Food extends Model
{
    public $table = "foods";
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'name_dutch',
        'name_english',
        'protein',
        'fat',
        'saturated_fat',
        'carbs',
        'sugar',
        'fibre',
        'ash',
        'created_at',
        'updated_at',
    ];

    public function nutrients(): BelongsToMany
    {
        return $this->belongsToMany(Nutrient::class, 'nutrient_food', 'food_id', 'nutrient_id');
    }
}
