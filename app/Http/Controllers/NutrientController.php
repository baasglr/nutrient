<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Routing\Controller;

class NutrientController extends Controller
{
    public function index()
    {
        $data = DB::select("
        select name_english as food, protein, fiber, fat, saturated_fat, carbs, sugar from foods

        limit 100");
        return view('nutrients', compact('data'));
    }
}
