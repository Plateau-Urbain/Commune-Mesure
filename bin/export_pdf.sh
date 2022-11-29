#!/bin/bash
PUPPETEER_DIR="../puppeteer_scripts"
SCREENSHOT_DIR="$PUPPETEER_DIR/out/screenshot"

if [ $# -eq 0 ]
    then echo "Missing place name" && exit 255
fi

if ! command -v convert &> /dev/null
    then echo "Missing convert utils" && exit 64
fi

PLACE=$1

find "$SCREENSHOT_DIR/" -type f -iname "$PLACE*.pdf" -delete #supprime tous les pdfs du dossier

find "$SCREENSHOT_DIR" -name "$PLACE*" | while read FILE;
do
    PDF_FILE="$(dirname "${FILE}")/$(basename "${FILE}" .jpg).pdf"
    if ! convert "$FILE" -quality 95 "$PDF_FILE"
        then echo "Conversion to pdf failed" && exit 32
    fi
done

rm "$SCREENSHOT_DIR/$PLACE.pdf"

pdftk $(find "$SCREENSHOT_DIR" -name "$PLACE*.pdf" | sort) output "$SCREENSHOT_DIR/$PLACE.pdf"


echo "$SCREENSHOT_DIR/$PLACE.pdf"

exit 0
