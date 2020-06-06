<?php

use App\Country;
use App\Division;
use App\Helpers\Constants;
use App\State;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Arr;

class ProductSeeder extends Seeder
{

    private function randomProduct()
    {
        $faker = Faker::create();
        return
            [
                'title' => $faker->sentence(),
                'description' => $faker->paragraph(),
                'property' => 'apartment',
                'type' => 'rent',
                'rent_type' => 'monthly',
                'country' => Country::getRandom()->name,
                'state' => State::getRandom()->name,
                'division' => Division::getRandom()->name,
                'street' => $faker->streetName,
                'house_no' => $faker->buildingNumber,
                'post_code' => $faker->postcode,
                'street_and_house_no_visible' => 1,
                'area' => $faker->numberBetween(1, Constants::MAX_AREA),
                'rooms' => $faker->numberBetween(1, Constants::MAX_ROOMS),
                'floor' => $faker->numberBetween(1, Constants::MAX_FLOOR),
                'build_year' => $faker->numberBetween(1, Constants::MAX_BUILD_YEAR),
                'rent' => $faker->numberBetween(1, Constants::MAX_RENT),
                'user_id' => User::getRandom()->id,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ];
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            $this->randomProduct(),
            $this->randomProduct(),
            $this->randomProduct()
        ]);
    }
}
