<meta property="twitter:card" content="summary_large_card">
<meta property="twitter:title" content="Le datapanorama de {{ $place->get('name') }}">
<meta property="twitter:site" content="{{ route('place.show', ['slug' => $place->getSlug()]) }}">
<meta property="twitter:description" content="@if ($place->get('blocs->presentation->donnees->idee_fondatrice'))
  {{ $place->get('blocs->presentation->donnees->idee_fondatrice') }}
@else
  Indicateurs sur le lieux {{ $place->get('name') }} situé à {{ $place->get('address->city') }}
@endif
">
@if (count($place->getPhotos()) > 0)
  <meta property="twitter:image" content="{{ url('images/lieux') . '/'. current($place->getPhotos()) }}">
@else
  <meta property="twitter:image" content="{{ url('images') . '/Commune-Mesure-1.png' }}">
@endif
