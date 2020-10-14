#!/bin/bash

cd public/images/lieux
ls originals/ | while read img ; do convert -resize 345x230 -background '#f9f7f4' -gravity Center -extent 345x230 "originals/"$img $img ; done
