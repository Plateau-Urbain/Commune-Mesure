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

ANSWER='.answers[1].group.answers[0].short_text.value'

if [ ! -z "$2" ]
then
    if [ "$2" = "social_impact" ]
    then
        ANSWER='.answers[1].short_text.value'
    else
        ANSWER='.answers[2].group.answers[0].short_text.value'
    fi

    CHEMIN="$CHEMIN/$2"
    if [ ! -d "$CHEMIN" ]
    then
        mkdir -p "$CHEMIN"
    fi
fi

for i in $(seq 0 $TAILLEJSON);
do
    FICHIER=$(jq .["$i"] "$1" | jq "$ANSWER" | sed "s/\"//g" |sed "s/ /_/g"| sed "s#/#_#g" | sed "s#'#_#g")
    jq .["$i"] "$1" > "$CHEMIN"/"$FICHIER".json
done
