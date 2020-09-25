<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
@php ($quantity1 = $place->data->composition->{1}->nombre/$place->data->composition->{0}->nombre) @endphp
@php ($quantity2 = $place->data->composition->{2}->nombre/$place->data->composition->{0}->nombre) @endphp
@php ($quantity3 = $place->data->composition->{3}->nombre/$place->data->composition->{0}->nombre) @endphp
@php ($quantity4 = $place->data->composition->{4}->nombre/$place->data->composition->{0}->nombre) @endphp
<script>
var myChart = new Chart(document.getElementById("composition-doughnut"), {
    type: 'doughnut',
    data: {
      labels: ["Artistes", "Startup et entreprises", "Associations","Autres structures"],
      datasets: [
        {
          label: "Données INSEE",
          backgroundColor: ["#DEEBEE", "#F1F1F1","#F1F1F1"],
          data: ["{{ number_format(number_format($quantity1,1)*100, 2) }}", "{{ number_format(number_format($quantity2,1)*100, 2) }}","{{ number_format(number_format($quantity3,1)*100, 2) }}","{{ number_format(number_format($quantity4,1)*100, 2) }}"]
        }
      ]
    },
    options: {
      legend: {
        display: false,
      },
    }
});
</script>
