<?php

namespace App\Console\Commands;

ini_set('memory_limit', '256M');

use App\Mail\ImportCarbonSuccess;
use \stdClass;
use App\Services\CarbonFormDataExtractor;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class ImportTypeFormCarbon extends Command
{

    use ExtractTypeformValue;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:typeform_carbon
                                {file : json contenant les réponses d\'un répondant}
                                {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Importer les données reponses du typeform calculateur carbone";

    /**
     * Json Schema file
     *
     * @var string
     */
    protected $schema = '/app/places/schema_carbon.json';

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * answers file
     *
     * @var object
     */
    protected $answers;

    /**
     * token typeform
     *
     * @var string
     */
    protected $typeformToken;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logger = Log::channel('import_carbon');

        $token = getenv('TYPEFORM_TOKEN');
        if ($token === false) {
            throw new \LogicException('Token typeform non défini. Est-il renseigné dans le fichier .env ?');
        }

        $this->typeformToken = $token;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->logger->info("");
        $this->logger->info("---------------------------------------------------------------------------");
        $this->logger->info("------------------------------ Nouvel import ------------------------------");
        $this->logger->info("---------------------------------------------------------------------------");
        $this->logger->info("");

        if (file_exists(storage_path().$this->schema) === false) {
            $this->logger->alert("Schema file does not exists", ['schema' => storage_path().$this->schema]);
            throw new \Exception("Schema file does not exists : ".storage_path().$this->schema);
        }

        /** @var string $f */
        $f = $this->argument('file');
        $this->logger->info("Chargement du fichier ".realpath($f));

        if (file_exists(realpath($f)) === false) {
            $this->logger->alert("File does not exists", ['file' => realpath($f)]);
            throw new \Exception("File does not exists : ".realpath($f));
        }

        $schema = json_decode(file_get_contents(storage_path().$this->schema));
        $import_file = json_decode(file_get_contents($f));

        $this->answers = $import_file->answers;

        $place_name = $this->extract_val($schema->name, $this->answers, $this->logger);

        $pdfPath = 'reports/report_' .$place_name. '.pdf';

        if (Storage::disk('local')->exists($pdfPath) && $this->option('force') === false){
            $this->logger->notice($place_name." already imported. Use --force to overwrite.");
            die($place_name." already imported. Use --force to overwrite\n");
        }

        $extractor = new CarbonFormDataExtractor($this->answers, $this->logger);
        $extractedData = $extractor->processSchema($schema);
        $carbonData = $extractor->toObject($extractedData);

        $carbonEmission = new stdClass;

        /**
         *  ENERGIES
         */
        $coeffElectricite = ($carbonData->blocs->energie_consommation_fluide->fournisseur_energie_verte === true) ? 0.04 : 0.052;
        $carbonEmission->energie = new stdClass;
        $carbonEmission->energie->consommation_electricite = $carbonData->blocs->energie_consommation_fluide->consommation_electricite * $coeffElectricite;
        $carbonEmission->energie->consommation_gaz = $carbonData->blocs->energie_consommation_fluide->consommation_gaz * 0.205;
        $carbonEmission->energie->consommation_fioul = $carbonData->blocs->energie_consommation_fluide->consommation_fioul * 0.324;
        $carbonEmission->energie->consommation_bois_granule = $carbonData->blocs->energie_consommation_fluide->consommation_bois_granule * 0.0469;
        $carbonEmission->energie->consommation_bois_buche = $carbonData->blocs->energie_consommation_fluide->consommation_bois_buche * 284.97;

        if ($carbonData->blocs->energie_consommation_fluide->electricite_on_site === true) {
            $coeffTypeElectriciteMapping = [
                'Éolien terrestre' => 0.0141,
                'Hydraulique' => 0.006,
                'Géothermie' => 0.045,
                'Photovoltaïque (fabriqué en France)' => 0.0252,
                'Photovoltaïque (fabriqué en Europe)' => 0.0323,
                'Photovoltaïque (fabriqué en Chine)' => 0.0439,
            ];

            $coeffTypeElectricite = isset($coeffTypeElectriciteMapping[$carbonData->blocs->energie_consommation_fluide->type_electricite[0]]) ? $coeffTypeElectriciteMapping[$carbonData->blocs->energie_consommation_fluide->type_electricite[0]] : 0;
            $carbonEmission->energie->production_electricite = $carbonData->blocs->energie_consommation_fluide->production_electricite * $coeffTypeElectricite;
        }

        $carbonEmission->energie->total = $this->getTotal($carbonEmission->energie);

        $energieChartData = $this->generateChartData($carbonEmission->energie, ["Consommation en électricité", "Consommation en gaz", "Consommation en fioul", "Consommation en bois (granulés)", "Consommation en bois (bûches)"], ["production_electricite"], "kgCO2e");

        /**
         *  ALIMENTATION
         */
        $carbonEmission->alimentation = new stdClass;

        // Nouriture
        if ($carbonData->blocs->alimentation->restauration === true) {
            $carbonEmission->alimentation->nourriture = new stdClass;
            $carbonEmission->alimentation->nourriture->repas_vegetalien = $carbonData->blocs->alimentation->repas_vegetalien * 0.394;
            $carbonEmission->alimentation->nourriture->repas_vegetarien = $carbonData->blocs->alimentation->repas_vegetarien * 0.51;
            $carbonEmission->alimentation->nourriture->repas_viande_blanche = $carbonData->blocs->alimentation->repas_viande_blanche * 1.35;
            $carbonEmission->alimentation->nourriture->repas_viande_rouge = $carbonData->blocs->alimentation->repas_viande_rouge * 6.29;
            $carbonEmission->alimentation->nourriture->repas_poisson_gras = $carbonData->blocs->alimentation->repas_poisson_gras * 1.113;
            $carbonEmission->alimentation->nourriture->repas_poisson_blanc = $carbonData->blocs->alimentation->repas_poisson_blanc * 1.984;

            $seasonalProduct = [
                '0%' => 1.02,
                '25%' => 1.01,
                '50%' => 1,
                '75%' => 0.99,
                '100%' =>  0.98,
            ];

            $carbonEmission->alimentation->nourriture->total = $this->getTotal($carbonEmission->alimentation->nourriture);

            $coeffSeasonalProduct = isset($seasonalProduct[$carbonData->blocs->alimentation->part_produit_saison[0]]) ? $seasonalProduct[$carbonData->blocs->alimentation->part_produit_saison[0]] : 1;
            $carbonEmission->alimentation->nourriture->total *= $coeffSeasonalProduct;
        }

        // Boissons
        if ($carbonData->blocs->alimentation->debit_boisson === true) {
            $carbonEmission->alimentation->boisson = new stdClass;
            $carbonEmission->alimentation->boisson->cafe = $carbonData->blocs->alimentation->cafe * 0.059;
            $carbonEmission->alimentation->boisson->jus = $carbonData->blocs->alimentation->jus * 0.8;
            $carbonEmission->alimentation->boisson->soda = $carbonData->blocs->alimentation->soda * 0.57;
            $carbonEmission->alimentation->boisson->biere = $carbonData->blocs->alimentation->biere * 1.09;
            $carbonEmission->alimentation->boisson->vin = $carbonData->blocs->alimentation->vin * 1.14;
            $carbonEmission->alimentation->boisson->alcool_fort = $carbonData->blocs->alimentation->alcool_fort * 1.16;

            $carbonEmission->alimentation->boisson->total = $this->getTotal($carbonEmission->alimentation->boisson);
        }

        $carbonEmission->alimentation->total =
            (isset($carbonEmission->alimentation->nourriture->total) ? $carbonEmission->alimentation->nourriture->total : 0) +
            (isset($carbonEmission->alimentation->boisson->total) ? $carbonEmission->alimentation->boisson->total : 0);

        $foodChartData = $this->generateChartData($carbonEmission->alimentation->nourriture, ["Repas végétalien", "Repas végétarien", "Repas carné (viande blanche)", "Repas carné (viande rouge)", "Repas avec du poisson (gras)", "Repas avec du poisson (blanc)"]);
        $beverageChartData = $this->generateChartData($carbonEmission->alimentation->boisson, ["café", "jus", "soda", "biere", "vin", "alcool fort"]);
        $foodAndBeverageTotal = round($carbonEmission->alimentation->total, 2);


        /**
         *  TRANSPORT
         */
        $detailedTransportationCoeff = [
            'km_voiture_thermique' => 0.2176,
            'km_voiture_electrique' => 0.1034,
            'km_deux_roues_motorise' => 0.1913,
            'ter' => 0.02959,
            'tgv' => 0.00236,
            'avion' => 0.18746,
            'metro_tram_rer' => 0.00329,
            'bus' => 0.1466,
            'velo_electrique' => 0.01095,
            'bateau' =>  0.06
        ];

        $simplifiedTransportationCoeff = [
            "Centre-ville" => [
                "salarie_15km" => 0.09,
                "salarie_50km" => 0.12,
                "salarie_plus_50km" => 0.155
            ],
            "Zone périurbaine" => [
                "salarie_15km" => 0.1,
                "salarie_50km" => 0.13,
                "salarie_plus_50km" => 0.155
            ],
            "Zone rurale" => [
                "salarie_15km" => 0.1026,
                "salarie_50km" => 0.1026,
                "salarie_plus_50km" => 0.11
            ]
        ];

        /**
         *  DEPLACEMENT DOMICILE TRAVAIL
         */
        $carbonEmission->deplacement_domicile_travail = new stdClass;

        if (substr($carbonData->blocs->deplacement_domicile_travail->niveau_information[0], 0, strlen('Je connais')) === 'Je connais') {
            $carbonEmission->deplacement_domicile_travail->km_voiture_thermique = $carbonData->blocs->deplacement_domicile_travail->km_voiture_thermique * $detailedTransportationCoeff['km_voiture_thermique'];
            $carbonEmission->deplacement_domicile_travail->km_voiture_electrique = $carbonData->blocs->deplacement_domicile_travail->km_voiture_electrique * $detailedTransportationCoeff['km_voiture_electrique'];
            $carbonEmission->deplacement_domicile_travail->km_deux_roues_motorise = $carbonData->blocs->deplacement_domicile_travail->km_deux_roues_motorise * $detailedTransportationCoeff['km_deux_roues_motorise'];
            $carbonEmission->deplacement_domicile_travail->ter = $carbonData->blocs->deplacement_domicile_travail->ter * $detailedTransportationCoeff['ter'];
            $carbonEmission->deplacement_domicile_travail->tgv = $carbonData->blocs->deplacement_domicile_travail->tgv * $detailedTransportationCoeff['tgv'];
            $carbonEmission->deplacement_domicile_travail->metro_tram_rer = $carbonData->blocs->deplacement_domicile_travail->metro_tram_rer * $detailedTransportationCoeff['metro_tram_rer'];
            $carbonEmission->deplacement_domicile_travail->bus = $carbonData->blocs->deplacement_domicile_travail->bus * $detailedTransportationCoeff['bus'];
            $carbonEmission->deplacement_domicile_travail->velo_electrique = $carbonData->blocs->deplacement_domicile_travail->velo_electrique * $detailedTransportationCoeff['velo_electrique'];

            $carbonEmission->deplacement_domicile_travail->total = $this->getTotal($carbonEmission->deplacement_domicile_travail);

            $businessCommute = $this->generateChartData($carbonEmission->deplacement_domicile_travail, ["Voiture thermique", "Voiture électrique", "Deux roues motorisés", "TER", "TGV", "Métro / Tram / RER", "Bus", "Vélo électrique"]);
        } else {
            $nombrePersonne = $carbonData->blocs->deplacement_domicile_travail->nb_salaries;
            $nbRdv = $carbonData->blocs->deplacement_domicile_travail->rdv_site;
            $situationLieu = $carbonData->blocs->deplacement_domicile_travail->situation_lieu[0];

            $carbonEmission->deplacement_domicile_travail->salarie_15km = ($carbonData->blocs->deplacement_domicile_travail->salarie_15km / 100) * $simplifiedTransportationCoeff[$situationLieu]["salarie_15km"] * $nombrePersonne * $nbRdv * 45;
            $carbonEmission->deplacement_domicile_travail->salarie_50km = ($carbonData->blocs->deplacement_domicile_travail->salarie_50km / 100) * $simplifiedTransportationCoeff[$situationLieu]["salarie_50km"] * $nombrePersonne * $nbRdv * 45;
            $carbonEmission->deplacement_domicile_travail->salarie_plus_50km = ($carbonData->blocs->deplacement_domicile_travail->salarie_plus_50km / 100) * $simplifiedTransportationCoeff[$situationLieu]["salarie_plus_50km"] * $nombrePersonne * $nbRdv * 45;
            $carbonEmission->deplacement_domicile_travail->total = $this->getTotal($carbonEmission->deplacement_domicile_travail);

            $businessCommute = $this->generateChartData($carbonEmission->deplacement_domicile_travail, ["Salarié à moins de 15km", "Salarié entre 15km et 50km", "Salarié à plus de 50km"]);
        }

        /**
         *  DEPLACEMENT PROFESSIONNEL
         */
        $carbonEmission->deplacement_professionnel = new stdClass;

        $carbonEmission->deplacement_professionnel->km_voiture_thermique = $carbonData->blocs->deplacement_professionnel->km_voiture_thermique * $detailedTransportationCoeff['km_voiture_thermique'];
        $carbonEmission->deplacement_professionnel->km_voiture_electrique = $carbonData->blocs->deplacement_professionnel->km_voiture_electrique * $detailedTransportationCoeff['km_voiture_electrique'];
        $carbonEmission->deplacement_professionnel->km_deux_roues_motorise = $carbonData->blocs->deplacement_professionnel->km_deux_roues_motorise * $detailedTransportationCoeff['km_deux_roues_motorise'];
        $carbonEmission->deplacement_professionnel->avion = $carbonData->blocs->deplacement_professionnel->avion * $detailedTransportationCoeff['metro_tram_rer'];
        $carbonEmission->deplacement_professionnel->ter = $carbonData->blocs->deplacement_professionnel->ter * $detailedTransportationCoeff['ter'];
        $carbonEmission->deplacement_professionnel->tgv = $carbonData->blocs->deplacement_professionnel->tgv * $detailedTransportationCoeff['tgv'];
        $carbonEmission->deplacement_professionnel->metro_tram_rer = $carbonData->blocs->deplacement_professionnel->metro_tram_rer * $detailedTransportationCoeff['metro_tram_rer'];
        $carbonEmission->deplacement_professionnel->bus = $carbonData->blocs->deplacement_professionnel->bus * $detailedTransportationCoeff['bus'];
        $carbonEmission->deplacement_professionnel->velo_electrique = $carbonData->blocs->deplacement_professionnel->velo_electrique * $detailedTransportationCoeff['velo_electrique'];

        $carbonEmission->deplacement_professionnel->total = $this->getTotal($carbonEmission->deplacement_professionnel);

        $businessTrip = $this->generateChartData($carbonEmission->deplacement_professionnel, ["Voiture thermique", "Voiture électrique", "Deux roues motorisés", "TER", "TGV", "Métro / Tram / RER", "Bus", "Vélo électrique"]);

        /**
         *  DEPLACEMENT USAGERS REGULIERS
         */
        $carbonEmission->deplacement_usager_regulier = new stdClass;

        if (substr($carbonData->blocs->deplacement_usager_regulier->niveau_information[0], 0, strlen('Je connais')) === 'Je connais') {
            $carbonEmission->deplacement_usager_regulier->km_voiture_thermique = $carbonData->blocs->deplacement_usager_regulier->km_voiture_thermique * $detailedTransportationCoeff['km_voiture_thermique'];
            $carbonEmission->deplacement_usager_regulier->km_voiture_electrique = $carbonData->blocs->deplacement_usager_regulier->km_voiture_electrique * $detailedTransportationCoeff['km_voiture_electrique'];
            $carbonEmission->deplacement_usager_regulier->km_deux_roues_motorise = $carbonData->blocs->deplacement_usager_regulier->km_deux_roues_motorise * $detailedTransportationCoeff['km_deux_roues_motorise'];
            $carbonEmission->deplacement_usager_regulier->ter = $carbonData->blocs->deplacement_usager_regulier->ter * $detailedTransportationCoeff['ter'];
            $carbonEmission->deplacement_usager_regulier->tgv = $carbonData->blocs->deplacement_usager_regulier->tgv * $detailedTransportationCoeff['tgv'];
            $carbonEmission->deplacement_usager_regulier->metro_tram_rer = $carbonData->blocs->deplacement_usager_regulier->metro_tram_rer * $detailedTransportationCoeff['metro_tram_rer'];
            $carbonEmission->deplacement_usager_regulier->bus = $carbonData->blocs->deplacement_usager_regulier->bus * $detailedTransportationCoeff['bus'];
            $carbonEmission->deplacement_usager_regulier->velo_electrique = $carbonData->blocs->deplacement_usager_regulier->velo_electrique * $detailedTransportationCoeff['velo_electrique'];

            $carbonEmission->deplacement_usager_regulier->total = $this->getTotal($carbonEmission->deplacement_usager_regulier);

            $visitorCommute = $this->generateChartData($carbonEmission->deplacement_usager_regulier, ["Voiture thermique", "Voiture électrique", "Deux roues motorisés", "TER", "TGV", "Métro / Tram / RER", "Bus", "Vélo électrique"]);
        } else {
            $nombrePersonne = $carbonData->blocs->deplacement_usager_regulier->nb_salaries;
            $nbRdv = $carbonData->blocs->deplacement_usager_regulier->rdv_site;
            $situationLieu = $carbonData->blocs->deplacement_usager_regulier->situation_lieu[0];

            $carbonEmission->deplacement_usager_regulier->salarie_15km = ($carbonData->blocs->deplacement_usager_regulier->salarie_15km / 100) * $simplifiedTransportationCoeff[$situationLieu]["salarie_15km"] * $nombrePersonne * $nbRdv * 45;
            $carbonEmission->deplacement_usager_regulier->salarie_50km = ($carbonData->blocs->deplacement_usager_regulier->salarie_50km / 100) * $simplifiedTransportationCoeff[$situationLieu]["salarie_50km"] * $nombrePersonne * $nbRdv * 45;
            $carbonEmission->deplacement_usager_regulier->salarie_plus_50km = ($carbonData->blocs->deplacement_usager_regulier->salarie_plus_50km / 100) * $simplifiedTransportationCoeff[$situationLieu]["salarie_plus_50km"] * $nombrePersonne * $nbRdv * 45;
            $carbonEmission->deplacement_usager_regulier->total = $this->getTotal($carbonEmission->deplacement_usager_regulier);

            $visitorCommute = $this->generateChartData($carbonEmission->deplacement_usager_regulier, ["Usagers à moins de 15km", "Usagers entre 15km et 50km", "Usagers à plus de 50km"]);
        }

        /**
         *  DEPLACEMENT VISITEURS
         */
        $carbonEmission->deplacement_visiteurs = new stdClass;

        $nombrePersonne = $carbonData->blocs->deplacement_visiteurs->nombre;
        $situationLieu = $carbonData->blocs->deplacement_visiteurs->situation_lieu[0];

        $carbonEmission->deplacement_visiteurs->visiteur_15km = ($carbonData->blocs->deplacement_visiteurs->visiteur_15km / 100) * $simplifiedTransportationCoeff[$situationLieu]["salarie_15km"] * $nombrePersonne * 45;
        $carbonEmission->deplacement_visiteurs->visiteur_50km = ($carbonData->blocs->deplacement_visiteurs->visiteur_50km / 100) * $simplifiedTransportationCoeff[$situationLieu]["salarie_50km"] * $nombrePersonne * 45;
        $carbonEmission->deplacement_visiteurs->visiteur_plus_50km = ($carbonData->blocs->deplacement_visiteurs->visiteur_plus_50km / 100) * $simplifiedTransportationCoeff[$situationLieu]["salarie_plus_50km"] * $nombrePersonne * 45;
        $carbonEmission->deplacement_visiteurs->total = $this->getTotal($carbonEmission->deplacement_visiteurs);

        $visitorTrip = $this->generateChartData($carbonEmission->deplacement_visiteurs, ["Visiteurs à moins de 15km", "Visiteurs entre 15km et 50km", "Visiteurs à plus de 50km"]);

        /**
         *  ACHATS
         */
        $carbonEmission->achats = new stdClass;
        $carbonEmission->achats->divers = new stdClass;

        $carbonEmission->achats->divers->meuble = $carbonData->blocs->achat->meuble * 0.6;
        $carbonEmission->achats->divers->petite_fourniture = $carbonData->blocs->achat->petite_fourniture * 0.367;
        $carbonEmission->achats->divers->produit_edition = $carbonData->blocs->achat->produit_edition * 0.28;
        $carbonEmission->achats->divers->produit_chimique = $carbonData->blocs->achat->produit_chimique * 1.6;
        $carbonEmission->achats->divers->produit_informatique = $carbonData->blocs->achat->produit_informatique * 0.4;
        $carbonEmission->achats->divers->produit_metallique = $carbonData->blocs->achat->produit_metallique * 0.6;
        $carbonEmission->achats->divers->textile = $carbonData->blocs->achat->textile * 0.6;
        $carbonEmission->achats->divers->total = $this->getTotal($carbonEmission->achats->divers);

        $purchase = $this->generateChartData($carbonEmission->achats->divers, ["Meuble", "Petites fournitures", "Produits d'édition", "Produits chimiques", "Produits informatiques", "Textile"]);

        if ($carbonData->blocs->achat->materiaux === true) {
            $carbonEmission->achats->materiaux = new stdClass;

            $carbonEmission->achats->materiaux->bois = $carbonData->blocs->achat->bois * 36.7;
            $carbonEmission->achats->materiaux->metaux_neufs = $carbonData->blocs->achat->metaux_neufs * 2210;
            $carbonEmission->achats->materiaux->metaux_recycles = $carbonData->blocs->achat->metaux_recycles * 938;
            $carbonEmission->achats->materiaux->plastique_neuf = $carbonData->blocs->achat->plastique_neuf * 2383;
            $carbonEmission->achats->materiaux->plastique_recycle = $carbonData->blocs->achat->plastique_recycle * 202;
            $carbonEmission->achats->materiaux->verre_neuf = $carbonData->blocs->achat->verre_neuf * 0.923;
            $carbonEmission->achats->materiaux->verre_recycle = $carbonData->blocs->achat->verre_recycle * 0.409;
            $carbonEmission->achats->materiaux->papier_neuf = $carbonData->blocs->achat->papier_neuf * 297;
            $carbonEmission->achats->materiaux->papier_recycle = $carbonData->blocs->achat->papier_recycle * 317;
            $carbonEmission->achats->materiaux->carton_neuf = $carbonData->blocs->achat->carton_neuf * 390;
            $carbonEmission->achats->materiaux->carton_recycle = $carbonData->blocs->achat->carton_recycle * 670;
            $carbonEmission->achats->materiaux->beton = $carbonData->blocs->achat->beton * 155;
            $carbonEmission->achats->materiaux->enrobe = $carbonData->blocs->achat->enrobe * 55.1;

            $carbonEmission->achats->materiaux->total = $this->getTotal($carbonEmission->achats->materiaux);

            $purchaseMaterial = $this->generateChartData(
                $carbonEmission->achats->materiaux,
                ["Bois", "Métaux neufs", "Métaux recyclés", "Plastiques neufs", "Plastiques recyclés", "Verres neufs", "Verres recyclés", "Papier neuf", "Papier recyclés", "Cartons neuf", "Cartons recyclés", "Béton", "Enrobé"]
            );
        }

        $carbonEmission->achats->total = $carbonEmission->achats->divers->total + (isset($carbonEmission->achats->materiaux->total) ? $carbonEmission->achats->materiaux->total : 0);

        /**
         *  FRET
         */
        $carbonEmission->fret = new stdClass;
        if ($carbonData->blocs->fret->vehicule === true) {
            $carbonEmission->fret->vehicule = new stdClass;
            $carbonEmission->fret->vehicule->km_poids_lourds = $carbonData->blocs->fret->km_poids_lourds * 0.95;
            $carbonEmission->fret->vehicule->km_utilitaire_thermique = $carbonData->blocs->fret->km_utilitaire_thermique * 0.26;
            $carbonEmission->fret->vehicule->km_utilitaire_electrique = $carbonData->blocs->fret->km_utilitaire_electrique * 0.147;
            $carbonEmission->fret->vehicule->km_velo_cargo = $carbonData->blocs->fret->km_velo_cargo * 0.04;
            $carbonEmission->fret->vehicule->total = $this->getTotal($carbonEmission->fret->vehicule);

            $fretVehicule = $this->generateChartData($carbonEmission->fret->vehicule, ["Poids lourds", "Utilitaires thermiques", "Utilitaires electriques"]);
        }

        $carbonEmission->fret->import = 0;
        if ($carbonData->blocs->fret->transporteur_import === true) {
            $carbonEmission->fret->import = ($carbonData->blocs->fret->poids_livraison_import / 1000) * $carbonData->blocs->fret->distance_livraison_import * $carbonData->blocs->fret->nombre_livraisons_import * 0.267;
        }

        $carbonEmission->fret->export = 0;
        if ($carbonData->blocs->fret->transporteur_export === true) {
            $carbonEmission->fret->export = ($carbonData->blocs->fret->poids_livraison_export / 1000) * $carbonData->blocs->fret->distance_livraison_export * $carbonData->blocs->fret->nombre_livraisons_export * 0.267;
        }

        $carbonEmission->fret->total =
            (isset($carbonEmission->fret->vehicule->total) ? $carbonEmission->fret->vehicule->total : 0) +
            (isset($carbonEmission->fret->import) ? $carbonEmission->fret->import : 0) +
            (isset($carbonEmission->fret->export) ? $carbonEmission->fret->export : 0);

        $fret = [
            "type" => "doughnut",
            "data" => [
                "labels" => ["Véhicules", "Import", 'Export'],
                "datasets" => [["data" => [$carbonEmission->fret->vehicule->total, $carbonEmission->fret->import, $carbonEmission->fret->export]]]
            ],
            "options" => [
                "plugins" => [
                    "doughnutlabel" => [
                        "labels" => [
                            ["text" => $this->roundNum($carbonEmission->fret->total), "font" => ["size" => 20]],
                            ["text" => "total"]
                        ]
                    ]
                ]
            ]
        ];

        /**
         *  DECHETS
         */
        $carbonEmission->dechets = new stdClass;
        $carbonEmission->dechets->qte_ordure_menagere = $carbonData->blocs->dechets->qte_ordure_menagere * 374;
        $carbonEmission->dechets->qte_ordure_tri = $carbonData->blocs->dechets->qte_ordure_tri * 1923;
        $carbonEmission->dechets->qte_verre = $carbonData->blocs->dechets->qte_verre * 496;
        $carbonEmission->dechets->qte_dechet_organique = $carbonData->blocs->dechets->qte_dechet_organique * 140;
        $carbonEmission->dechets->qte_bois = $carbonData->blocs->dechets->qte_bois * 269;
        $carbonEmission->dechets->qte_metaux = $carbonData->blocs->dechets->qte_metaux * 938;
        $carbonEmission->dechets->total = $this->getTotal($carbonEmission->dechets);

        $dechets = $this->generateChartData($carbonEmission->dechets, ["Ordures ménagères", "Ordures tri", "Verres", "Déchets organiques", "Bois", "Métaux"]);

        /**
         *  IMMOBILISATIONS
         */
        $carbonEmission->immobilisations = new stdClass;

        // Vehicules
        $carbonEmission->immobilisations->vehicules = ($carbonData->blocs->immobilisations->nombre_voiture * 1233 / 1000) * (5500 / $carbonData->blocs->immobilisations->age_vehicules);

        // Numérique
        $carbonEmission->immobilisations->numerique = new stdClass;
        $carbonEmission->immobilisations->numerique->nombre_ordinateur_fixe = $carbonData->blocs->immobilisations->nombre_ordinateur_fixe * 169;
        $carbonEmission->immobilisations->numerique->nombre_ordinateur_portable = $carbonData->blocs->immobilisations->nombre_ordinateur_portable * 156.24;
        $carbonEmission->immobilisations->numerique->nombre_ecran = $carbonData->blocs->immobilisations->nombre_ecran * 340.04;
        $carbonEmission->immobilisations->numerique->nombre_telephone = $carbonData->blocs->immobilisations->nombre_telephone * 27.5934;
        $carbonEmission->immobilisations->numerique->nombre_imprimante = $carbonData->blocs->immobilisations->nombre_imprimante * 600;
        $carbonEmission->immobilisations->numerique->nombre_serveur_informatique = $carbonData->blocs->immobilisations->nombre_serveur_informatique * 87.84;

        $subTotal = $this->getTotal($carbonEmission->immobilisations->numerique);

        $coeffReconditionne = [
            "Non, pas du tout" => 1,
            "Oui, mais dans une moindre mesure" => 0.8,
            "Oui, en grande partie" => 0.5,
            "Oui, totalement" => 0.3
        ];

        $carbonEmission->immobilisations->numerique->total = ($subTotal / $carbonData->blocs->immobilisations->temps_conservation_peripheriques) * $coeffReconditionne[$carbonData->blocs->immobilisations->peripheriques_reconditionne[0]];
        $immobilisationNumerique = $this->generateChartData($carbonEmission->immobilisations->numerique, ["Ordinateurs fixes", "Ordinateurs portables", "Verres", "Déchets organiques", "Bois", "Métaux"]);

        // Electromenager
        $carbonEmission->immobilisations->electromenager = new stdClass;
        $carbonEmission->immobilisations->electromenager->nombre_petit_electromenager = $carbonData->blocs->immobilisations->nombre_petit_electromenager * 60;
        $carbonEmission->immobilisations->electromenager->nombre_electromenager = $carbonData->blocs->immobilisations->nombre_electromenager * 300;
        $carbonEmission->immobilisations->electromenager->nombre_electromenager_pro = $carbonData->blocs->immobilisations->nombre_electromenager_pro * 900;
        $subTotal = $this->getTotal($carbonEmission->immobilisations->electromenager);

        $carbonEmission->immobilisations->electromenager->total = ($subTotal / $carbonData->blocs->immobilisations->temps_conservation_electromenager) * $coeffReconditionne[$carbonData->blocs->immobilisations->electromenager_reconditionne[0]];

        $carbonEmission->immobilisations->total = $carbonEmission->immobilisations->electromenager->total + $carbonEmission->immobilisations->numerique->total + $carbonEmission->immobilisations->vehicules;

        /**
         *  AUTRES EMISSIONS
         */

        $carbonEmission->autres_emissions = new stdClass;
        $carbonEmission->autres_emissions->total = 0;

        if ($carbonData->blocs->autres_emissions->prestation_externe === true) {
            $carbonEmission->autres_emissions->depense_service_assurance = $carbonData->blocs->autres_emissions->depense_service_assurance * 0.11;
            $carbonEmission->autres_emissions->depense_service_telecom = $carbonData->blocs->autres_emissions->depense_service_telecom * 0.17;
            $carbonEmission->autres_emissions->depense_service_courrier = $carbonData->blocs->autres_emissions->depense_service_courrier * 0.13;

            $carbonEmission->autres_emissions->total = $this->getTotal($carbonEmission->autres_emissions);

            $autres = $this->generateChartData($carbonEmission->autres_emissions, ["Services assurances", "Services télécommunication", "Services courriers"], ["prestation_externe"]);
        }

        $generalEmission = $carbonEmission->energie->total +
                           $foodAndBeverageTotal+$carbonEmission->deplacement_domicile_travail->total +
                           $carbonEmission->deplacement_professionnel->total +
                           $carbonEmission->deplacement_usager_regulier->total +
                           $carbonEmission->achats->total +
                           $carbonEmission->fret->total +
                           $carbonEmission->dechets->total +
                           $carbonEmission->immobilisations->total +
                           $carbonEmission->autres_emissions->total;
        $generalData = [
            "type" => "doughnut",
            "data" => [
                "labels" => ["Énergie", "Alimentation", "Transports", "Achats", "Fret", "Déchets", "Immobilisations", "Autres"],
                "datasets" => [["data" => [
                    $this->roundNum($carbonEmission->energie->total),
                    $this->roundNum($foodAndBeverageTotal),
                    $this->roundNum(($carbonEmission->deplacement_domicile_travail->total+$carbonEmission->deplacement_professionnel->total+$carbonEmission->deplacement_usager_regulier->total)),
                    $this->roundNum($carbonEmission->achats->total),
                    $this->roundNum($carbonEmission->fret->total),
                    $this->roundNum($carbonEmission->dechets->total),
                    $this->roundNum($carbonEmission->immobilisations->total),
                    $this->roundNum($carbonEmission->autres_emissions->total)
                ]]]
            ],
        ];

        $data = [
            'generalChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($generalData)),
            'generalEmission' => $this->roundNum($generalEmission),
            'energyChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($energieChartData)),
            'foodChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($foodChartData)),
            'beverageChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($beverageChartData)),
            'foodAndBeverageTotal' => $foodAndBeverageTotal,
            'businessCommuteChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($businessCommute)),
            'businessTripChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($businessTrip)),
            'visitorCommuteChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($visitorCommute)),
            'visitorTripChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($visitorTrip)),
            'purchaseMaterialChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($purchaseMaterial)),
            'purchaseChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($purchase)),
            'fretVehiculeChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($fretVehicule)),
            'fretChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($fret)),
            'dechetsChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($dechets)),
            'immobilisationNumeriqueChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($immobilisationNumerique)),
            'immobilisationTotal' =>  $carbonEmission->immobilisations->total,
            'autresChart' => "https://quickchart.io/chart?c=" . urlencode(json_encode($autres)),
        ];

        // Render PDF
        $pdf = Pdf::loadView('reports.carbon', $data);

        // Save the PDF
        Storage::put($pdfPath, $pdf->output());

        $this->info("PDF generated: " . storage_path("app/" . $pdfPath));

        $email = $this->extract_val($schema->blocs->presentation->email, $this->answers, $this->logger);
        if ($email !== null && $email !== '') {
            try {
                $this->logger->info('Sending mail to '. $email);
                Mail::send(new ImportCarbonSuccess($email, $place_name, storage_path("app/" . $pdfPath)));
                $this->logger->info('Sent');
            } catch (\Exception $e) {
                $this->logger->emergency('Failed to send mail : '.$e->getMessage());
                die("Can't send email to : ".$place_name.". Check file ".realpath($f)." for email address");
            }
        }

        return;
    }

    private function getTotal($category) {
        $total = 0;
        foreach ($category as $key => $value) {
            if ($key !== 'total' && is_numeric($value)) {
                $total += $value;
            }
        }
        return $total;
    }

    private function roundNum($number) {
        return round($number, 2);
    }

    private function generateChartData(object $providedData, array $labels, array $keysToIgnore = []) {
        $data = [];

        foreach (get_object_vars($providedData) as $key => $value) {
            if ($key !== 'total' && !in_array($key, $keysToIgnore)) {
                $data[] = $this->roundNum($value);
            }
        }

        return [
            "type" => "doughnut",
            "data" => [
                "labels" => $labels,
                "datasets" => [["data" => $data]]
            ],
            "options" => [
                "plugins" => [
                    "doughnutlabel" => [
                        "labels" => [
                            ["text" => $this->roundNum($providedData->total), "font" => ["size" => 20]],
                            ["text" => "kgCO2e"]
                        ]
                    ]
                ]
            ]
        ];
    }
}
