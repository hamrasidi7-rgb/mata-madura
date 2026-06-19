<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    // Ganti email & password sesuai kebutuhan sebelum deploy pertama
    const EMAIL    = 'admin@matamadura.id';
    const PASSWORD = 'MataMadura2026!';
    const NAME     = 'Admin MataMadura';

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => self::EMAIL],
            [
                'name'              => self::NAME,
                'password'          => Hash::make(self::PASSWORD),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user ready: ' . self::EMAIL);
    }
}
