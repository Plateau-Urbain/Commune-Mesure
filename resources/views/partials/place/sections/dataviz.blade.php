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
        <div class="column is-flex is-flex-direction-column is-justify-content-center">
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
        <div class="column" id="head">
          <figure class="m-auto has-background-primary image is-48x48">
            1
          </figure>
          <figure class="m-auto has-background-warning image is-48x48">
            2
          </figure>
          <figure class="m-auto has-background-success image is-48x48">
            3
          </figure>
        </div>
      </div>

      <div class="columns has-text-centered box">
        <div class="column is-flex is-flex-direction-column is-justify-content-center">
          <div class="columns">
            <div class="column is-2 switch switch-prev" data-part="body">
              ←
            </div>
            <div class="column switch switch-value" data-part="body">
              chargement...
            </div>
            <div class="column is-2 switch switch-next" data-part="body">
              →
            </div>
          </div>
        </div>
        <div class="column" id="body">
          <figure class="m-auto has-background-primary image is-48x48">
            1
          </figure>
          <figure class="m-auto has-background-warning image is-48x48">
            2
          </figure>
          <figure class="m-auto has-background-success image is-48x48">
            3
          </figure>
        </div>
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
      head: ['coiffeur', 'cuisinier', 'jardinier'],
      body: ['plombier', 'peintre', 'pizzaiolo']
    };

    // init
    (document.querySelectorAll('.switch.switch-value') || []).forEach((el) => {
      const part = el.dataset.part
      el.innerHTML = parts[part][0]
      el.dataset.current = parts[part][0]
    });

    (document.querySelectorAll('.switch.switch-prev, .switch.switch-next') || []).forEach((arrow) => {
        arrow.addEventListener('click', (e) => {
          const el = e.target;
          const sens = (e.target.classList.contains('switch-next')) ? 'next' : 'prev';

          switchName(el, sens)
          switchPicture(el, sens)
        });
    });

    function switchName(el, sens) {
      let current = undefined
      if (sens === 'prev') {
        current = el.nextElementSibling.dataset.current
      } else {
        current = el.previousElementSibling.dataset.current
      }

      const roles = parts[el.dataset.part]
      const index = roles.indexOf(current)

      if (sens === 'prev') {
        if (index === 0) {
          el.nextElementSibling.innerHTML = roles[roles.length - 1]
          el.nextElementSibling.dataset.current = roles[roles.length - 1]
        } else {
          el.nextElementSibling.innerHTML = roles[index - 1]
          el.nextElementSibling.dataset.current = roles[index - 1]
        }
      } else {
        if (index === roles.length - 1) {
          el.previousElementSibling.innerHTML = roles[0]
          el.previousElementSibling.dataset.current = roles[0]
        } else {
          el.previousElementSibling.innerHTML = roles[index + 1]
          el.previousElementSibling.dataset.current = roles[index + 1]
        }
      }
    };

    function switchPicture(el, sens) {
      let current = undefined
      if (sens === 'prev') {
        current = el.nextElementSibling.dataset.current
      } else {
        current = el.previousElementSibling.dataset.current
      }
      const part = el.dataset.part
      const index = parts[part].indexOf(current)

      (document.querySelectorAll("#"+part+">figure") || []).forEach((child) => child.style.display = "none")
      document.querySelector("#"+part+">figure:nth-child("+(index+1)+")").style.display = 'block'
    }
  </script>
@endsection
