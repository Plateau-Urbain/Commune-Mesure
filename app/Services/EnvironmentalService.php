<?php

namespace App\Services;

use App\Models\Place;
use App\Models\PlaceEnvironment;

class EnvironmentalService
{
    protected $schema = '/app/places/schema_environmental.json';
    protected $questionnaire = '/app/places/environmental_questions.json';

    private static $axes = ['circularite_sobriete', 'emission_gaz_effet_serre', 'biodiversite', 'environnement_physique', 'sensibilisation_engagement'];

    public static $sub_axes = [
        "circularite_sobriete" => [
            "moins_consommer" => ["reutilisation_objet", "equipement_partage", "reparation_objet", "limitation_achat", "limitation_dechet"],
            "mieux_consommer" => ["equipement_reutilisable", "equipement_reconditionne", "distributeur_local", "charte_selection_fournisseur",
                                    "optimisation_achat","alimentation_locale", "demarche_zero_dechets", "low_tech", "eco_conception", "fontaine_eau"],
            "gerer_dechet" => ["bio_dechet", "recycle_dechet", "dechet_atelier_revalorise", "point_collecte_dechet"],
        ],
        "emission_gaz_effet_serre" => [
            "empreinte_carbone" => ["ges_identifie", "bilan_carbon_calcule", "strategie_enjeu_climatique"],
            "limiter_emission" => ["covoiturage", "accueil_velo", "forfait_mobilite_durable", "mobilite_douce", "mobilite_douce_usager_occasionnel", "mobilite_douce_fournisseur"],
            "alimentation_faible_carbone" => ["type_alimentation", "soutien_vegetarien", "alimentation_saison", "approvisionnement_local"],
            "limiter_consommation_energie" => ["batiment_energie_positive","batiment_isolation_chaleur","dpe","eco_energie_tertiaire","temperature_raisonnable","fournisseur_energie_verte","energie_produite_site","sobriete_numerique","appareil_econome"]
        ],
        "biodiversite" => [
            "nature_tiers_lieux" => ["suivi_biodiversite"],
            "limitation_pression_biodiversite" => ["reduction_pollution_lumineuse", "reduction_pollution_sonore", "pratique_biodiversite"],
            "encourager_biodiversite" => ["colonisation_faune", "corridor_ecologique", "arbre_pleine_terre", "habitat_biodiversite", "encourage_diversite", "espace_vegetalise"]
        ],
        "environnement_physique" => [
            "limite_impact_sol" => ["fertilisation_chimique_bannie", "pesticide_chimique_banni", "culture_respectueuse", "agriculture_durable", "regeneration_sol", "ancienne_friche","refertilisation", "artificialisation_sol", "utilisation_projet_complementaire", "espace_modulable"],
            "qualite_quantite_eau" => ["reduction_consommation_eau", "toilette_seche", "captation_eau_pluie", "eau_economisee", "irrigation_limitee", "pollution_ressource_eau"],
            "qualite_air" => ["choix_peinture", "produit_entretien"]
        ],
        "sensibilisation_engagement" => [
            "sensibilisation_interne" => ["preservation_environnement", "strategie_environnementale", "label", "salarie_formes_enjeu_environnemental", "formation_solution", "mesure_quantitative"],
            "sensibilisation_usages" => ["intervention_sensibilisation", "contenu_sensibilisation", "communication_action"],
            "engagement" => ["association_tribune", "essaime_bonne_pratique", "connait_acteur_territoire", "partenariat_acteur_transition","aligne_engagement_territoire"]
        ]
    ];

