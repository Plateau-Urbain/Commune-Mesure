#!/bin/bash

cd public/images/lieux/originals || exit

convert "$1" -resize 345x230 -background '#f9f7f4' -gravity Center -extent 345x230 "../$1"
