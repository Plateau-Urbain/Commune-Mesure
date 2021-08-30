#!/bin/bash

CHEMIN='storage/app'

NOMBREDELIEU=$(jq length "$1")
TAILLEJSON=$(($NOMBREDELIEU-1))

mkdir -p "$CHEMIN"/jsonFromTypeForm

if [ -e $1 ]
then
  for i in `seq 0  $TAILLEJSON`;
  do
    FICHIER=$(jq .[$i] "$1" |jq  .answers[1].group.answers[0].short_text.value | sed "s/\"//g" |sed "s/ /_/g"| sed "s#/#_#g")
    jq .[$i] "$1"  > "$CHEMIN"/jsonFromTypeForm/$FICHIER.json
  done
else
  echo "Le fichier json n'existe pas"
fi
