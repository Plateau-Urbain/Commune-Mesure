#!/bin/bash

# Config
PUPPETEER_DIR="../puppeteer_scripts"
SCREENSHOT_DIR="$PUPPETEER_DIR/out/screenshot"

if [ $# -eq 0 ]
    then echo "Missing place name" && exit 255
fi

TYPE=$1
PLACE=$2
TOP=$3

cd "$PUPPETEER_DIR" || exit

find "$SCREENSHOT_DIR" -type f -iname "*$PLACE*" -exec rm -f {} +

if [ "$TYPE" = "environmental" ]; then
    node screenshot_environmental.js "$PLACE"
else
    node screenshot.js "$PLACE" "$TOP"
fi

_NODE_SUCCESS=$?

if [ $_NODE_SUCCESS -eq 1 ] # Si 404 / 500
    then echo "Place $PLACE not found" && exit 1
fi

convert $(find "$SCREENSHOT_DIR" -name "$PLACE*.jpg" | sort) -append "$SCREENSHOT_DIR/$PLACE.jpg"


realpath "$SCREENSHOT_DIR/$PLACE.jpg"

exit 0
