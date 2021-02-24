<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create([
            'user_id' => 1,
            'meta_key' => 'designation',
            'meta_value' => 'Manager'
        ]);
        Profile::create([
            'user_id' => 2,
            'meta_key' => 'designation',
            'meta_value' => 'Web Developer'
        ]);
    }
}
