#!/bin/bash

CHEMIN='storage/import'

if [ -z "$1" ]
then
    echo "Need json file as parameter"
    exit 1
fi

NOMBREDELIEU=$(jq length "$1")
TAILLEJSON=$((NOMBREDELIEU-1))

if [ ! -d "$CHEMIN" ]
then
    mkdir -p "$CHEMIN"
fi

for i in $(seq 0 $TAILLEJSON);
do
    FICHIER=$(jq .["$i"] "$1" | jq .answers[1].group.answers[0].short_text.value | sed "s/\"//g" |sed "s/ /_/g"| sed "s#/#_#g" | sed "s#'#_#g")
    jq .["$i"] "$1" > "$CHEMIN"/"$FICHIER".json
done
