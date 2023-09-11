<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labelTypes = ['Front End', 'Back End', 'Full Stack', 'Mobile App', 'Security'];

        foreach ($labelTypes as $l) {
            $type = new Type();

            $type->label = $l;

            $type->save();
        }
    }
}
