<div id="mapid"></div>

<script>
let popupviews = [];
let point = [];

@foreach($coordinates as $name => $points)
  point.push([{{ $points['geo']['lat'] }}, {{ $points['geo']['lon'] }}]);
  @php
  $popupview = str_replace(["\r\n", "\n", '  '], '',
      view('components/popup',
          ['name' => $popup[$name]['name'],
              'title'=>$popup[$name]['title'],
              'description'=>$popup[$name]['description'],
              'departement' => $popup[$name]['departement'],
              'city' => $popup[$name]['city'],
              'images' => $popup[$name]['images']
          ])->render());
  @endphp
  popupviews.push("{!! $popupview !!}")
@endforeach
</script>
