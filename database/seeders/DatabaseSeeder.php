<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // \App\Models\User::factory(40)->create();

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            ModelSeeder::class,
            DimensionSeeder::class,
            DepartamentoSeeder::class,
            MunicipioSeeder::class,
            UserSeeder::class,
        ]);
        
    }
}
