#!/bin/bash

_HOST="https://communemesure.fr"
_WORKINGDIR="$(dirname "$0")"
_SECTIONS=("header" "footer")

# Sections

for section in "${_SECTIONS[@]}"; do
    tempfile=`mktemp`

    curl "${_HOST}/blog/export/" | tr -d '\n' | tr -d '\t' | sed "s#</${section}>.*#</${section}>#" | sed "s#.*<${section}#<${section}#" > "$tempfile"

    mv "$tempfile" "$_WORKINGDIR/../resources/views/generate/"${section}".blade.php"
done

# CSS

tempfile=`mktemp`
wget 'https://communemesure.fr/wp-content/themes/Divi/core/admin/fonts/modules.ttf' -O "$_WORKINGDIR/../public/fonts/modules.ttf"
wget 'https://communemesure.fr/wp-content/themes/Divi/core/admin/fonts/modules.woff' -O "$_WORKINGDIR/../public/fonts/modules.woff"
wget 'https://communemesure.fr/wp-content/themes/Divi/style.css?ver=5.5.1' -O "$tempfile"

sed 's/font-family//' "$tempfile" | sed 's#core/admin/#../#g' > "$_WORKINGDIR/../public/css/divi-style.css"
