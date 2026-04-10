<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Create the portfolio admin account. Override credentials with ADMIN_EMAIL and ADMIN_PASSWORD in .env.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@ericksky.online');
        $password = env('ADMIN_PASSWORD', 'ESNyarobi@1234');

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'ERICKsky Admin',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'role' => UserRole::SuperAdmin->value,
            ],
        );
    }
}
