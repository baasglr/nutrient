<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Nutrient extends Model
{
    public $table = "nutrients";
    protected $primaryKey = 'id';
    protected $fillable = [
        'nutrient_group_id',
        'code',
        'component_dutch',
        'component_english',
        'unit',
        'created_at',
        'updated_at',
    ];

    public function food(): BelongsToMany
    {
        return $this->belongsToMany(Food::class, 'nutrient_food', 'nutrient_id', 'food_id');
    }
}
