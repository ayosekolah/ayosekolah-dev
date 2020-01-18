<?php

use Illuminate\Database\Seeder;

class LessonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                'name' => "BIOLOGI",
                'color' => random_color(),
                'is_business' => 0,
            ],
            [
                'name' => "FISIKA",
                'color' => random_color(),
                'is_business' => 0,
            ],
            [
                'name' => "KIMIA",
                'color' => random_color(),
                'is_business' => 0,
            ],
            [
                'name' => "MATEMATIKA",
                'color' => random_color(),
                'is_business' => 0,
            ],
            [
                'name' => "BAHASA INGGRIS",
                'color' => random_color(),
                'is_business' => 0,
            ],
            [
                'name' => "GEOGRAFI",
                'color' => random_color(),
                'is_business' => 0,
            ],
            [
                'name' => "SEJARAH",
                'color' => random_color(),
                'is_business' => 0,
            ],
            [
                'name' => "SOSIOLOGI",
                'color' => random_color(),
                'is_business' => 0,
            ],
            [
                'name' => "EKONOMI",
                'color' =>  random_color(),
                'is_business' => 0,
            ],
        ];
        for ($i  = 0; $i < count($data); $i++) {
            App\Lesson::where('name', $data[$i]['name'])->delete();
        }

        for ($i  = 0; $i < count($data); $i++) {
            App\Lesson::create($data[$i]);
        }
    }
}
