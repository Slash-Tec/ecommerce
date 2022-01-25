<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
           'name' => 'Samuel Garcia',
           'email' => 'samuel@test.com',
            'password' => bcrypt('123'),
        ]);
    }
}
