<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password')]
        );
        $admin->assignRole('super_admin');

        // 5 Kontributor
        $contributors = [
            ['name' => 'Tim Gizi',      'email' => 'gizi@gmail.com'],
            ['name' => 'Tim PHBS',      'email' => 'phbs@gmail.com'],
            ['name' => 'Tim KB',        'email' => 'kb@gmail.com'],
            ['name' => 'Tim Lansia',    'email' => 'lansia@gmail.com'],
            ['name' => 'Tim Kes. Jiwa', 'email' => 'jiwa@gmail.com'],
        ];

        foreach ($contributors as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => Hash::make('password')]
            );
            $user->assignRole('contributor');
        }
    }
}