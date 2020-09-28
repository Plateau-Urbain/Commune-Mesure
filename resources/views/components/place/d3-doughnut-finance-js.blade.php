
@php ($quantityArtistes = $place->data->composition->{1}->nombre/$place->data->composition->{0}->nombre) @endphp
@php ($quantityStartup = $place->data->composition->{2}->nombre/$place->data->composition->{0}->nombre) @endphp
@php ($quantityAssociations = $place->data->composition->{3}->nombre/$place->data->composition->{0}->nombre) @endphp
@php ($quantityAutres = $place->data->composition->{4}->nombre/$place->data->composition->{0}->nombre) @endphp
<script>
var finances = JSON.parse("{{ json_encode($place->data->finance) }}".replace(/&quot;/g,'"'));
    data_finances = {
        datasets: [{
            data: [finances.depense.size, finances.recette.size],
            borderColor : "#fff",

            hoverBorderColor : "#e85048",
            backgroundColor: [
              "#f38b4a",
             "#56d798"
          ],
        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
            finances.depense.name,
            finances.recette.name,
        ]
    };

    var chart = charts.create("financement-budget-doughnut", "doughnut",
    data_finances.labels, data_finances.datasets, ['#ffc400', '#ff5728', '#c90035', '#96043e'],
    {
      legend: {
        display: true,
      },
    }

  );
  dataCompo = {
      datasets: [{
        data: [{{ $quantityArtistes *100}}, {{ $quantityStartup *100}},{{ $quantityAssociations *100}},{{ $quantityAutres *100}}],
          borderColor : "#fff",

          hoverBorderColor : "#e85048",
          backgroundColor: [
            "#DEEBEE",
            "#e1e1e3",
            "#E85048",
            "#343434"
          ],
      }],

      // These labels appear in the legend and in the tooltips when hovering different arcs
      labels: [
          'Artistes',
          'Start-up et entreprises',
          'Associations',
          'Autres structures'
      ]
  };

  var compositionChart = charts.create("composition-chart-doughnut", "doughnut",
  dataCompo.labels, dataCompo.datasets, ['#DEEBEE', '#ff5728', '#c90035', '#96043e'],
  {
    legend: {
      display: true,
    },
  }

);


</script>
