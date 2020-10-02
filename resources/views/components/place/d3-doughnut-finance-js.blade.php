<script>
var finances = JSON.parse("{{ json_encode($place->data->finance) }}".replace(/&quot;/g,'"'));
 
function getLabels(id){
  var labels = [];
  finances[id].forEach(node => {
    console.log(node)
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
  console.log(id);
  finances[id].forEach(node => {
    dataset.push(node.size);
  })

  datasetsStruct[0].data = dataset;

  return datasetsStruct;
}


var financeChart = charts.create("financement-budget-doughnut", "doughnut",
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
  var inputChoice = document.querySelector("input#switchRoundedSuccess");
  if(inputChoice.checked){
    //Fonctionnement
    charts.create("financement-budget-doughnut", "doughnut",
        getLabels("fonctionnement"), getDataChart("fonctionnement"), ['#ffc400', '#ff5728', '#c90035', '#96043e'],
        {
          legend: {
            display: true,
          },
        }

      );
  }else{
    //Investissement
    charts.create("financement-budget-doughnut", "doughnut",
        getLabels("investissement"), getDataChart("investissement"), ['#8e44ad', '#3498db', '#1abc9c', '#96043e'],
        {
          legend: {
            display: true,
          },
        }

      );

  }

}


</script>
