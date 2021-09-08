Bonjour {{ $place->get('creator->name') }},

Vous venez de répondre au questionnaire de {{ getenv('APP_NAME') }}.

Merci de votre participation!

Vous pouvez dès maintenant éditer votre data panorama qui vous propose la visualisation
de certains impacts de votre lieu hybride. Vous pouvez activer et désactiver
certaines sections en cliquant sur le petit oeil.

Afin de vous permettre de vérifier et de modifier vos données, vous avez accès
à l'interface d'administration de votre lieu à l'adresse suivante :
<{{ route('place.edit', ['slug' => $place->getSlug(), 'auth' => $place->getAuth($place)->first()]) }}>

Attention ! Ne partagez cette adresse qu'avec des personnes de confiance. Toute
personne ayant accès à cette page pourra modifier votre lieu.

Une fois édité et validé, vous pouvez cliquer sur le petit globe pour rendre
votre datapanorama public.
Vous pouvez nous écrire pour nous faire part de vos retours et remarques à contact@communemesure.fr.

A bientôt !

L'équipe Commune Mesure
