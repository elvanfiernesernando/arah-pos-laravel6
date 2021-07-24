<?php

use Illuminate\Database\Seeder;
use App\User;

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
            'name' => 'Admin PT. Arah Melangkah Didepan',
            'email' => 'admin@arahmelangkah.com',
            'password' => bcrypt('a1b2c3d4e5'),
            'status' => 1,
            'is_profile_completed' => 1
        ]);

        User::create([
            'name' => 'Admin PT. Fiernes Technology',
            'email' => 'admin@fiernestechnology.com',
            'password' => bcrypt('a1b2c3d4e5'),
            'status' => 1,
            'is_profile_completed' => 0
        ]);
    }
}
