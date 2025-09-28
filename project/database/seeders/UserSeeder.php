<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'fio' => 'Test Admin',
            'email' => 'admin@shop.ru',
            'password' => Hash::make('password'),
        ]);
        User::factory()->create([
            'fio' => 'Test Client',
            'email' => 'user@shop.ru',
            'password' => Hash::make('password'),
        ]);
        DB::table('users')->where("email", "admin@shop.ru")->update(["is_admin" => true]);
    }
}
