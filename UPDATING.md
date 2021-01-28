# Mettre à jour le projet

## Passer de la version json à la version sqlite

Après avoir pullé, un petit `composer install` pour installer les nouvelles déps
puis un `npm run build` pour reconstruire les assets graphiques.

Si `npm run build` sort un message tout rouge, **pas de panique !** Il suffit
de lancer une commande sass. Elle est décrite dans le message d'erreur npm.

Avant de lancer la commande qui peuple la base de données, il faut configurer
l'application :
`DB_CONNECTION` doit être renseigner avec `sqlite` et `DB_DATABASE` avec le
**chemin absolu** du fichier : `/home/user/commune/database/database.sqlite`

Dans les paramètres `.env`, il faut aussi s'assurer que l'entrée APP_KEY est
remplie (32 charactères a-zA-Z0-9). La commande `php artisan key:generate`
permet d'en créer une.

Il faut enfin lancer la migration de la base de données :
`php artisan migrate:fresh --seed` permet de créer la table et de la populer
avec les fichiers json présents dans le dossier d'origine.

Et enfin, on peut générer les hashs des espaces d'administration de chaque lieux
importés en lançant la commande : `php artisan admin:generate-hash`
