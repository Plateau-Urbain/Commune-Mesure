<script>
  const finances = {
      "fonctionnement":[{"name":"Aides publiques","size":{{ $place->get('blocs->moyens->donnees->fonctionnement->Aides publiques')}}},
          {"name":"Aides priv\u00e9es","size":{{ $place->get('blocs->moyens->donnees->fonctionnement->Aides privées')}}},
          {"name":"Recettes","size":{{ $place->get('blocs->moyens->donnees->fonctionnement->Recettes')}}},
          {"name":"Autres subventions","size":{{ $place->get('blocs->moyens->donnees->fonctionnement->Autres Subventions')}}}
        ]
    };

  const canvasFinancesId = 'financement-budget-doughnut'
  const optionsChart = {legend: {display: true}}
  let typeChart = 'fonctionnement'
  let colorsChart = ['#ffc400', '#ff5728', '#c90035', '#96043e']
  let fontWeight = 'normal'

  function getLabels(id){
      const labels = [];
      finances[id].forEach(node => {
          labels.push(node.name);
        })
      return labels;
    }

  function getDataChart(id){
      const datasetsStruct = [{
        data: [],
        borderColor : "#fff",
        hoverBorderColor : "#e85048"
      }];

      const dataset = [];
      finances[id].forEach(node => {
          dataset.push(node.size);
        })

      datasetsStruct[0].data = dataset;

      return datasetsStruct;
    }

  @if (! $place->isEmptyFonctionnement())
    const financeChart = charts.create(
        canvasFinancesId,
        "doughnut",
        getLabels("fonctionnement"),
        getDataChart("fonctionnement"),
        ['#ffc400', '#ff5728', '#c90035', '#96043e'],
        optionsChart
    );
  @endif

</script>
