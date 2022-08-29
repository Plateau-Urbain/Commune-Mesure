<script type="text/javascript" src="https://d3js.org/d3.v4.min.js"></script>
<script>
  const color = d3.scaleOrdinal()
                  .range(['#cb4f4a', '#df9f8d', '#f6e6de', '#c2c0c6', '#64616c', '#262631']);
</script>

@include('js.place.d3.waffle')
@include('js.place.d3.investissement')
@include('js.place.d3.superficie')
@include('js.place.d3.fonctionnement')
@include('js.place.d3.insee')
