#!/bin/bash

TYPEFORM_SUFFIX="typeform"
BASE_SUFFIX="genere"
EXPORT_DIR="storage/exports"

php artisan places:list | while read -r place; do
    _name=$(echo "$place" | cut -d';' -f1)
    _typeformfile="$EXPORT_DIR"/"$_name"."$TYPEFORM_SUFFIX".csv
    _basefile="$EXPORT_DIR"/"$_name"."$BASE_SUFFIX".csv

    [ ! -f "$_typeformfile" ] && echo "WARN: Missing typeform file [$_name]" && continue
    [ ! -f "$_basefile" ] && echo "WARN: Missing base file [$_name]" && continue

    php artisan export:fusion "$_typeformfile" "$_basefile"
done;
