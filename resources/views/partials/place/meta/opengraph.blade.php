<meta property="og:title" content="Le datapanorama de {{ $place->get('name') }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ route('place.show', ['slug' => $place->getSlug()]) }}">
@if (count($place->getPhotos()) > 0)
  @php $imagepath = base_path('public/images/lieux') . '/' . current($place->getPhotos()); @endphp
  @php $imageinfos = getimagesize($imagepath); @endphp
  <meta property="og:image" content="{{ url('images/lieux') . '/' . current($place->getPhotos()) }}">
  <meta property="og:image:width" content="{{ $imageinfos[0] }}">
  <meta property="og:image:height" content="{{ $imageinfos[1] }}">
  <meta property="og:image:type" content="{{ mime_content_type($imagepath) }}">
  <meta property="og:image:alt" content="Image du lieu">
@else
  @php $imagepath = base_path('public/images/Commune-Mesure-1.png') @endphp
  @php $imageinfos = getimagesize($imagepath) @endphp
  <meta property="og:image" content="{{ url('images/') . '/Commune-Mesure-1.png' }}">
  <meta property="og:image:width" content="{{ $imageinfos[0] }}">
  <meta property="og:image:height" content="{{ $imageinfos[1] }}">
  <meta property="og:image:type" content="{{ mime_content_type($imagepath) }}">
  <meta property="og:image:alt" content="Image du site">
@endif
<meta property="og:description" content="@if ($place->get('blocs->presentation->donnees->idee_fondatrice'))
  {{ $place->get('blocs->presentation->donnees->idee_fondatrice') }}
@else
  Indicateurs sur le lieux {{ $place->get('name') }} situé à {{ $place->get('address->city') }}
@endif
">
<meta property="og:locale" content="fr_FR">

