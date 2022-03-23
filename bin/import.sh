#!/bin/bash

# Config
PUPPETEER_DIR="../puppeteer_scripts"
IRIS_CSV_DIR="storage/framework/cache/data"
OUTPUT_DIR='storage/import'
CRON_DIR='bin'

FORCE=
[ $# -eq 1 ] && FORCE="--force"

cd "$PUPPETEER_DIR" || exit
node "$PUPPETEER_DIR/typeform.js"
cd - || exit

#appel script split
unset -v FICHIER_TYPE_FORM
for file in "$PUPPETEER_DIR"/out/*.json; do [[ $file -nt $FICHIER_TYPE_FORM ]] && FICHIER_TYPE_FORM=$file; done
bash bin/split_type_form_by_place.sh "$FICHIER_TYPE_FORM"

#fichier pour iris ...
if [ ! -f "$IRIS_CSV_DIR"/base-ic-evol-struct-pop-2016.csv ];
then
    echo "WARNING: $IRIS_CSV_DIR/base-ic-evol-struct-pop-2016.csv missing"
    echo -e "\tcsv converted from the official xls downloaded from https://www.insee.fr/fr/statistiques/fichier/4228434/base-ic-evol-struct-pop-2016.zip"
    echo -e "\tlibreoffice --headless --convert-to csv:\"Text - txt - csv (StarCalc)\":59,34,0,1,1 /tmp/base-ic-evol-struct-pop-2016.xls --outdir storage/framework/cache/data/"
    echo -e "\tle code iris complet DDCCCIIIII (D = département, C = commune insee, I = Iris) attendu en première colonne"
    echo -e "\tseparateur ;"
    exit 1;
fi

# tache d'import
for i in "$OUTPUT_DIR"/*.json
do
    echo "$i"
    yes | php artisan import:typeform "$i" $FORCE
done

# On met à jour la page d'accueil
bash "$CRON_DIR"/cron.sh
