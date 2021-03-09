<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    protected $sections = [
        "presentation",
        "localisation",
        "valeurs",
        "moyens",
        "composition",
        "impact_social",
        "territoire",
        "galerie"
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->sections as $section) {
            Section::create([
                'section' => $section
            ]);
        }

        $places = DB::table('places')->get();
        $sections = Section::all();

        foreach ($sections as $section) {
            foreach ($places as $place) {
                $section->places()->attach($place->id);
            }
        }
    }
}
