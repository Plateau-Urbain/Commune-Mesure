<script>
var finances = @json($place->get('data->finance'));
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

  var dataCompo = charts.create("composition-chart-doughnut", "doughnut",
      getLabels("composition"), getDataChart("composition"), ['#DEEBEE', '#ff5728', '#1abc9c', '#96043e'],
      {
        legend: {
          display: true,
        },
      }

    );

document.querySelector("input#switchRoundedSuccess").addEventListener('change', switchChart);

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
