<script>
var finances = JSON.parse("{{ json_encode($place->data->finance) }}".replace(/&quot;/g,'"'));
    data_finances = {
        datasets: [{
            data: [finances.depense.size, finances.recette.size],
            borderColor : "#fff",

            hoverBorderColor : "#e85048",
            backgroundColor: [
              "#f38b4a",
              "#56d798",
              "#ff8397",
              "#6970d5"
            ],
            hoverBackgroundColor: [
              "#f38b4a",
              "#56d798",
              "#ff8397",
              "#6970d5"
            ]
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
</script>
