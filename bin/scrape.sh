#!/bin/bash

_HOST="https://communemesure.fr"
_WORKINGDIR="$(dirname "$0")"
_SECTIONS=("header" "footer")

# Sections

for section in "${_SECTIONS[@]}"; do
    tempfile=`mktemp`

    curl --fail --silent --show-error "${_HOST}/contact/" | tr -d '\n' | tr -d '\t' | sed "s#</${section}>.*#</${section}>#" | sed "s#.*<${section}#<${section}#" > "$tempfile"

    sed -i 's/<header id="main-header"/<header id="main-header" class="navbar is-fixed-top is-hidden-touch is-hidden-print"/' "$tempfile"
    sed -i 's/et-waypoint //' "$tempfile"
    sed -i 's/et-l et-l--footer/footer/' "$tempfile"
    sed -i 's/ class="footer"/ class="footer is-hidden-print"/' "$tempfile"

    mv "$tempfile" "${_WORKINGDIR}/../resources/views/generate/"${section}".blade.php"
    chmod g+rw "${_WORKINGDIR}/../resources/views/generate/"${section}".blade.php"
    chmod o+r "${_WORKINGDIR}/../resources/views/generate/"${section}".blade.php"
done

# Fonts

curl --fail --silent --show-error "${_HOST}/wp-content/themes/Divi/core/admin/fonts/modules.ttf" -o "${_WORKINGDIR}/../public/fonts/modules.ttf"
curl --fail --silent --show-error "${_HOST}/wp-content/themes/Divi/core/admin/fonts/modules.woff" -o "${_WORKINGDIR}/../public/fonts/modules.woff"
