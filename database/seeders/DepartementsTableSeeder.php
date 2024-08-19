<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartementsTableSeeder extends Seeder
{
    public function run()
    {
        $departements = [
            // Auvergne-Rhône-Alpes
            ['name' => 'Ain', 'region_id' => 1, 'zipcode_start' => 1000, 'zipcode_end' => 1999],
            ['name' => 'Allier', 'region_id' => 1, 'zipcode_start' => 3000, 'zipcode_end' => 3999],
            ['name' => 'Ardèche', 'region_id' => 1, 'zipcode_start' => 7000, 'zipcode_end' => 7999],
            ['name' => 'Cantal', 'region_id' => 1, 'zipcode_start' => 15000, 'zipcode_end' => 15999],
            ['name' => 'Drôme', 'region_id' => 1, 'zipcode_start' => 26000, 'zipcode_end' => 26999],
            ['name' => 'Isère', 'region_id' => 1, 'zipcode_start' => 38000, 'zipcode_end' => 38999],
            ['name' => 'Loire', 'region_id' => 1, 'zipcode_start' => 42000, 'zipcode_end' => 42999],
            ['name' => 'Haute-Loire', 'region_id' => 1, 'zipcode_start' => 43000, 'zipcode_end' => 43999],
            ['name' => 'Rhône', 'region_id' => 1, 'zipcode_start' => 69000, 'zipcode_end' => 69999],
            ['name' => 'Savoie', 'region_id' => 1, 'zipcode_start' => 73000, 'zipcode_end' => 73999],
            ['name' => 'Haute-Savoie', 'region_id' => 1, 'zipcode_start' => 74000, 'zipcode_end' => 74999],

            // Bourgogne-Franche-Comté
            ['name' => 'Côte-d\'Or', 'region_id' => 2, 'zipcode_start' => 21000, 'zipcode_end' => 21999],
            ['name' => 'Doubs', 'region_id' => 2, 'zipcode_start' => 25000, 'zipcode_end' => 25999],
            ['name' => 'Jura', 'region_id' => 2, 'zipcode_start' => 39000, 'zipcode_end' => 39999],
            ['name' => 'Nièvre', 'region_id' => 2, 'zipcode_start' => 58000, 'zipcode_end' => 58999],
            ['name' => 'Haute-Saône', 'region_id' => 2, 'zipcode_start' => 70000, 'zipcode_end' => 70999],
            ['name' => 'Saône-et-Loire', 'region_id' => 2, 'zipcode_start' => 71000, 'zipcode_end' => 71999],
            ['name' => 'Yonne', 'region_id' => 2, 'zipcode_start' => 89000, 'zipcode_end' => 89999],
            ['name' => 'Territoire de Belfort', 'region_id' => 2, 'zipcode_start' => 90000, 'zipcode_end' => 90999],

            // Bretagne
            ['name' => 'Côtes-d\'Armor', 'region_id' => 3, 'zipcode_start' => 22000, 'zipcode_end' => 22999],
            ['name' => 'Finistère', 'region_id' => 3, 'zipcode_start' => 29000, 'zipcode_end' => 29999],
            ['name' => 'Ille-et-Vilaine', 'region_id' => 3, 'zipcode_start' => 35000, 'zipcode_end' => 35999],
            ['name' => 'Morbihan', 'region_id' => 3, 'zipcode_start' => 56000, 'zipcode_end' => 56999],

            // Centre-Val de Loire
            ['name' => 'Cher', 'region_id' => 4, 'zipcode_start' => 18000, 'zipcode_end' => 18999],
            ['name' => 'Eure-et-Loir', 'region_id' => 4, 'zipcode_start' => 28000, 'zipcode_end' => 28999],
            ['name' => 'Indre', 'region_id' => 4, 'zipcode_start' => 36000, 'zipcode_end' => 36999],
            ['name' => 'Indre-et-Loire', 'region_id' => 4, 'zipcode_start' => 37000, 'zipcode_end' => 37999],
            ['name' => 'Loir-et-Cher', 'region_id' => 4, 'zipcode_start' => 41000, 'zipcode_end' => 41999],
            ['name' => 'Loiret', 'region_id' => 4, 'zipcode_start' => 45000, 'zipcode_end' => 45999],

            // Corse
            ['name' => 'Corse-du-Sud', 'region_id' => 5, 'zipcode_start' => 20000, 'zipcode_end' => 20999],
            ['name' => 'Haute-Corse', 'region_id' => 5, 'zipcode_start' => 20200, 'zipcode_end' => 20620],

            // Grand Est
            ['name' => 'Ardennes', 'region_id' => 6, 'zipcode_start' => 8000, 'zipcode_end' => 8999],
            ['name' => 'Aube', 'region_id' => 6, 'zipcode_start' => 10000, 'zipcode_end' => 10999],
            ['name' => 'Marne', 'region_id' => 6, 'zipcode_start' => 51000, 'zipcode_end' => 51999],
            ['name' => 'Haute-Marne', 'region_id' => 6, 'zipcode_start' => 52000, 'zipcode_end' => 52999],
            ['name' => 'Meurthe-et-Moselle', 'region_id' => 6, 'zipcode_start' => 54000, 'zipcode_end' => 54999],
            ['name' => 'Meuse', 'region_id' => 6, 'zipcode_start' => 55000, 'zipcode_end' => 55999],
            ['name' => 'Moselle', 'region_id' => 6, 'zipcode_start' => 57000, 'zipcode_end' => 57999],
            ['name' => 'Bas-Rhin', 'region_id' => 6, 'zipcode_start' => 67000, 'zipcode_end' => 67999],
            ['name' => 'Haut-Rhin', 'region_id' => 6, 'zipcode_start' => 68000, 'zipcode_end' => 68999],
            ['name' => 'Vosges', 'region_id' => 6, 'zipcode_start' => 88000, 'zipcode_end' => 88999],

            // Hauts-de-France
            ['name' => 'Aisne', 'region_id' => 7, 'zipcode_start' => 2000, 'zipcode_end' => 2999],
            ['name' => 'Nord', 'region_id' => 7, 'zipcode_start' => 59000, 'zipcode_end' => 59999],
            ['name' => 'Oise', 'region_id' => 7, 'zipcode_start' => 60000, 'zipcode_end' => 60999],
            ['name' => 'Pas-de-Calais', 'region_id' => 7, 'zipcode_start' => 62000, 'zipcode_end' => 62999],
            ['name' => 'Somme', 'region_id' => 7, 'zipcode_start' => 80000, 'zipcode_end' => 80999],

            // Île-de-France
            ['name' => 'Paris', 'region_id' => 8, 'zipcode_start' => 75000, 'zipcode_end' => 75999],
            ['name' => 'Seine-et-Marne', 'region_id' => 8, 'zipcode_start' => 77000, 'zipcode_end' => 77999],
            ['name' => 'Yvelines', 'region_id' => 8, 'zipcode_start' => 78000, 'zipcode_end' => 78999],
            ['name' => 'Essonne', 'region_id' => 8, 'zipcode_start' => 91000, 'zipcode_end' => 91999],
            ['name' => 'Hauts-de-Seine', 'region_id' => 8, 'zipcode_start' => 92000, 'zipcode_end' => 92999],
            ['name' => 'Seine-Saint-Denis', 'region_id' => 8, 'zipcode_start' => 93000, 'zipcode_end' => 93999],
            ['name' => 'Val-de-Marne', 'region_id' => 8, 'zipcode_start' => 94000, 'zipcode_end' => 94999],
            ['name' => 'Val-d\'Oise', 'region_id' => 8, 'zipcode_start' => 95000, 'zipcode_end' => 95999],

            // Normandie
            ['name' => 'Calvados', 'region_id' => 9, 'zipcode_start' => 14000, 'zipcode_end' => 14999],
            ['name' => 'Eure', 'region_id' => 9, 'zipcode_start' => 27000, 'zipcode_end' => 27999],
            ['name' => 'Manche', 'region_id' => 9, 'zipcode_start' => 50000, 'zipcode_end' => 50999],
            ['name' => 'Orne', 'region_id' => 9, 'zipcode_start' => 61000, 'zipcode_end' => 61999],
            ['name' => 'Seine-Maritime', 'region_id' => 9, 'zipcode_start' => 76000, 'zipcode_end' => 76999],

            // Nouvelle-Aquitaine
            ['name' => 'Charente', 'region_id' => 10, 'zipcode_start' => 16000, 'zipcode_end' => 16999],
            ['name' => 'Charente-Maritime', 'region_id' => 10, 'zipcode_start' => 17000, 'zipcode_end' => 17999],
            ['name' => 'Corrèze', 'region_id' => 10, 'zipcode_start' => 19000, 'zipcode_end' => 19999],
            ['name' => 'Creuse', 'region_id' => 10, 'zipcode_start' => 23000, 'zipcode_end' => 23999],
            ['name' => 'Dordogne', 'region_id' => 10, 'zipcode_start' => 24000, 'zipcode_end' => 24999],
            ['name' => 'Gironde', 'region_id' => 10, 'zipcode_start' => 33000, 'zipcode_end' => 33999],
            ['name' => 'Landes', 'region_id' => 10, 'zipcode_start' => 40000, 'zipcode_end' => 40999],
            ['name' => 'Lot-et-Garonne', 'region_id' => 10, 'zipcode_start' => 47000, 'zipcode_end' => 47999],
            ['name' => 'Pyrénées-Atlantiques', 'region_id' => 10, 'zipcode_start' => 64000, 'zipcode_end' => 64999],
            ['name' => 'Deux-Sèvres', 'region_id' => 10, 'zipcode_start' => 79000, 'zipcode_end' => 79999],
            ['name' => 'Vienne', 'region_id' => 10, 'zipcode_start' => 86000, 'zipcode_end' => 86999],
            ['name' => 'Haute-Vienne', 'region_id' => 10, 'zipcode_start' => 87000, 'zipcode_end' => 87999],

            // Occitanie
            ['name' => 'Ariège', 'region_id' => 11, 'zipcode_start' => 9000, 'zipcode_end' => 9999],
            ['name' => 'Aude', 'region_id' => 11, 'zipcode_start' => 11000, 'zipcode_end' => 11999],
            ['name' => 'Aveyron', 'region_id' => 11, 'zipcode_start' => 12000, 'zipcode_end' => 12999],
            ['name' => 'Gard', 'region_id' => 11, 'zipcode_start' => 30000, 'zipcode_end' => 30999],
            ['name' => 'Haute-Garonne', 'region_id' => 11, 'zipcode_start' => 31000, 'zipcode_end' => 31999],
            ['name' => 'Gers', 'region_id' => 11, 'zipcode_start' => 32000, 'zipcode_end' => 32999],
            ['name' => 'Hérault', 'region_id' => 11, 'zipcode_start' => 34000, 'zipcode_end' => 34999],
            ['name' => 'Lot', 'region_id' => 11, 'zipcode_start' => 46000, 'zipcode_end' => 46999],
            ['name' => 'Lozère', 'region_id' => 11, 'zipcode_start' => 48000, 'zipcode_end' => 48999],
            ['name' => 'Hautes-Pyrénées', 'region_id' => 11, 'zipcode_start' => 65000, 'zipcode_end' => 65999],
            ['name' => 'Pyrénées-Orientales', 'region_id' => 11, 'zipcode_start' => 66000, 'zipcode_end' => 66999],
            ['name' => 'Tarn', 'region_id' => 11, 'zipcode_start' => 81000, 'zipcode_end' => 81999],
            ['name' => 'Tarn-et-Garonne', 'region_id' => 11, 'zipcode_start' => 82000, 'zipcode_end' => 82999],

            // Pays de la Loire
            ['name' => 'Loire-Atlantique', 'region_id' => 12, 'zipcode_start' => 44000, 'zipcode_end' => 44999],
            ['name' => 'Maine-et-Loire', 'region_id' => 12, 'zipcode_start' => 49000, 'zipcode_end' => 49999],
            ['name' => 'Mayenne', 'region_id' => 12, 'zipcode_start' => 53000, 'zipcode_end' => 53999],
            ['name' => 'Sarthe', 'region_id' => 12, 'zipcode_start' => 72000, 'zipcode_end' => 72999],
            ['name' => 'Vendée', 'region_id' => 12, 'zipcode_start' => 85000, 'zipcode_end' => 85999],

            // Provence-Alpes-Côte d'Azur
            ['name' => 'Alpes-de-Haute-Provence', 'region_id' => 13, 'zipcode_start' => 4000, 'zipcode_end' => 4999],
            ['name' => 'Hautes-Alpes', 'region_id' => 13, 'zipcode_start' => 5000, 'zipcode_end' => 5999],
            ['name' => 'Alpes-Maritimes', 'region_id' => 13, 'zipcode_start' => 6000, 'zipcode_end' => 6999],
            ['name' => 'Bouches-du-Rhône', 'region_id' => 13, 'zipcode_start' => 13000, 'zipcode_end' => 13999],
            ['name' => 'Var', 'region_id' => 13, 'zipcode_start' => 83000, 'zipcode_end' => 83999],
            ['name' => 'Vaucluse', 'region_id' => 13, 'zipcode_start' => 84000, 'zipcode_end' => 84999],

            // Régions d'Outre-Mer
            ['name' => 'Guadeloupe', 'region_id' => 14, 'zipcode_start' => 97100, 'zipcode_end' => 97190],
            ['name' => 'Martinique', 'region_id' => 15, 'zipcode_start' => 97200, 'zipcode_end' => 97290],
            ['name' => 'Guyane', 'region_id' => 16, 'zipcode_start' => 97300, 'zipcode_end' => 97390],
            ['name' => 'La Réunion', 'region_id' => 17, 'zipcode_start' => 97400, 'zipcode_end' => 97490],
            ['name' => 'Mayotte', 'region_id' => 18, 'zipcode_start' => 97600, 'zipcode_end' => 97690],
        ];

        DB::table('departements')->insert($departements);
    }
}
