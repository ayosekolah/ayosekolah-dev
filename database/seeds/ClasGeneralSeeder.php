<?php

use Illuminate\Database\Seeder;

class ClasGeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i  = 1; $i < 13; $i++) {
            App\Clas::where('name', $i)->delete();
        }

        for ($i  = 1; $i < 13; $i++) {
            App\Clas::create([
                'name' => "Kelas " . $i,
                'is_business' => 0
            ]);
        }
    }
}
