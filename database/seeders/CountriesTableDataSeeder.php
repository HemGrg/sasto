<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Country\Entities\Country;
use Faker\Factory as Faker;

class CountriesTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i=0; $i < 10; $i++) { 
	    	Country::create([
                'name' => $faker->country,
                'publish' => 1
            ]);
    	}
    }
}