    public static $words = [
        "réemploi" => ["reutilisation_objet", "equipement_reconditionne", "dechet_atelier_revalorise"],
        "partage" => ["equipement_partage"],
        "sobriété" => ["limitation_achat", "limitation_dechet", "eco_conception", "low_tech", "fontaine_eau", "reduction_consommation_eau"],
        "réparation" => ["reparation_objet"],
        "bâtiment" => ["equipement_reutilisable"],
        "alimentation locale" => ["distributeur_local", "alimentation_locale"],
        "responsabilité" => ["charte_selection_fournisseur", "optimisation_achat"],
        "vrac" => [
            "equipement_partage",
            "reparation_objet",
            "limitation_achat",
            "limitation_dechet",
            "equipement_reutilisable",
            "charte_selection_fournisseur",
            "optimisation_achat",
            "alimentation_locale",
            "demarche_zero_dechets",
            "low_tech",
            "eco_conception",
            "fontaine_eau",
            "bio_dechet",
            "recycle_dechet",
            "point_collecte_dechet",
            "distributeur_local"
        ],
        "recyclage" => ["bio_dechet", "recycle_dechet", "point_collecte_dechet"],

        "connaissance" => ["ges_identifie", "bilan_carbon_calcule", "suivi_biodiversite", "eau_economisee"],
        "stratégie" => ["strategie_enjeu_climatique", "preservation_environnement", "strategie_environnementale", "aligne_engagement_territoire"],
        "covoiturage" => ["covoiturage"],
        "mobilités douce" => ["accueil_velo","forfait_mobilite_durable","mobilite_douce","mobilite_douce_usager_occasionnel","mobilite_douce_fournisseur"],
        "alimentation durable" => ["type_alimentation", "soutien_vegetarien", "alimentation_saison", "approvisionnement_local", "culture_respectueuse", "agriculture_durable"],
        "construction" => ["batiment_energie_positive"],
        "isolation" => ["batiment_isolation_chaleur"],
        "énergie" => ["dpe", "eco_energie_tertiaire", "temperature_raisonnable", "fournisseur_energie_verte", "energie_produite_site", "appareil_econome"],
        "numérique" => ["sobriete_numerique"],

        "limitation des pollutions" => ["reduction_pollution_lumineuse", "reduction_pollution_sonore", "fertilisation_chimique_bannie", "pesticide_chimique_banni", "regeneration_sol", "pollution_ressource_eau"],
        "biodiversite" => ["colonisation_faune", "habitat_biodiversite", "corridor_ecologique", "encourage_diversite"],
        "végétalisation" => ["espace_vegetalise", "arbre_pleine_terre"],

        "zan" => ["ancienne_friche", "refertilisation", "refertilisation", "utilisation_projet_complementaire", "espace_modulable"],
        "eau" => ["toilette_seche", "captation_eau_pluie", "irrigation_limitee"],
        "santé" => ["choix_peinture", "produit_entretien"],

        "sensibilisation" => ["label", "intervention_sensibilisation", "contenu_sensibilisation", "communication_action"],
        "formation" => ["formation_solution", "salarie_formes_enjeu_environnemental"],
        "essaimer" => ["association_tribune", "essaime_bonne_pratique"],
        "ecosystème" => ["connait_acteur_territoire", "partenariat_acteur_transition"]
    ];

    public $ponderation = [
        "circularite_sobriete" => [
            "equipement_partage" => 1,
            "reutilisation_objet" => 1.5,
            "reparation_objet" => 1.5,
            "limitation_achat" => 1,
            "limitation_dechet" => 1,
            "equipement_reutilisable" => 1.5,
            "equipement_reconditionne" => 1,
            "charte_selection_fournisseur" => 1.5,
            "optimisation_achat" => 1,
            "alimentation_locale" => 1.5,
            "demarche_zero_dechets" => 1,
            "low_tech" => 1,
            "eco_conception" => 1,
            "fontaine_eau" => 0.5,
            "bio_dechet" => 1,
            "recycle_dechet" => 1.5,
            "dechet_atelier_revalorise" => 1,
            "point_collecte_dechet" => 1,
            "distributeur_local" => 1.5
        ],

        "emission_gaz_effet_serre" => [
            "ges_identifie" => 1,
            "bilan_carbon_calcule" => 1,
            "strategie_enjeu_climatique" => 1,
            "covoiturage" => 1.5,
            "accueil_velo" => 1.5,
            "forfait_mobilite_durable" => 1.5,
            "mobilite_douce" => 1,
            "mobilite_douce_usager_occasionnel" => 0.5,
            "mobilite_douce_fournisseur" => 1,
            "type_alimentation" => 1,
            "soutien_vegetarien" => 1.5,
            "alimentation_saison" => 1.5,
            "approvisionnement_local" => 1.5,
            "batiment_energie_positive" => 0.5,
            "batiment_isolation_chaleur" => 0.5,
            "dpe" => 0.5,
            "eco_energie_tertiaire" => 1,
            "temperature_raisonnable" => 1,
            "fournisseur_energie_verte" => 1,
            "energie_produite_site" => 1.5,
            "sobriete_numerique" => 1.5,
            "appareil_econome" => 1.5
        ],

        "biodiversite" => [
            "espace_exterieur" => 1,
            "suivi_biodiversite" => 1,
            "pratique_biodiversite" => 1.5,
            "colonisation_faune" => 1.5,
            "corridor_ecologique" => 0.5,
            "arbre_pleine_terre" => 1.5,
            "reduction_pollution_lumineuse" => 0.5,
            "reduction_pollution_sonore" => 0.5,
            "habitat_biodiversite" => 1,
            "encourage_diversite" => 1.5,
            "espace_vegetalise" => 1.5
        ],

        "environnement_physique" => [
            "fertilisation_chimique_bannie" => 1,
            "pesticide_chimique_banni" => 1,
            "culture_respectueuse" => 1.5,
            "agriculture_durable" => 1,
            "regeneration_sol" => 1,
            "ancienne_friche" => 1.5,
            "refertilisation" => 1,
            "artificialisation_sol" => 1,
            "utilisation_projet_complementaire" => 1.5,
            "espace_modulable" => 1,
            "reduction_consommation_eau" => 1.5,
            "toilette_seche" => 1,
            "captation_eau_pluie" => 1.5,
            "eau_economisee" => 1,
            "irrigation_limitee" => 1,
            "pollution_ressource_eau" => 1,
            "choix_peinture" => 1,
            "produit_entretien" => 1
        ],

        "sensibilisation_engagement" => [
            "preservation_environnement" => 0.5,
            "strategie_environnementale" => 1,
            "label" => 1,
            "salarie_formes_enjeu_environnemental" => 1,
            "formation_solution" => 1.5,
            "mesure_quantitative" => 1.5,
            "intervention_sensibilisation" => 1,
            "contenu_sensibilisation" => 1,
            "communication_action" => 0.5,
            "association_tribune" => 0.5,
            "essaime_bonne_pratique" => 1.5,
            "connait_acteur_territoire" => 1,
            "partenariat_acteur_transition" => 1.5,
            "aligne_engagement_territoire" => 1
        ]
    ];

