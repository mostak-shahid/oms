<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [
            ['meta_key'=>'siteurl','meta_value'=>'http://laravel-oms.test/'],
            ['meta_key'=>'sitetitle','meta_value'=>'Laravel OMS'],
            ['meta_key'=>'tagline','meta_value'=>'Just another Laravel Site.'],
            ['meta_key'=>'users_can_register','meta_value'=>0],
            ['meta_key'=>'admin_email','meta_value'=>'mostgak.shahid@gmail.com'],
            ['meta_key'=>'weekend','meta_value'=>['sat','sun']],
        ];
        foreach($options as $option) {
            $meta_value = (is_array($option['meta_value']))?maybe_serialize($option['meta_value']):$option['meta_value'];
            Setting::create([
                'meta_key' => $option['meta_key'],
                'meta_value' => $meta_value,
            ]);
        }
    }
}
