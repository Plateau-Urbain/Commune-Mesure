<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    protected $sections = [
        "bloc_gauche",
        "bloc_milieu",
        "bloc_droite",
        "public",
        "accessibilite",
        "transport",
        "valeurs",
        "moyens",
        "composition",
        "reseau",
        "appartenance",
        "sante",
        "insertion",
        "lien_social",
        "capacite",
        "lieu_territoire"
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
                $section->place()->attach($place->place);
            }
        }
    }
}
