<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Role\Entities\Role;
use Faker\Factory as Faker;
use Str;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'super admin',
            'slug' => 'super_admin',
        ]);
        Role::create([
            'name' => 'admin',
            'slug' => 'admin',
        ]);
        Role::create([
            'name' => 'vendor',
            'slug' => 'vendor',
        ]);
        Role::create([
            'name' => 'customer',
            'slug' => 'customer',
        ]);
    }
}
