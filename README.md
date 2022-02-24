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
* Lancer les migrations : `php artisan migrate`


Pour lancer le projet: 

    php -S localhost:8000 -t public/ 

## Mise à jour

Voir le fichier [UPDATING.md](UPDATING.md)
