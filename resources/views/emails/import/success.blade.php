Bonjour {{ $place->get('creator->name') }},

Vous venez de répondre au questionnaire de {{ getenv('APP_NAME') }}.

Merci de votre participation!

Vous pouvez dès maintenant éditer votre data panorama qui vous propose la
visualisation de certains impacts de votre lieu hybride.
Vous pouvez activer et désactiver certaines sections en cliquant sur le petit oeil.

Attention ! Votre lieu n'est pas encore public et en ligne sur communemesure.fr.
Pour le publier, vous devez cliquer sur le petit globe en haut a droite !

Afin de vous permettre de vérifier et de modifier vos données, vous avez accès
à l'interface d'administration de votre lieu à l'adresse suivante :
<{{ route('place.edit', ['slug' => $place->getSlug(), 'auth' => $place->getAuth($place)->first()]) }}>

Si vous n'êtes pas satisfait.e.s des visualisations de vos données proposées,
n'hésitez pas à les modifier grâce au petit crayon présent sur chaque section
du datapanorama.

Attention ! Ne partagez cette adresse qu'avec des personnes de confiance. Toute
personne ayant accès à cette page pourra modifier votre lieu.

Une fois édité et validé, vous pouvez cliquer sur le petit globe pour rendre
votre datapanorama public.
Vous pouvez nous écrire pour nous faire part de vos retours et remarques à {{ getenv('MAIL_FROM_ADDRESS') }}.

À bientôt !

L'équipe {{ getenv('APP_NAME') }}
