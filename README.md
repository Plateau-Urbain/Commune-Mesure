# Commune Mesure - la plateforme

Projet de dataviz des impacts des lieux hybrides français.

## Prérequis

```
php >= 7.3
```

convert (pour la conversion en pdf des pages de lieu)
[puppeteer_scripts](https://github.com/24eme/puppeteer_scripts) pour la récupération des infos des lieux

## Installation

```
composer install # avec `--no-dev` en production
npm install
bash bin/scrape.sh # Télécharge les polices / header / footer
npm run build
cp .env.example .env
```

Remplir le fichier .env :
* Adapter le STORAGE_PATH de .env à votre environnement
* Si le site est en production, alors APP_DEBUG et DEBUGBAR_ENABLED => false
* Pour générer une valeur pour APP_KEY, lancez la commande `php artisan key:generate`


Création de la base de données :
* Si sqlite est utilisé, alors il faut créer la base de données : `touch database/database.sqlite`
* Lancer les migrations : `php artisan migrate --seed`


Pour lancer le projet: 

    php -S localhost:8000 -t public/ 

## Mise à jour

Voir le fichier [UPDATING.md](UPDATING.md)

## Commandes

```
Commandes utiles :
 admin
  admin:generate-hash        Génère un nouveau secret pour éditer un espace de lieu
  admin:set-value            Met à jour une valeur dans les données (champs libre)
  admin:set-value-for-all    Édite un champs pour tous les lieux (champs libre)
 export
  export:fusion              Fusionne un CSV d'export du json original et un csv de la base
  export:original-to-csv     Exporte le fichier json original au format csv
  export:place-to-csv        Exporte les données d'un lieu au format csv
 import
  import:one-value-typeform  Importe une valeur du json type form dans un lieu existant
  import:typeform            Importer les données reponses du typeform
  import:value-for-all       Importe une valeur pour tous les lieux
 iris
  iris:load                  Récupère les données IRIS et INSEE d'un lieu
 mail
  mail:send-import-success   Envoi le mail d'import réussi au créateur du lieu
 places
  places:list                Liste les lieux en base
```
