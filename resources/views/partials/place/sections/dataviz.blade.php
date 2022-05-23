<section class="section">
  <div class="columns">
    <div class="column is-offset-5 is-3">
      <div class="burger">
        <div class="burger-pain"></div>
        @foreach ($data as $tranche)
        <div class="burger-tranche burger-{{ array_rand(array_flip(['salade', 'steak', 'tomate'])) }}" data-value="{{ $tranche['value'] }}">
          {{ $tranche['name'] }}
        </div>
        @endforeach
        <div class="burger-pain"></div>
      </div>
    </div>
  </div>
</section>
