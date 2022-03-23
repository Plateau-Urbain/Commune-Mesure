#!/bin/bash

if [ $# -eq 0 ]
    then echo "Missing file" && exit 255
fi

FILE=$1

if [ ! -f "$FILE" ]
    then echo "Screenshot file $FILE does not exists" && exit 128
fi

if ! command -v convert &> /dev/null
    then echo "Missing convert utils" && exit 64
fi

PDF_FILE="$(dirname "${FILE}")/$(basename "${FILE}" .jpg).pdf"

if ! convert "$FILE" -quality 95 "$PDF_FILE"
    then echo "Conversion to pdf failed" && exit 32
fi

echo "$PDF_FILE"
