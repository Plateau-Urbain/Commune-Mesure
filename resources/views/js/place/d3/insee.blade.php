<script>
  const population = [
    {
      zone: "Niveau National",
      subgroups: {
        actif: { value: 12, name: "Actifs"},
        chomeur: { value: 34, name: "Chômeurs"},
        retraite: { value: 3, name: "Retraités"},
        etudiant: { value: 26, name: "Étudiants"}
      }
    },
    {
      zone: "Niveau IRIS",
      subgroups: {
        actif: { value: 21, name: "Actifs"},
        chomeur: { value: 44, name: "Chômeurs"},
        retraite: { value: 6, name: "Retraités"},
        etudiant: { value: 55, name: "Étudiants"}
      }
    }
  ];

  const chart = BarChart('svg#population-chart', population, {width: 800, height: 150})

  function BarChart(element, data, {horizontal = true, width = 100, height = 100} = {}) {
    const margin = {top: 20, right: 30, bottom: 40, left: 90}
    const w = width - margin.left - margin.right
    const h = height - margin.top - margin.bottom

    // Les différents carrés de la barre
    const subgroups = Object.keys(data[0].subgroups)
    // Les différentes barres
    const groups    = d3.map(data, function (d) { return d.zone }).keys()

    color.domain(subgroups)

    const x = d3.scaleLinear()
                .domain([0, 100])
                .range([0, w])

    const y = d3.scaleBand()
                .range([0, 60])
                .domain(groups)

    // normalisation (cent pour centage)
    data.forEach(function (d) {
      let total = 0
      subgroups.forEach((s) => { total += +d.subgroups[s].value })
      subgroups.forEach((s) => { d.subgroups[s].value = d.subgroups[s].value / total * 100 })
    })


    // stackage
    const stacked = d3.stack()
                      .keys(subgroups)
                      .value((d, k) => d.subgroups[k].value)
                      (data)

    // creation svg
    const svg = d3.select(element)
                  .attr("width", width)
                  .attr("height", height)
                  .append("g")
                    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    // axe y
    svg.append("g")
      .call(d3.axisLeft(y).tickSize(0))
      .select(".domain").remove()

    // bars
    const niveau = svg.append("g")
       .selectAll("g")
       .data(stacked)
       .enter().append("g")
         .attr("fill", function (d) { return color(d.key) });

    const carres = niveau.selectAll("rect")
         .data(function (d) { return d })
         .enter().append("rect")
           .attr("x", function (d) { return x(d[0]) })
           .attr("y", function (d) { return y(d.data.zone) })
           .attr("width", function (d) { return x(d[1]) - x(d[0]) - 3 })
           .attr("height", y.bandwidth() - 5)
           .attr("stroke", "black")
           .attr("stroke-width", 1)

    const texts = niveau.selectAll("text")
       .data(function (d) { return d })
       .enter()
       .append('text').classed('stack', true)
          .attr("x", function (d) { return x(d[0]) + 5 } )
          .attr("y", function (d) { return y(d.data.zone) + 20 })
          .attr("text-anchor", "start") // text-align: right
          .text(function (d) { const v = Math.round(d[1] - d[0]); return (v >= 10) ? v + "%" : '' })
            .attr("fill", "#000")

    const legend = svg.selectAll('legend')
      .data(subgroups)
      .enter()
      .append('circle')
        .attr('cx', (d, i) => i * (w / subgroups.length))
        .attr('cy', h)
        .attr('r', 10)
        .attr('fill', d => color(d))

    const legendlabel = svg.selectAll('label')
      .data(subgroups.map((s) => data[0].subgroups[s].name))
      .enter()
      .append('text')
        .attr('x', (d, i) => 15 + i * (w / subgroups.length))
        .attr('y', h + 5)
        .text((d) => d)
          .attr("text-anchor", 'left')
          .style("alignment-baseline", "middle")
  }
</script>
