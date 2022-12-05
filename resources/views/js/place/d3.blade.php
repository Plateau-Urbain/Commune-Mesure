<script type="text/javascript" src="https://d3js.org/d3.v4.min.js"></script>
<script>
  const color = d3.scaleOrdinal()
                  .range(['#C7514D', '#EA7B6C', '#E9C3B7', '#DDEBEF', '#7E97A7', '#B5CAB5', '#6C9871', '#8F8E92', '#262531']);
</script>

@include('js.place.d3.waffle')
@include('js.place.d3.investissement')
@include('js.place.d3.superficie')
@include('js.place.d3.fonctionnement')
@include('js.place.d3.insee')
