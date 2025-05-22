<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Product;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'test user',
            'email' => 'test@example.com',
        ]);

        $users->add($user);

        $teams = Team::factory(5)->create();

        $users->each(function ($user) use($teams) {
            $user->teams()->attach($teams->random());
        });

        $products = Product::factory(30)->create();

        $products->each(function ($product) use($teams) {
            $product->teams()->attach($teams->random());
        });

        $products->each(function ($product) use($users) {
            $product->users()->attach($users->random());
        });


        Permission::insert([
            ['name' => 'users.index'],
            ['name' => 'products.index'],
            ['name' => 'products.show'],
            ['name' => 'teams.index'],
        ]);

        $permissions = Permission::all();

        $user->each(function ($user) use($permissions) {
            $user->permissions()->attach($permissions->random());
        });

        $teams->each(function ($team) use($permissions) {
            $team->permissions()->attach($permissions->random());
        });
    }
}
