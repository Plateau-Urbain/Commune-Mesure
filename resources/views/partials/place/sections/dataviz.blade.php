<section class="section">
  <div class="columns">

    {{-- Burger --}}
    <div class="column is-4">
      <canvas id="surfaces-graph"></canvas>
    </div>

    {{-- Livre --}}
    <div class="column is-6">
      <div class="columns has-text-centered box">
        <div class="column is-flex is-flex-direction-column is-justify-content-center">
          <div class="columns">
            <div class="column is-2 switch switch-prev">
              ←
            </div>
            <div class="column switch switch-value" data-part="head">
              chargement...
            </div>
            <div class="column is-2 switch switch-next">
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
            <div class="column is-2 switch switch-prev">
              ←
            </div>
            <div class="column switch switch-value" data-part="body">
              chargement...
            </div>
            <div class="column is-2 switch switch-next">
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

      setPartName(el, 0)
      setPicture(el, 0)
    });

    (document.querySelectorAll('.switch.switch-prev, .switch.switch-next') || []).forEach((arrow) => {
        arrow.addEventListener('click', (e) => {
          const fleche = e.target;
          const sens = (fleche.classList.contains('switch-next')) ? 'next' : 'prev';
          const el = (sens === 'prev') ? fleche.nextElementSibling : fleche.previousElementSibling;

          const roles = parts[el.dataset.part]
          const currentindex = roles.indexOf(el.dataset.current)
          let newindex = undefined

          if (sens === 'prev') {
            newindex = (currentindex === 0) ? roles.length - 1 : currentindex - 1;
          } else {
            newindex = (currentindex === roles.length - 1) ? 0 : currentindex + 1;
          }

          setPartName(el, newindex)
          setPicture(el, newindex)
        });
    });

    function setPartName(el, newindex) {
      const roles = parts[el.dataset.part]
      el.innerHTML = roles[newindex]
      el.dataset.current = roles[newindex]
    };

    function setPicture(el, newindex) {
      const part = el.dataset.part;

      (document.querySelectorAll("#"+part+">figure") || []).forEach((child) => child.style.display = "none")
      document.querySelector("#"+part+">figure:nth-child("+(newindex+1)+")").style.display = 'block'
    }
  </script>

  <script>
    const config = {
      type: 'treemap',
      data: {
        datasets: [
          {
            tree: [
              {type: "Charges remboursement propriétaire", value: 15},
              {type: "Salaire", value: 8},
              {type: "Remboursement prêt", value: 6}
            ],
            key: "value",
            groups: ['type'],
            labels: {
              display: true,
              formatter: (ctx) => ctx.raw.g + ' : ' + ctx.raw.v + ' €'
            },
            borderColor: 'green',
            borderWidth: 1,
            spacing: 1,
            fontColor: "#000000",
            backgroundColor: "#EEE"
          }
        ],
      },
      options: {
        plugins: {
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Répartition des charges'
          },
          legend: { display: false },
          tooltip: { enabled: false }
        }
      }
    };
    const surfaceGraph = new Chart("surfaces-graph", config)
  </script>
@endsection
