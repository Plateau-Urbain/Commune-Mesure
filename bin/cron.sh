#!/bin/sh

# Scrape les pages « external » avec wget

_HOST="communemesure.exemple.com"
_URLS=("chiffres" "map")
_TMP="/tmp/"
_DEST=""

mkdir -p "$_TMP"
mkdir -p "$_DEST"

cd "$_TMP"

for url in "${_URLS[@]}"; do
    wget --page-requisites \
         --convert-links \
         "https://${_HOST}/external/${url}"

    rsync -r "${_TMP}${_HOST}/" "${_DEST}"
    rm -r "${_TMP}${_HOST}"
done
