#!/bin/bash

#appel script puppeteer
DOSSIER_PUPPETEER="../puppeteer_scripts/"
CHEMIN_IRIS_CSV="storage/framework/cache/data/"
CHEMIN='storage/app/'

node "$DOSSIER_PUPPETEER"typeform.js

#appel script split
unset -v FICHIER_TYPE_FORM
for file in "$DOSSIER_PUPPETEER"out/*.json; do   [[ $file -nt $FICHIER_TYPE_FORM ]] && FICHIER_TYPE_FORM=$file; done
bash bin/split_type_form_by_place.sh "$FICHIER_TYPE_FORM"

#fichier pour iris ...
if [ -e "$CHEMIN_IRIS_CSV"base-ic-evol-struct-pop-2016.csv ];
then
  echo "Le fichier base-ic-evol-struct-pop-2016.csv existe"
else
  wget https://www.insee.fr/fr/statistiques/fichier/4228434/base-ic-evol-struct-pop-2016.zip -O "$CHEMIN_IRIS_CSV"base-ic-evol-struct-pop-2016.zip
  unzip "$CHEMIN_IRIS_CSV"base-ic-evol-struct-pop-2016.zip -d "$CHEMIN_IRIS_CSV"
  rm base-ic-evol-struct-pop-2016.zip
fi

# tache d'import
for i in "$CHEMIN"jsonFromTypeForm/*.json
  do
    php artisan import:typeform "$i"
  done
