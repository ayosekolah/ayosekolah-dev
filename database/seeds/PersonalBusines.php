<?php

use App\Business;
use App\Clas;
use App\ClasPersonal;
use App\Lesson;
use App\LessonBusines;
use App\Personal;
use Illuminate\Database\Seeder;

class PersonalBusines extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker\Factory::create();

        for ($i = 0; $i < 2; $i++) {
            App\Business::create([
                'username' => $faker->userName,
                'name' => $faker->name,
                'image' => null,
                'email' => $faker->email,
                'password' => bcrypt('password'),
                'is_valid' => 1
            ]);
        }

        for ($i = 0; $i < 4; $i++) {
            App\Personal::create([
                'username' => $faker->userName,
                'name' => $faker->name,
                'image' => null,
                'email' => $faker->email,
                'password' => bcrypt('password'),
                'is_valid' => 1
            ]);
        }
    }
}
