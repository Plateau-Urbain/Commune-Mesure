# Commune Mesure - la plateforme

Projet de dataviz des impacts des lieux hybrides français.

## Installation

```
composer install
npm install
npm run build
cp .env.example .env
```

Adapter le STORAGE_PATH de .env à votre environnement

Remplir le fichier .env (au moins le STORAGE_PATH)

Pour lancer le projet: 

    php -S localhost:8000 -t public/ 

## Mise à jour

Voir le fichier [UPDATING.md](UPDATING.md)
