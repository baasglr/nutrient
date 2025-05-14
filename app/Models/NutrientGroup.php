<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NutrientGroup extends Model
{
    public $table = "nutrient_groups";
    protected $primaryKey = 'id';
    protected $fillable = [
        'name_dutch',
        'name_english',
        'created_at',
        'updated_at',
    ];
}
