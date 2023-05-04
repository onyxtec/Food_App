<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $finance = User::create([
            'name' => 'Finance',
            'email' => 'finance@example.com',
            'password' => bcrypt('password123'),
        ]);

        $admin->assignRole('Admin');

        $finance->assignRole('Finance');
    }
}
