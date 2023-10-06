<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'father_name' => 'Father admin',
            'contact' => '2534684567',
            'dob' => '1999-12-28',
            'address' => 'aushd uasd',
            'photo' => 'sdsd.png',
            'email' => 'admin@user.com',
            'password' => bcrypt('admin@user'),
        ])->assignRole('admin');
    }
}
