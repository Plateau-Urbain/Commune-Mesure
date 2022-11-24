#!/bin/bash

ls public/images/lieux/ | grep -E "\..+" |  while read file; do convert "public/images/lieux/$file" -resize 400x "public/images/lieux/thumbnail/$file"; done
