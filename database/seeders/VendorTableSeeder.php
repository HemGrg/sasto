<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        // $str = Str::new()
        $faker = Faker::create();
        // $str = Str::new()
        for ($i = 0; $i < 50; $i++) {
            Vendor::create([
                'user_id' => $faker->numberBetween(1, 6),
                'employer_name' => $faker->name,
                'mobile_number' => $faker->numberBetween(999999999, 100000000),
                'employer_designation' => $faker->name,
                'address' => $faker->address,
                'employer_email' => $faker->email,
            ]);
        }
    }
}