    public $filter = [
        "emission_gaz_effet_serre" => [
            "filtered" => false,
            "questionFilter" => "restauration",
            "removeFromScore" => ["type_alimentation", "soutien_vegetarien", "alimentation_saison"],
        ],
        "biodiversité" => [
            "filtered" => false,
            "questionFilter" => "espace_exterieur",
            "removeFromScore" => ["suivi_biodiversite", "pratique_biodiversite", "colonisation_faune", "corridor_ecologique", "arbre_pleine_terre"],
        ],
        "environnement_physique" => [
            "filtered" => false,
            "questionFilter" => "activite_agricole",
            "removeFromScore" => ["fertilisation_chimique_bannie", "pesticide_chimique_banni", "culture_respectueuse", "irrigation_limitee"],
        ]
    ];

    public function calculateAnswerScore(PlaceEnvironment $placeEnvironment) {
        $score = [];

        $schema = json_decode(file_get_contents(storage_path().$this->schema), true);
        $typeform = json_decode(file_get_contents(storage_path().$this->questionnaire), true);

        foreach (self::$axes as $axe) {
            foreach ($schema["blocs"][$axe]["donnees"] as $question_key => $question_type) {
                $parts = explode('|', $question_type);
                list(, $question_id, $question_type) = $parts;

                $answer = $placeEnvironment->get("blocs->{$axe}->donnees->{$question_key}");

                if ($answer !== null) {
                    if (isset($this->filter[$axe]["questionFilter"]) && $this->filter[$axe]["questionFilter"] == $question_key && $answer === 'No') {
                        $this->filter[$axe]["filtered"] = true;
                        foreach($this->filter[$axe]["removeFromScore"] as $questionToRemove) {
                            unset($this->ponderation[$axe][$questionToRemove]);
                        }
                    }

                    switch ($question_type) {
                        // If yes 1 pts, 0 otherwise
                        case 'yes_no':
                            $score[$axe][$question_key] = ($answer === 'Yes') ? 1 : 0;
                            break;

                        // If the question is multiple_choice
                        // If it allows multiple selection, check if at least 50% of the proposed answers have been selected (1 pts), 0 otherwise
                        // If not, check which answer have been selected (first, second, third, fourth) and map it to the points [1, 0.75, 0.25, 0]
                        case 'multiple_choice':
                            $typeform_question = $this->findElementById($typeform['fields'], $question_id);

                            if (isset($typeform_question['properties']['allow_multiple_selection']) && is_array($answer)) {
                                if ($typeform_question['properties']['allow_multiple_selection']) {
                                    $choicesCount = count($typeform_question['properties']['choices']);
                                    $score[$axe][$question_key] = (count($answer) >= 0.5 * $choicesCount) ? 1 : 0;
                                } else {
                                    $pt = 0;
                                    // If the answer does not exists and is present in the filtered array, we skip it (=0)
                                    if (!isset($answer[0]) && $this->filter[$axe]["filtered"] === true && in_array($question_key, $this->filter[$axe]["removeFromScore"])) {
                                        $score[$axe][$question_key] = 0;
                                    } else {
                                        $typeform_question = $this->findElementById($typeform['fields'], $question_id);
                                        foreach ($typeform_question['properties']['choices'] as $index => $item) {
                                            if (stripos($answer[0], $item['label']) !== false) {
                                                $pt = [1, 0.75, 0.25, 0][$index];
                                                break;
                                            }
                                        }

                                        $score[$axe][$question_key] = $pt;
                                    }
                                }
                            }
                            break;
                    }
                }
            }
        }

        return $score;
    }

