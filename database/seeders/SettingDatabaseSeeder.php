<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $settings = [
            [
                'key' => 'slider_images',
                'value' => '[]'
            ],

            [
                'key' => 'whatsapp',
                'value' => '966501854780'
            ],

            [
                'key' => 'email',
                'value' => 'Info@wasla.net'
            ],

            [
                'key' => 'twitter',
                'value' => 'waslaCD'
            ],
        ];

        DB::table('settings')->insert($settings);
    }
}
