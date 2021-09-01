<script>
var finances = {"composition":[{"name":"Entreprises","size":{{ $place->get('blocs->composition->donnees->type->Entreprises') }}},
                               {"name":"Associations","size":{{ $place->get('blocs->composition->donnees->type->Associations') }}},
                               {"name":"Artistes","size":{{ $place->get('blocs->composition->donnees->type->Artistes') }}},
                               {"name":"Autres structures","size":{{ $place->get('blocs->composition->donnees->type->Autres structures') }}}
                              ],
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
var inputChoice = document.querySelector("input#switchRoundedSuccess");
var canvasFinancesId = 'financement-budget-doughnut'

function getLabels(id){
  var labels = [];
  finances[id].forEach(node => {
    // console.log(node)
    labels.push(node.name);
  })
  return labels;
}

function getDataChart(id){
  var datasetsStruct = [{
      data: [],
      borderColor : "#fff",
      hoverBorderColor : "#e85048",
      backgroundColor: ['#ffc400', '#ff5728', '#c90035', '#96043e'],
  }];

  var dataset = [];
  // console.log(id);
  finances[id].forEach(node => {
    dataset.push(node.size);
  })

  datasetsStruct[0].data = dataset;

  return datasetsStruct;
}


var financeChart = charts.create(canvasFinancesId, "doughnut",
    getLabels("fonctionnement"), getDataChart("fonctionnement"), ['#ffc400', '#ff5728', '#c90035', '#96043e'],
    {
      legend: {
        display: true,
      },
    }
  );

@if(!$place->isEmptyInvestissement() && $place->isEmptyFonctionnement())
  var financeChart = charts.create(canvasFinancesId, "doughnut",
      getLabels("investissement"), getDataChart("investissement"), ['#8e44ad', '#3498db', '#1abc9c', '#96043e'],
      {
        legend: {
          display: true,
        },
      }
    );
@endif



  var dataCompo = charts.create("composition-chart-doughnut", "doughnut",
      getLabels("composition"), getDataChart("composition"), ['#DEEBEE', '#ff5728', '#1abc9c', '#96043e'],
      {
        legend: {
          display: true,
        },
      }

    );

@if((!$place->isEmptyInvestissement() && !$place->isEmptyFonctionnement()  && !isset($edit)) || isset($edit))
  document.querySelector("input#switchRoundedSuccess").addEventListener('change', switchChart);
@endif

function switchChart(){
  financeChart.destroy();

  if(inputChoice.checked){
    //Fonctionnement
    financeChart = charts.create(canvasFinancesId, "doughnut",
        getLabels("fonctionnement"), getDataChart("fonctionnement"), ['#ffc400', '#ff5728', '#c90035', '#96043e'],
        {
          legend: {
            display: true,
          },
        }

      );
      document.querySelector("label#label_investissement").style.fontWeight = "normal";
  }else{
    //Investissement
    financeChart = charts.create(canvasFinancesId, "doughnut",
        getLabels("investissement"), getDataChart("investissement"), ['#8e44ad', '#3498db', '#1abc9c', '#96043e'],
        {
          legend: {
            display: true,
          },
        }

      );
      document.querySelector("label#label_investissement").style.fontWeight = "bold";

  }

}


</script>
