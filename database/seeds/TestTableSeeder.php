<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;



class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,390) as $index) {
            DB::table('tests')->insert([
                'msg' => $faker->name,


            ]);
        }
    }
}
