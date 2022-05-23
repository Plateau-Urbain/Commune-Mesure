<section class="section">
  <div class="columns">
    <div class="column is-2">
      <div class="burger">
        <div class="burger-pain"></div>
        @foreach ($data as $tranche)
        <div title="{{ $tranche['name'] }}" class="burger-tranche burger-{{ array_pop($couleurs) }}" data-value="{{ $tranche['value'] }}">
          {{ $tranche['name'] }}
        </div>
        @endforeach
        <div class="burger-pain"></div>
      </div>
    </div>
  </div>
</section>

@section('script_js')
  @parent

  <script>
    (document.querySelectorAll('.burger-tranche') || []).forEach(($tranche) => {
      $tranche.style.height = ($tranche.dataset.value * 100 / {{ $total }}) + "px"
    });
  </script>
@endsection
