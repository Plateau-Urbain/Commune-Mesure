<script type="text/javascript">
  const svg_fonctionnement  = d3.select('svg#financement-budget-doughnut')

  if (svg_fonctionnement.node() === null) {
    throw new Error('No fonctionnement chart');
  }

  const fonctionnement_width  = svg_fonctionnement.node().getBoundingClientRect().width
  const fonctionnement_height = svg_fonctionnement.node().getBoundingClientRect().height - 100
  const fonctionnement_margin = 40

  const fonctionnement_radius = Math.min(fonctionnement_width, fonctionnement_height) / 2 - fonctionnement_margin

  const tooltip_fonctionnement_id = 'tooltip-fonctionnement';

  d3.select('body')
    .append('div')
    .attr('id', tooltip_fonctionnement_id)
    .attr('class', 'd3_tooltip')
    .attr('style', 'position: absolute; opacity: 0;');

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
    .innerRadius(fonctionnement_radius * 0.5)
    .outerRadius(fonctionnement_radius * 0.8)
    .padRadius(200)
    .padAngle(5/300)

  svg_fonctionnement
    .attr('width', fonctionnement_width)
    .attr('height', fonctionnement_height + 100)
    .append('g')
    .attr("transform", "translate(" + fonctionnement_width / 2 + "," + fonctionnement_height / 2 + ")")
    .selectAll('path')
    .data(pieArcData)
    .enter()
    .append('path')
    .attr('d', (d) => arc(d))
    .attr('fill', (d) => color(d.data.name))
    .on("mouseover", function(d) {
      d3.select('#'+tooltip_fonctionnement_id)
        .style('opacity', ! isNaN(d.data.count) * 1 )
        .text( function(a) {
          if (d.data.count)
            return d.data.name+' : '+d.data.count+' €';
        })
    } )
    .on('mousemove', function(d) {
      d3.select('#'+tooltip_fonctionnement_id)
        .style('left', (d3.event.pageX + 25) + 'px')
        .style('top', (d3.event.pageY + 25) + 'px')
    })
    .on("mouseout", function(d) {
      d3.select('#'+tooltip_fonctionnement_id)
        .style('opacity', 0);
    } )

    svg_fonctionnement
      .selectAll('legend')
      .data(pieArcData)
      .enter()
      .append('circle')
      .attr('cx', function(d, i) { return 80 + (i % 2)* fonctionnement_width / 2.5 + 10})
      .attr('cy', function(d, i) { return fonctionnement_height + 30 * (1 + Math.floor( i / 2 )) })
      .attr('r', function(d) { return 10})
      .attr('fill', function(d) { return color(d.data.name)})

    svg_fonctionnement
      .selectAll('legend-text')
      .data(pieArcData)
      .enter()
      .append('text')
      .attr('x', function(d, i) { return 100 + (i % 2)* fonctionnement_width / 2.5 + 10})
      .attr('y', function(d, i) { return fonctionnement_height + 33 * (1 + Math.floor( i / 2 )) })
      .attr('fill', 'black')
      .text(function(d) { return d.data.name })

</script>
