<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
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
        $role = Role::create(['name' => 'admin']);

        User::factory()->create([
            'name' => 'Salva Cespedes',
            'email' => 'salva@test.com',
            'password' => bcrypt('123'),
        ])->assignRole('admin');

        User::factory(100)->create();
    }
}
