<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = env('ADMIN_NAME', 'Admin');
        $email = env('ADMIN_EMAIL', 'contratacion@ite.com.bo');
        $password = env('ADMIN_PASSWORD', '123456');

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => $password,
                'email_verified_at' => Carbon::now(),
            ]
        );
    }
}
