<?php

namespace Database\Seeders;

use App\User;
use App\UserAddress;
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
        User::factory()
            ->has(UserAddress::factory()->count(5))
            ->times(1)
            ->create();
    }
}
