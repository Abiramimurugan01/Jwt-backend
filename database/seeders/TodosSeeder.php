<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Todos;

class TodosSeeder extends Seeder
{
    
    public function run(): void
    {
        $faker=\Faker\Factory::create();
        for ($i=0; $i <3; $i++) 
        {   
                 Todos::create([
                    
                    'task'=>$faker->sentence,
                    'description'=>$faker->sentence,
                    'status'=>$faker->randomElement(['Active','Inactive']),
                    'created_at' => now(),
                    'updated_at' => now(),
                 ]);
        }
    }
}
