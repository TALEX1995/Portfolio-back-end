<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        // Take type ID from the database table types
        $type_ids = Type::pluck('id')->toArray();
        // Take technology ID from the database table technology
        $technology_ids = Technology::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            $project = new Project();

            $project->type_id = Arr::random($type_ids);
            $project->title = $faker->words(3, true);
            $project->description = $faker->text();

            $project->save();

            // Add relation many to many
            $project_tech = [];
            foreach ($technology_ids as $t) {
                if ($faker->boolean()) $project_tech[] = $t;
            }

            $project->technologies()->attach($project_tech);
        }
    }
}
