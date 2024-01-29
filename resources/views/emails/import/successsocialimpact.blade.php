Bonjour {{ $place->get('creator->name') }},

Vous venez de répondre au questionnaire de {{ getenv('APP_NAME') }}.

Merci de votre participation!

Vous pouvez dès maintenant éditer la section impact social.
Vous pouvez activer et désactiver certaines sections en cliquant sur le petit oeil.

Afin de vous permettre de vérifier et de modifier vos données, vous avez accès
à l'interface d'administration de votre lieu à l'adresse suivante :
<{{ route('place.edit', ['slug' => $place->getSlug(), 'auth' => $place->getAuth($place)->first()]) }}>

Si vous n'êtes pas satisfait.e.s des visualisations de vos données proposées,
n'hésitez pas à les modifier grâce au petit crayon présent sur chaque section
de la section impact social.

Attention ! Ne partagez cette adresse qu'avec des personnes de confiance. Toute
personne ayant accès à cette page pourra modifier votre lieu.

Vous pouvez nous écrire pour nous faire part de vos retours et remarques à {{ getenv('MAIL_FROM_ADDRESS') }}.

À bientôt !

L'équipe {{ getenv('APP_NAME') }}
