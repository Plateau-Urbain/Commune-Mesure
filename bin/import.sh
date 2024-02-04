#!/bin/bash

# Config
PUPPETEER_DIR="/home/olicatssh/puppeteer_scripts"
IRIS_CSV_DIR="storage/framework/cache/data"
OUTPUT_DIR='storage/import'
OUTPUT_DIR_GENERAL_INFO="general_information"
OUTPUT_DIR_SOCIAL_IMPACT="social_impact"
OUTPUT_DIR_ENVIRONMENTAL="environmental"
CRON_DIR='bin'

FORCE=
[ $# -eq 1 ] && FORCE="--force"

cd "$PUPPETEER_DIR" || exit
node "$PUPPETEER_DIR/typeform.js"
node "$PUPPETEER_DIR/typeform.js" general_information
node "$PUPPETEER_DIR/typeform.js" social_impact
node "$PUPPETEER_DIR/typeform.js" environmental
cd - || exit

#appel script split
unset -v FICHIER_TYPE_FORM
for file in "$PUPPETEER_DIR"/out/*.json; do [[ $file -nt $FICHIER_TYPE_FORM ]] && FICHIER_TYPE_FORM=$file; done
bash bin/split_type_form_by_place.sh "$FICHIER_TYPE_FORM"

#appel script split general_information
unset -v FICHIER_TYPE_FORM
for file in "$PUPPETEER_DIR"/out/"$OUTPUT_DIR_GENERAL_INFO"/*.json; do [[ $file -nt $FICHIER_TYPE_FORM ]] && FICHIER_TYPE_FORM=$file; done
bash bin/split_type_form_by_place.sh "$FICHIER_TYPE_FORM" "$OUTPUT_DIR_GENERAL_INFO"

#appel script split social_impact
unset -v FICHIER_TYPE_FORM
for file in "$PUPPETEER_DIR"/out/"$OUTPUT_DIR_SOCIAL_IMPACT"/*.json; do [[ $file -nt $FICHIER_TYPE_FORM ]] && FICHIER_TYPE_FORM=$file; done
bash bin/split_type_form_by_place.sh "$FICHIER_TYPE_FORM" "$OUTPUT_DIR_SOCIAL_IMPACT"

#appel script split environmental
unset -v FICHIER_TYPE_FORM
for file in "$PUPPETEER_DIR"/out/"$OUTPUT_DIR_ENVIRONMENTAL"/*.json; do [[ $file -nt $FICHIER_TYPE_FORM ]] && FICHIER_TYPE_FORM=$file; done
bash bin/split_type_form_by_place.sh "$FICHIER_TYPE_FORM" "$OUTPUT_DIR_ENVIRONMENTAL"

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

# tache d'import general_information
for i in "$OUTPUT_DIR"/"$OUTPUT_DIR_GENERAL_INFO"/*.json
do
    echo "$i"
    yes | php artisan import:typeform_generalinformation "$i" $FORCE
done

# tache d'import social_impact
for i in "$OUTPUT_DIR"/"$OUTPUT_DIR_SOCIAL_IMPACT"/*.json
do
    echo "$i"
    yes | php artisan import:typeform_socialimpact "$i" $FORCE
done

# tache d'import environmental
for i in "$OUTPUT_DIR"/"$OUTPUT_DIR_ENVIRONMENTAL"/*.json
do
    echo "$i"
    yes | php artisan import:typeform_environmental "$i" $FORCE
done

# On exécute l'export des fichiers
bash ./bin/concat_files.sh

# On exécute la fusion des fichiers typeform et base
bash ./bin/fusion_files.sh

# On met à jour la page d'accueil
bash "$CRON_DIR"/cron.sh
