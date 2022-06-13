<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin']);

        User::factory()->create([
           'name' => 'Salvador Céspedes',
           'email' => 'salva@test.com',
            'password' => bcrypt('123'),
        ])->assignRole('admin');
        User::factory(100)->create();
        User::factory()->create([
            'name' => 'John Vulkan',
            'email' => 'john@test.com',
            'password' => bcrypt('123'),
        ]);
    }
}
