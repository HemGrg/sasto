<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'super-admin@sastowholesale.com',
            'password' => bcrypt('secret'),
            'publish' => 1,
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@sastowholesale.com',
            'password' => bcrypt('secret'),
            'publish' => 1,
        ]);
    }
}
