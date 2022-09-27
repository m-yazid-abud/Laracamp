<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            'name' => "admin",
            'email' => "admin@laracamp.develop",
            'email_verified_at' => Date("Y-m-d H:i:s", time()),
            'password' => Hash::make('password'),
            'is_admin' => 1,
        ];

        User::create($admin);
    }
}
