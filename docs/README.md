# Workflow

## Réponse au questionnaire

Le porteur de projet réponds au questionnaire créé par l'équipe de Plateau Urbain

## Tâche récurrente

Toutes les heures, une [tâche](../bin/import.sh) va scraper la page de réponse du formulaire et en extraire un json.

Ça va séparer le fichier en X fichiers json contenant les réponses d'un lieu.

Chaque json est ensuite passé à la tâche d'import.

## Tâche d'import

La tâche d'import regarde si le lieu à déjà été importé, puis, grâce a un [schema](../storage/places/schema.json), convertit les réponses du json dans le [format](./exemple_lieu.json) stocké en base.

Elle va également rechercher les données geojson et insee de l'iris, la commune, le département et la région du lieu.

Elle envoi un mail au porteur de projet une fois l'import terminé.

