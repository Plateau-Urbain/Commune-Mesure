#!/bin/bash

_HOST="https://communemesure.fr"
_WORKINGDIR="$(dirname "$0")"

tempfile=`mktemp`

curl "${_HOST}/blog/export/" | tr -d '\n' | tr -d '\t' | sed 's#</footer>.*#</footer>#' | sed 's#.*<footer#<footer#' > "$tempfile"

mv "$tempfile" "$_WORKINGDIR/../resources/views/generate/footer.blade.php"
