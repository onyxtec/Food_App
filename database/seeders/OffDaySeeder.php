<?php

namespace Database\Seeders;

use App\Models\OffDay;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OffDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OffDay::create([
            'start_date' => '2023-06-10',
            'end_date' => '2023-06-11',
        ]);
    }
}
