<script>
  const population = [
    {
      zone: "Niveau National",
      subgroups: { actif: 12, chomeur: 34, retraite: 3, etudiant: 26 }
    },
    {
      zone: "Niveau IRIS",
      subgroups: { actif: 21, chomeur: 44, retraite: 6, etudiant: 55 }
    }
  ];

  const chart = BarChart('svg#population-chart', population, {width: 400, height: 400})

  function BarChart(element, data, {horizontal = true, width = 100, height = 100} = {}) {
    const margin = {top: 20, right: 30, bottom: 40, left: 90}
    const w = width - margin.left - margin.right
    const h = height - margin.top - margin.bottom

    const subgroups = Object.keys(data[0].subgroups)
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
      subgroups.forEach((s) => { total += +d.subgroups[s] })
      subgroups.forEach((s) => { d.subgroups[s] = d.subgroups[s] / total * 100 })
    })

    // stackage
    const stacked = d3.stack()
                      .keys(subgroups)
                      .value((d, k) => d.subgroups[k])
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
    svg.append("g")
       .selectAll("g")
       .data(stacked)
       .enter().append("g")
         .attr("fill", function (d) { return color(d.key) })
         .selectAll("rect")
         .data(function (d) { return d })
         .enter().append("rect")
           .attr("x", function (d) { return x(d[0]) })
           .attr("y", function (d) { return y(d.data.zone) })
           .attr("width", function (d) { return x(d[1]) - x(d[0]) - 3 })
           .attr("height", y.bandwidth() - 5)

  }
</script>
