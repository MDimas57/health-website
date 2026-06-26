<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CategoryObserver
{
    public function created(Category $category): void
    {
        $baseEmail = strtolower(
            preg_replace('/[^a-zA-Z0-9]/', '', $category->name)
        );

        $email = $baseEmail . '@gmail.com';

        $counter = 1;

        while (User::where('email', $email)->exists()) {

            $email = $baseEmail . $counter . '@gmail.com';

            $counter++;
        }

        $user = User::create([
            'name' => 'Tim ' . $category->name,
            'email' => $email,
            'password' => Hash::make('password'),
            'category_id' => $category->id,
        ]);

        $user->assignRole('contributor');
    }
}