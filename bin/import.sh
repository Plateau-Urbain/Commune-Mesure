#!/bin/bash

#appel script puppeteer
DOSSIER_PUPPETEER="../puppeteer_scripts/"
node "$DOSSIER_PUPPETEER"typerform.js

#appel script split
unset -v FICHIER_TYPE_FORM
for file in "$DOSSIER_PUPPETEER"out/*.json; do   [[ $file -nt $FICHIER_TYPE_FORM ]] && FICHIER_TYPE_FORM=$file; done
echo $FICHIER_TYPE_FORM
bash bin/split_type_form_by_place.sh "$FICHIER_TYPE_FORM"

#task import
#verifier si le fichier .csv pour le geojson existe sinon telecharger le zip pui dezipper puis for i in /sto/.../*.json
