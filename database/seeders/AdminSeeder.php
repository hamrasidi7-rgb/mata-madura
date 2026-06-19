<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    const EMAIL    = 'admin@matamadura.news';
    const PASSWORD = 'Matamadura-026';
    const NAME     = 'Hambali Rasidi';

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

        $this->command->info('Admin ready: ' . self::EMAIL);
    }
}
