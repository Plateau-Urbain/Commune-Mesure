<section class="section">
  <div class="columns">
    {{-- Burger --}}
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

    {{-- Livre --}}
    <div class="column is-6">
      <div class="columns has-text-centered box">
        <div class="column">
          <div class="columns">
            <div class="column is-2 switch switch-prev" data-part="head">
              ←
            </div>
            <div class="column switch switch-value" data-part="head">
              chargement...
            </div>
            <div class="column is-2 switch switch-next" data-part="head">
              →
            </div>
          </div>
        </div>
        <div class="column">⋅</div>
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

  <script>
    const parts = {
      head: ['coiffeur', 'cuisinier', 'jardinier']
    };

    // init
    (document.querySelectorAll('.switch.switch-value') || []).forEach((el) => {
      const part = el.dataset.part
      el.innerHTML = parts[part][0]
      el.dataset.current = parts[part][0]
    });

    (document.querySelectorAll('.switch.switch-prev') || []).forEach(($switch) => {
      $switch.addEventListener('click', () => {
        const current = $switch.nextElementSibling.dataset.current
        const part = $switch.dataset.part
        const roles = parts[part]

        const index = roles.indexOf(current)
        if (index === 0) {
          $switch.nextElementSibling.innerHTML = roles[roles.length - 1]
          $switch.nextElementSibling.dataset.current = roles[roles.length - 1]
        } else {
          $switch.nextElementSibling.innerHTML = roles[index - 1]
          $switch.nextElementSibling.dataset.current = roles[index - 1]
        }

      });
    });

    (document.querySelectorAll('.switch.switch-next') || []).forEach(($switch) => {
      $switch.addEventListener('click', () => {
        const current = $switch.previousElementSibling.dataset.current
        const part = $switch.dataset.part
        const roles = parts[part]

        const index = roles.indexOf(current)
        if (index === roles.length - 1) {
          $switch.previousElementSibling.innerHTML = roles[0]
          $switch.previousElementSibling.dataset.current = roles[0]
        } else {
          $switch.previousElementSibling.innerHTML = roles[index + 1]
          $switch.previousElementSibling.dataset.current = roles[index + 1]
        }

      });
    });
  </script>
@endsection
