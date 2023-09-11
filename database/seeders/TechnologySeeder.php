<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $techLabels = [
            'HTML',
            'CSS',
            "Laravel",
            "PHP",
            "JavaScript",
            "Vue.js",
            "React",
            "Python",
            "Ruby",
            "Angular",
            "Node.js",
            "Java",
            "C#",
        ];

        foreach ($techLabels as $t) {
            $technology = new Technology();

            $technology->label = $t;

            $technology->save();
        }
    }
}
