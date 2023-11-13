<?php

namespace App\Services;

use App\Models\Place;

class Batiment
{
    private $decors_gauche = [];
    private $decors_droite = [];
    private $thematiques = [];
    private $toits_gauches = ['TOIT1', 'TOIT2 INVERSÉ', 'TOIT3 INVERSÉ'];
    private $toits_droites  = ['TOIT1', 'TOIT1 INVERSÉ', 'TOIT2', 'TOIT2 INVERSÉ', 'TOIT3 INVERSÉ'];

    private $ftlMatchingTheme = [
        "Action sociale / Insertion sociale / Hébergement d'urgence" => "Solidarité",
        "Agriculture" => "Production agricole",
        "Culture / Arts" => "Culture",
        "Écologie / Économie circulaire et Réemploi de matériaux" => "Écologie",
        "Éducation / Formation" => "Éducation et enseignement",
        "Évènement / Fête" => "Évènementiel",
        "Incubation / Accélérateurs d'entreprises innovantes" => "Travail",
        "Insertion professionnelle / formation" => "Formation",
        "Médiation Numérique" => "Inclusion numérique",
        "Lien social, proximité et voisinage" => "Lien social et voisinage",
        "Santé / Soin de l'esprit" => "Soin de l'esprit",
        "Travail / Coworking" => "Coworking"
    ];

    public function __construct()
    {
        $this->decors_gauche = glob(rtrim(resource_path('assets/images/batiment/decors/gauche'), '/').'/*.svg');
        $this->decors_gauche = array_map('basename', $this->decors_gauche);

        $this->decors_droite = glob(rtrim(resource_path('assets/images/batiment/decors/droite'), '/').'/*.svg');
        $this->decors_droite = array_map('basename', $this->decors_droite);
    }

    public function init(Place $place)
    {
        $this->thematiques = $place->get('blocs->presentation->donnees->thematiques');

        if($this->thematiques !== null) {
            for ($i = count($this->thematiques) ; $i < 3 ; $i++ ) {
                $this->thematiques[] = '';
            }
            shuffle($this->thematiques);

        }

        mt_srand(crc32($place->get('name')) + 1);

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
        if ($this->thematiques !== null && array_key_exists($index, $this->thematiques)) {
            return $this->thematiques[$index];
        }

        return '';
    }

    public function getThematiquePath(string $theme)
    {
        if(array_key_exists($theme, $this->ftlMatchingTheme)) {
            $theme = $this->ftlMatchingTheme[$theme];
        }

        if (is_file(resource_path('assets/images/batiment/themes/').$theme.'.svg') === false) {
            return 'assets/images/batiment/themes/THEME_VIERGE.svg';
        }

        return 'assets/images/batiment/themes/'.$theme.'.svg';
    }

    public function getToit(string $side)
    {
        $toit = ($side === 'gauche') ? $this->toits_gauches : $this->toits_droites;

        return current($toit);
    }
}
