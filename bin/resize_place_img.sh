#!/bin/bash

cd public/images/lieux/originals
for img in *
do
    echo $img
    convert "$img" -resize 345x230 -background '#f9f7f4' -gravity Center -extent 345x230 "../$img"
done
