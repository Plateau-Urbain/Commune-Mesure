<script>
  const finances = {
      "investissement":[{"name":"Fonds publics","size":{{ $place->get('blocs->moyens->donnees->investissement->Fonds publics')}}},
          {"name":"Fonds priv\u00e9s","size":{{ $place->get('blocs->moyens->donnees->investissement->Fonds privés')}}},
          {"name":"Fonds apport\u00e9s","size":{{ $place->get('blocs->moyens->donnees->investissement->Fonds apportés')}}}
        ],
      "fonctionnement":[{"name":"Aides publiques","size":{{ $place->get('blocs->moyens->donnees->fonctionnement->Aides publiques')}}},
          {"name":"Aides priv\u00e9es","size":{{ $place->get('blocs->moyens->donnees->fonctionnement->Aides privées')}}},
          {"name":"Recettes","size":{{ $place->get('blocs->moyens->donnees->fonctionnement->Recettes')}}},
          {"name":"Autres subventions","size":{{ $place->get('blocs->moyens->donnees->fonctionnement->Autres Subventions')}}}
        ]
    };

  const inputChoice = document.querySelector("input#switchRoundedSuccess");
  const canvasFinancesId = 'financement-budget-doughnut'
  const optionsChart = {legend: {display: true}}
  const labelInvestissement = document.querySelector("label#label_investissement")
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

  function switchChart(){
      financeChart.destroy();

      if (inputChoice.checked) {
          //Fonctionnement
          typeChart = 'fonctionnement'
          colorsChart = ['#ffc400', '#ff5728', '#c90035', '#96043e']
          fontWeight = 'normal'
        } else {
          //Investissement
          typeChart = 'investissement'
          colorsChart = ['#8e44ad', '#3498db', '#1abc9c', '#96043e']
          fontWeight = 'bold'
        }

      financeChart = charts.create(canvasFinancesId, "doughnut",
          getLabels(typeChart), getDataChart(typeChart), colorsChart,
          {
              legend: {
                  display: true,
                },
            }

        );
      labelInvestissement.style.fontWeight = fontWeight;
    }

  let financeChart = charts.create(canvasFinancesId, 'doughnut', ['label'], [{data:{datasets: [{data:[1]}]}}], {})

  @if (! $place->isEmptyFonctionnement())
    financeChart.destroy()
    financeChart = charts.create(
        canvasFinancesId,
        "doughnut",
        getLabels("fonctionnement"),
        getDataChart("fonctionnement"),
        ['#ffc400', '#ff5728', '#c90035', '#96043e'],
        optionsChart
    );
    inputChoice.checked = true
  @elseif(! $place->isEmptyInvestissement())
    financeChart.destroy()
    financeChart = charts.create(
        canvasFinancesId,
        "doughnut",
        getLabels("investissement"),
        getDataChart("investissement"),
        ['#8e44ad', '#3498db', '#1abc9c', '#96043e'],
        optionsChart
      );
      inputChoice.checked = false
  @endif

  @if((!$place->isEmptyInvestissement() && !$place->isEmptyFonctionnement()  && !isset($edit)) || isset($edit))
    inputChoice.addEventListener('change', switchChart);
  @endif


</script>
