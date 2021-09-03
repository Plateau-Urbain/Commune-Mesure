Bonjour {{ $place->get('name') }},

Comme vous avez répondu au questionnaire Typeform mis en place par {{ getenv('APP_NAME') }},
votre lieu vient d'être importé automatiquement sur la plateforme :
<{{ getenv('APP_URL') }}>

Toutefois, il n'est pas encore accessible au public.

Afin de vous permettre de vérifier et de modifier vos données, vous avez accès
à l'interface d'administration de votre lieu à l'adresse suivante :
<{{ route('place.edit', ['slug' => $place->getSlug(), 'auth' => $place->getAuth($place)->first()]) }}>

Attention ! Ne partagez cette adresse qu'avec des personnes de confiance. Toute
personne ayant accès à cette page pourra modifier votre lieu.

Vous pouvez activer/désactiver certaines sections en cliquant sur le petit oeil.

Une fois vos données vérifiées, vous pourrez cliquer sur le petit globe pour
publier votre lieu.

L'équipe Commune Mesure !
