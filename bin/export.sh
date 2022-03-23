#!/bin/bash

# Config
PUPPETEER_DIR="../puppeteer_scripts"
SCREENSHOT_DIR="$PUPPETEER_DIR/out/screenshot"

if [ $# -eq 0 ]
    then echo "Missing place name" && exit 255
fi

PLACE=$1
TOP=$2

cd "$PUPPETEER_DIR" || exit
node screenshot.js "$PLACE" "$TOP"
_NODE_SUCCESS=$?
# cd -

if [ $_NODE_SUCCESS -eq 1 ] # Si 404 / 500
    then echo "Place $PLACE not found" && exit 1
fi

echo "$SCREENSHOT_DIR/$PLACE.jpg"
exit 0