    public function calculateDimensionScore(array &$score) {
        $axes_totals = [];
        foreach (self::$axes as $axe) {
            // Calc each dimension score with the ponderation
            $sum = 0;
            foreach ($score[$axe] as $key => $answer_point) {
                $ponderated_answer_point = $answer_point * (isset($this->ponderation[$axe][$key]) ? $this->ponderation[$axe][$key] : 0);

                $score[$axe][$key] = $ponderated_answer_point;
                $sum += $ponderated_answer_point;
            }

            $axes_totals[$axe] = round(($sum / array_sum($this->ponderation[$axe])), 2);
        }
        return $axes_totals;
    }

    public function calculateSubDimensionScore(array $score) {
        $sub_axes_totals = [];
        foreach (self::$axes as $axe) {
            // Calc each sub-dimension (already ponderated before)
            foreach(self::$sub_axes[$axe] as $key => $sub_axe) {

                $ponderated_point_for_subaxe = array_sum(array_intersect_key($score[$axe], array_flip(self::$sub_axes[$axe][$key])));
                $ponderation_for_subaxe = array_sum(array_intersect_key($this->ponderation[$axe], array_flip(self::$sub_axes[$axe][$key])));

                $sub_axes_totals[$axe][$key] = round(($ponderated_point_for_subaxe / $ponderation_for_subaxe), 2);
            }
        }

        return $sub_axes_totals;
    }

    public function getWordsCloud(array $score) {
        // Calc words with ponderation
        foreach (self::$words as $key => $word) {

            $ponderated_point_for_word = array_sum(array_intersect_key(array_merge(...array_values($score)), array_flip(self::$words[$key])));
            $ponderation_for_word = array_sum(array_intersect_key(array_merge(...array_values($this->ponderation)), array_flip(self::$words[$key])));

            $words_total[$key] = round(($ponderated_point_for_word / $ponderation_for_word), 2);
        }

        $words_total = array_filter($words_total, function ($value) {
            return $value >= 0.75;
        });

        // Randomly select up to 8 elements
        $random_elements = array_rand($words_total, min(8, count($words_total)));

        // If only one element is selected, convert it to an array
        $random_elements = is_array($random_elements) ? $random_elements : [$random_elements];

        // Extract the selected elements from the original array
        $selected_words = array_intersect_key($words_total, array_flip($random_elements));

        foreach($selected_words as $key => $score) {
            $parent_key = $this->getParentKey(self::$words[$key][0], $this->ponderation);
            $size = 25 * $score;
            $selected_words[$key] = "<span class=\"$parent_key\" style=\"font-size: {$size}px; margin:0px 5px;\">{$key}</span>";
        }

        $selected_words = array_values($selected_words);

        shuffle($selected_words);

        return $selected_words;
    }

    private function getParentKey($keyToFind, $array) {
        foreach ($array as $parentKey => $subArray) {
            if (array_key_exists($keyToFind, $subArray)) {
                return $parentKey;
            }
        }
        return null;
    }

    private function findElementById($array, $id) {
        foreach ($array as $element) {
            if (isset($element['properties']) && is_array($element['properties']) && isset($element['properties']['fields']) && is_array($element['properties']['fields'])) {
                $result = $this->findElementById($element['properties']['fields'], $id);

                if ($result !== null) {
                    return $result;
                }
            }

            if (isset($element['id']) && $element['id'] == $id) {
                return $element;
            }
        }

        return null;
    }
}
