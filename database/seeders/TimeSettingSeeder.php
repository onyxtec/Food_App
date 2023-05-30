<?php

namespace Database\Seeders;

use App\Models\TimeSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       TimeSetting::create(['order_start_time'=>'09:00:00', 'order_end_time'=>'01:00:00']);
    }
}
