<script type="text/javascript">
  const svg_fonctionnement  = d3.select('svg#financement-budget-doughnut')
  const width               = svg_fonctionnement.node().getBoundingClientRect().width
  const height              = svg_fonctionnement.node().getBoundingClientRect().height
  const margin              = 40

  const radius = Math.min(width, height) / 2 - margin

  const donut_data = [
    {name: "Recettes", count: {{ $place->get('blocs->moyens->donnees->fonctionnement->Recettes') }} },
    {name: "Aides publiques", count: {{ $place->get('blocs->moyens->donnees->fonctionnement->Aides publiques') }} },
    {name: "Aides privées", count: {{ $place->get('blocs->moyens->donnees->fonctionnement->Aides privées') }} },
    {name: "Autres subventions", count: {{ $place->get('blocs->moyens->donnees->fonctionnement->Autres Subventions') }} }
  ]
  color.domain(donut_data.map(d => d.name))

  const pieArcData = d3.pie()
    .value(d => d.count)(donut_data)
  const arc = d3.arc()
    .innerRadius(radius * 0.5)
    .outerRadius(radius * 0.8)
    .padRadius(200)
    .padAngle(5/300)

  svg_fonctionnement.attr('viewBox', [-width / 2, -height / 2, width, height])
    .append('g')
    .selectAll('path')
    .data(pieArcData)
    .enter()
    .append('path')
    .attr('d', (d) => arc(d))
    .attr('fill', (d) => color(d.data.name))

  svg_fonctionnement.append('g')
    .attr("font-family", "sans-serif")
    .attr("font-size", 26)
    .attr("text-anchor", "middle")
    .selectAll('text')
    .data(pieArcData)
    .enter()
    .append('text')
    .attr('transform', (d) => `translate(${arc.centroid(d).join(',')})`)
    .attr('fill', "white")
    .attr('stroke', 'black')
    .attr('stroke-width', '1')
    .text((d) => (d.data.count) ? d.data.name+' : \n'+d.data.count : '')

</script>

