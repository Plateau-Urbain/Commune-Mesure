@include('generate.footer')

@if (request()->is('place/*'))
<footer class="footer is-visible-print">
  <div class="columns is-vcentered">
    <div class="column is-one-third">
      <div class="qrcode mx-auto" style="background-color: white; width: 150px; height: 150px">

      </div>
      <div class="has-text-white px-6 mt-3 has-text-centered">
        <p>{{ route('place.show', ['slug' => $place->getSlug()]) }}</p>
      </div>
    </div>
    <div class="column has-text-white">
      <p>
      </p>
    </div>
  </div>
</footer>
@endif
