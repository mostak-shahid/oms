<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Md. Mostak Shahid',
            'email' => 'mostak.shahid@gmail.com',
            'password' => Hash::make('123456789'),            
            'phone' => '01670058131',
            'username' => 'mostak.shahid',
            'is_admin' => 1,
            'is_active' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Md. Mostak Apu',
            'email' => 'mostak.apu@gmail.com',
            'password' => Hash::make('123456789'),
            'phone' => '01710702212',
            'username' => 'mostak.apu',
            'is_admin' => 0,
            'is_active' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Inactive User',
            'email' => 'inactive.user@gmail.com',
            'password' => Hash::make('123456789'),
            'phone' => '0123456789',
            'username' => 'inactive.user',
            'is_admin' => 0,
            'is_active' => 0,
        ]);
    }
}
