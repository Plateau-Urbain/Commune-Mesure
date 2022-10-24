#!/bin/bash

# Config
EXPORT_DIR='storage/exports'

# On concatene les exports des fichiers originaux (typeform)
echo "Lieu;CategorieId;Categorie;QuestionId;Question;Type;Reponse" > "$EXPORT_DIR"/export_global_typeform.csv.tmp

for file in "$EXPORT_DIR"/*.typeform.csv
do
    grep -v "^Lieu;" "$file" >> "$EXPORT_DIR"/export_global_typeform.csv.tmp
done

mv "$EXPORT_DIR"/export_global_typeform.csv.tmp "$EXPORT_DIR"/00_export_global_typeform.csv

# On concatene les exports des fichiers enregistrés en base
echo "Lieu;CategorieId;QuestionId;Type;Reponse" > "$EXPORT_DIR"/export_global_genere.csv.tmp

for file in "$EXPORT_DIR"/*.genere.csv
do
    grep -v "^Lieu;" "$file" >> "$EXPORT_DIR"/export_global_genere.csv.tmp
done

mv "$EXPORT_DIR"/export_global_genere.csv.tmp "$EXPORT_DIR"/00_export_global_genere.csv
