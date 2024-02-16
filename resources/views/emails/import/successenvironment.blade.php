Bonjour {{ $place->get('creator->name') }},

Vous venez de répondre au questionnaire de {{ getenv('APP_NAME') }}.

Merci de votre participation!

Vous pouvez dès maintenant éditer la section environnementale.

Afin de vous permettre de vérifier et de modifier vos données, vous avez accès
à l'interface d'administration de votre lieu à l'adresse suivante :
<{{ route('environment.edit', ['slug' => $place->getSlug(), 'auth' => $place->getAuth($place)->first()]) }}>

Attention ! Ne partagez cette adresse qu'avec des personnes de confiance. Toute
personne ayant accès à cette page pourra modifier votre lieu.

Vous pouvez nous écrire pour nous faire part de vos retours et remarques à {{ getenv('MAIL_FROM_ADDRESS') }}.

À bientôt !

L'équipe {{ getenv('APP_NAME') }}
