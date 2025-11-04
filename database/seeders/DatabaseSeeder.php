<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {

        $this->call(RoleSeeder::class);
        $this->call(RoleNuevoSeeder::class);
        $this->call(RoleReportesSeeder::class);
        $this->call(RoleVentasSeeder::class);
        $this->call(RoleIndexSeeder::class);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@gmail.com'),
            'status' => 'active',
        ])->assignRole('Admin');
    }
}
