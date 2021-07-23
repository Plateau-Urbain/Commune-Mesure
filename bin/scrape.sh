#!/bin/bash

_HOST="https://communemesure.fr"
_WORKINGDIR="$(dirname "$0")"
_SECTIONS=("header" "footer")

for section in "${_SECTIONS[@]}"; do
    tempfile=`mktemp`

    curl "${_HOST}/blog/export/" | tr -d '\n' | tr -d '\t' | sed "s#</${section}>.*#</${section}>#" | sed "s#.*<${section}#<${section}#" > "$tempfile"

    mv "$tempfile" "$_WORKINGDIR/../resources/views/generate/"${section}".blade.php"
done
