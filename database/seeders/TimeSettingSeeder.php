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
        $start_in_time_12Hour = '12:00:00 AM';
        $carbon_time = \Carbon\Carbon::createFromFormat('h:i:s A', $start_in_time_12Hour);
        $start_in_time_24Hour = $carbon_time->format('H:i:s');

        $end_in_time_12Hour = '01:00:00 PM';
        $carbon_time = \Carbon\Carbon::createFromFormat('h:i:s A', $end_in_time_12Hour);
        $end_in_time_24Hour = $carbon_time->format('H:i:s');

       TimeSetting::create(['order_start_time'=>$start_in_time_24Hour, 'order_end_time'=>$end_in_time_24Hour]);
    }
}
