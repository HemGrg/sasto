<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Str;
use DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $str = Str::new()
        $users = DB::table('users')->get();
        $roles = DB::table('roles')->get();

        for ($i = 0; $i < count($users); $i++) {
            DB::table('role_user')->insert([
                'user_id' => $users[$i]->id,
                'role_id' => $roles[$i]->id,
            ]);
        }
    }
}
