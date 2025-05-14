<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;

/**
 * 1,Aardappelen en knolgewassen,Potatoes and tubers
 * 2,Graanproducten en bindmiddelen,Cereals and cereal products
 * 3,Groente,Vegetables
 * 4,Fruit,Fruits
 * 5,Eieren,Eggs
 * 6,Vlees en gevogelte,Meat and poultry
 * 7,"Vis, schaal- en schelpdieren","Fish, crustacean and shellfish"
 * 8,Peulvruchten,Legumes
 * 9,Hartige snacks en zoutjes,Savoury snacks
 * 10,Kruiden en specerijen,Herbs and spices
 * 11,Noten en zaden,Nuts and seeds
 * 12,Brood,Bread
 * 13,Gebak en koek,Pastry and biscuits
 * 14,Melk en melkproducten,Milk and milk products
 * 15,Vleesvervangers en zuivelvervangers,Meat substitutes and dairy substitutes
 * 16,Kaas,Cheese
 * 17,Vetten en oliën,Fats and oils
 * 18,Vleeswaren,Cold meat cuts
 * 19,Samengestelde gerechten,Mixed dishes
 * 20,"Suiker, snoep, zoet beleg en zoete sauzen","Sugar, sweets and sweet sauces"
 * 21,Alcoholische dranken,Alcoholic beverages
 * 22,Niet-alcoholische dranken,Non-alcoholic beverages
 * 23,Hartige sauzen,Savoury sauces
 * 24,Diversen,Miscellaneous foods
 * 25,Hartig broodbeleg,Savoury bread spreads
 * 26,Soepen,Soups
 * 27,Flesvoeding en preparaten,Foods for special nutritional use
 */
class NutrientController extends Controller
{
    private array $food_groups = [
        "potatoes_and_tubers" => [1],
        "vegetables" => [3],
        "fruits" => [4],
        "meat" => [6, 7, 18],
        "legumes" => [8],
        "nuts_and_seeds" => [11],
        "fats_and_oils" => [17],
    ];

    public function index()
    {
        $currentRouteName = Route::currentRouteName();
        $food_group_id = $this->food_groups[$currentRouteName];

        $data = DB::table("foods")->select(
            "name_english as food", "protein", "fiber", "fat", "saturated_fat", "carbs", "sugar"
        )->whereIn("food_group", $food_group_id)->get();


        return view('nutrients', compact('data'));
    }
}
