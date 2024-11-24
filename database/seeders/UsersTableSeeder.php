<?php

namespace Database\Seeders;

use \App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // insert first user instantiating a new model
        $user = new User;
        $user->name = "Nicholas Bale";
        $user->email = "nicholasb@gmail.it";
        $user->telephone = '166101010';
        $user->address = '1200 17th Street, Floor 15, Denver CO';
        $user->password = bcrypt('secret');
        $user->save();

        // insert the second using the static Create method
        User::create([
            'name' => 'John doe',
            'email' => 'john@gmail.com',
            'telephone' => '911234567891',
            'address' => '37°14′00″N 115°48′30″W37°14′00″N, 115°48′30″W',
            'password' => Hash::make('john@123')
        ]);

        // insert two more users using factories and fake content
        User::factory()->count(2)->create();
    }
}

