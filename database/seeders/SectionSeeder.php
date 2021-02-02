<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    protected $sections = [
        "valeurs",
        "moyens",
        "composition",
        "appartenance",
        "reseau",
        "sante",
        "lien_sociaux",
        "insertion",
        "capacite",
        "lieu_territoire",
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = DB::table('places')->get();

        foreach ($places as $place) {
            foreach ($this->sections as $section) {
                Section::create([
                    'place_id' => $place->id,
                    'section' => $section,
                    'visible' => true
                ]);
            }
        }
    }
}
