<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\FoodGroup;
use App\Models\FoodNutrient;
use App\Models\Nutrient;
use App\Models\NutrientGroup;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private function createNutrientGroup(&$existingNutrientGroups, $row)
    {
        $name_dutch = $row[0];
        if (array_key_exists($name_dutch, $existingNutrientGroups)) {
            return $existingNutrientGroups[$name_dutch];
        }

        $nutrientGroup = NutrientGroup::query()->create([
            'name_dutch' => trim($name_dutch),
            'name_english' => trim($row[1]),
        ]);
        $existingNutrientGroups[$name_dutch] = $nutrientGroup;
        return $nutrientGroup;
    }

    public function createNutrients()
    {
        $existingNutrientGroups = [];
        $nutrientIdsByCode = [];

        $handle = fopen(__DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "nutrients.csv", "r");
        try {
            fgetcsv(stream: $handle, separator: '|');  // skip CSV header

            while ($row = fgetcsv(stream: $handle, separator: '|')) {
                assert(sizeof($row) == 6);

                $nutrientGroup = $this->createNutrientGroup($existingNutrientGroups, $row);
                $code = trim($row[2]);
                if (array_key_exists($code, $nutrientIdsByCode)) {
                    echo "Skipping duplicate nutrient definition: " . $row[2] . "\n";
                    continue;
                }

                $nutrient = Nutrient::query()->create([
                    'nutrient_group_id' => $nutrientGroup->getKey(),
                    'code' => $code,
                    'component_dutch' => trim($row[3]),
                    'component_english' => trim($row[4]),
                    'unit' => trim($row[5]),
                ]);
                $nutrientIdsByCode[$code] = $nutrient->getKey();

            }
        } finally {
            fclose($handle);
        }
        return $nutrientIdsByCode;
    }

    public function createFoodGroup($nameDutch, $nameEnglish) {
            return FoodGroup::query()->create([
                'name_dutch' => $nameDutch,
                'name_english' => $nameEnglish,
            ])->id;
    }

    public function createFoods($nutrientIdsByCode): void
    {
        $timestamp = Carbon::now();
        $handle = fopen(__DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "foods.csv", "r");
        try {
            $header = fgetcsv(stream: $handle, separator: '|'); // skip CSV header
            dump($header);

            $food_id_counter = -1;
            $nutrientQuantitiesByCode = [];
            $previousRow = null;
            $foodNutrientRelations = [];
            $existingFoodGroups = [];
            while (($row = fgetcsv(stream: $handle, separator: '|'))) {

                $foodGroupDutch = trim($row[1]);
                if(!array_key_exists($foodGroupDutch, $existingFoodGroups)) {
                    $foodGroupEnglish = trim($row[2]);
                    $foodGroupId = FoodGroup::query()->create([
                        'name_dutch' => $foodGroupDutch,
                        'name_english' => $foodGroupEnglish,
                    ])->id;
                    $existingFoodGroups[$foodGroupDutch] = $foodGroupId;
                } else {
                    $foodGroupId = $existingFoodGroups[$foodGroupDutch];
                }

                $food_id = $row[3];

                if($food_id_counter == -1) {
                    $food_id_counter = $food_id;
                }

                if ($food_id > $food_id_counter) {
                    $name_dutch = trim($previousRow[4]);

                    Food::insert([
                        'id' => $food_id - 1,
                        'food_group' => $foodGroupId,
                        'carbs' => $nutrientQuantitiesByCode['CHO'],
                        'fat' => $nutrientQuantitiesByCode['FAT'],
                        'saturated_fat' => $nutrientQuantitiesByCode['FASAT'],
                        'protein' => $nutrientQuantitiesByCode['PROT'],
                        'sugar' => $nutrientQuantitiesByCode['SUGAR'] ?? 0,
                        'ash' => $nutrientQuantitiesByCode['ASH'] ?? 0,
                        'fiber' => $nutrientQuantitiesByCode['FIBT'] ?? 0,
                        'name_dutch' => $name_dutch,
                        'name_english' => trim($previousRow[5]),
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ]);

                    FoodNutrient::query()->insert($foodNutrientRelations);

                    $food_id_counter = $food_id;
                    $nutrientQuantitiesByCode = [];
                    $foodNutrientRelations = [];
                }

                if(!array_key_exists(9, $row)) {
                    echo $food_id . "\n";
                    dump($row);
                    continue;
                }
                $component = $row[9];
                $quantity = $row[12];
                $nutrient_id = $nutrientIdsByCode[$component];

                $nutrientQuantitiesByCode[$component] = $quantity;

                $foodNutrientRelations[] = [
                    'nutrient_id' => $nutrient_id,
                    'food_id' => $food_id,
                    'quantity' => intval($quantity),
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
                $previousRow = $row;
            }
        } finally {
            fclose($handle);
        }
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->truncate();
        FoodGroup::query()->truncate();
        Food::query()->truncate();
        Nutrient::query()->truncate();
        NutrientGroup::query()->truncate();

        $nutrients = $this->createNutrients();
        $this->createFoods($nutrients);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
