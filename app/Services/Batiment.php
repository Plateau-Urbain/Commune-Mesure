<?php

namespace App\Services;

use App\Models\Place;

class Batiment
{
    const THEME2KEY = [
        'Accueil' => 'THEME_ACCUEIL',
        'Artisanat' => 'THEME_ARTISANAT',
        'Convivialité' => 'THEME_CONVIVIALITE',
        'Coworking' => 'THEME_COWORKING',
        'Recyclage' => 'THEME_RECYCLAGE',
    ];

    private $decors_gauche = [];
    private $decors_droite = [];
    private $thematiques = [];
    private $toits_gauches = ['TOIT1', 'TOIT2 INVERSÉ', 'TOIT3 INVERSÉ'];
    private $toits_droites  = ['TOIT1', 'TOIT1 INVERSÉ', 'TOIT2', 'TOIT2 INVERSÉ', 'TOIT3 INVERSÉ'];

    public function __construct()
    {
        $this->decors_gauche = glob(rtrim(resource_path('assets/images/batiment/decors/gauche'), '/').'/*.svg');
        $this->decors_gauche = array_map('basename', $this->decors_gauche);

        $this->decors_droite = glob(rtrim(resource_path('assets/images/batiment/decors/droite'), '/').'/*.svg');
        $this->decors_droite = array_map('basename', $this->decors_droite);
    }

    public function init(Place $place)
    {
        $themes = $place->get('blocs->presentation->donnees->thematiques');

        if ($themes) {
            foreach($themes as $t) {
                $this->thematiques[] = (isset(self::THEME2KEY[$t])) ? self::THEME2KEY[$t] : $t;
            }
        }

        for ($i = count($this->thematiques) ; $i < 3 ; $i++ ) {
            $this->thematiques[] = '';
        }

        mt_srand(crc32($place->get('name')) + 1);

        shuffle($this->thematiques);
        shuffle($this->decors_gauche);
        shuffle($this->decors_droite);
        shuffle($this->toits_gauches);
        shuffle($this->toits_droites);
    }

    public function getDecors(string $side)
    {
        $decors = ($side === 'gauche') ? $this->decors_gauche : $this->decors_droite;
        return $side.DIRECTORY_SEPARATOR.current($decors);
    }

    public function getThematique(int $index)
    {
        return $this->thematiques[$index];
    }

    public function getToit(string $side)
    {
        $toit = ($side === 'gauche') ? $this->toits_gauches : $this->toits_droites;

        return current($toit);
    }
}
