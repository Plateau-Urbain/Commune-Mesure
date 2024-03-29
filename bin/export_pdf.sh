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

bash bin/export.sh $PLACE

rm -f "$SCREENSHOT_DIR/$PLACE.pdf"

find "$SCREENSHOT_DIR" -name "$PLACE*" | while read FILE;
do
    PDF_FILE="$(dirname "${FILE}")/$(basename "${FILE}" .jpg).pdf"
    if ! convert "$FILE" -quality 95 "$PDF_FILE"
        then echo "Conversion to pdf failed" && exit 32
    fi
done

rm "$SCREENSHOT_DIR/$PLACE.pdf"

pdftk $(find "$SCREENSHOT_DIR" -name "$PLACE*.pdf" | sort) output "$SCREENSHOT_DIR/$PLACE.pdf"

find "$SCREENSHOT_DIR" ! -name "$PLACE.pdf" -type f -iname "*.pdf" -exec rm -f {} +
find "$SCREENSHOT_DIR" ! -name "$PLACE.jpg" -type f -iname "*.jpg*" -exec rm -f {} +

realpath "$SCREENSHOT_DIR/$PLACE.pdf"

exit 0
