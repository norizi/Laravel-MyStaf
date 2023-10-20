<?php

namespace Database\Seeders;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

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
        $faker = Faker::create('App\Models\Question');
        for($i = 1 ; $i <= 200 ; $i++){
            DB::table('questions')->insert([
                'question' => $faker->sentence(), 
            ]);
        }
    }
}
