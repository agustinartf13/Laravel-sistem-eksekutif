<?php

use Illuminate\Database\Seeder;
use App\Mekanik;

class MekanikTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            App\Mekanik::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'address' => $faker->address,
                'no_telphone' => $faker->phoneNumber,
                'image' => $faker->image,
                'status' => 'ACTIVE'
            ]);
        }
    }
}