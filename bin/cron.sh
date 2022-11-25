#!/bin/bash

# Scrape les pages « external » avec wget

_HOST="communemesure.exemple.com"
_URLS=("chiffres" "map")
_TMP="/tmp/"
_DEST=""

mkdir -p "$_TMP"
mkdir -p "$_DEST"

cd "$_TMP" || exit

for url in "${_URLS[@]}"; do
    echo "wget: http://${_HOST}/external/${url}"
    wget --quiet --page-requisites "https://${_HOST}/external/${url}"

    echo "rsync: \"${_TMP}${_HOST}/\" \"${_DEST}\""
    rsync -r "${_TMP}${_HOST}/" "${_DEST}"

    echo "rm -r \"${_TMP}${_HOST}\""
    rm -r "${_TMP}${_HOST}"
done
