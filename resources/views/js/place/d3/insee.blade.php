<script>
  const _DATA = JSON.parse('@JSON($place->get("blocs->data_territoire->donnees->insee"))')
  const insee = {}
  const select = document.getElementById("selectGeo");
  let z = 'iris'

  select.addEventListener('change', function (event) {
    z = event.target.value;
    populationChart.remove()
    socioChart.remove()
    immoChart.remove()

    populationChart = BarChart('svg#population-chart', [national.activites, insee.activites[z]], {width: 800, height: 150})
    socioChart = BarChart('svg#csp-chart', [national.csp, insee.csp[z]], {width: 800, height: 150})
    immoChart = BarChart('svg#immobilier-chart', [national.logement, insee.logement[z]], {width: 800, height: 150})
  })

  const national = {
    activites: {
      zone: "Données national",
      subgroups: [
        {name: "Actif occupé", value: 63.70},
        {name: "Autre inactif", value: 8.70},
        {name: "Chômeur (Actif inoccupé)", value: 10.30},
        {name: "Retraités ou préretraités", value: 6.70},
        {name: "Élèves, étudiants et stagiaires non rémunérés", value: 10.60}
      ]
    },

    logement: {
      zone: "Données national",
      subgroups: [
        {name: "Appart/Maison inoccupé", value: 0},
        {name: "Appartement", value: 43.71},
        {name: "Maison", value: 56.29}
      ]
    },

    csp: {
      zone: "Données national",
      subgroups: [
        {name: "Agriculteurs exploitants", value: 0},
        {name: "Artisans, Comm., Chefs entr.", value: 1.36},
        {name: "Autres", value: 6.12},
        {name: "Cadres, Prof. intel. sup.", value: 16.54},
        {name: "Employés", value: 28.94},
        {name: "Ouvriers", value: 21.83},
        {name: "Prof. intermédiaires", value: 25.21},
        {name: "Retraités", value: 0}
      ]
    }
  }

  Object.entries(_DATA).forEach(function (zones) {
    const zone = zones[0]; // iris, commune, departement, region

    Object.entries(zones[1]).forEach(function (series) {
      const type = series[0] // activites, logement, csp

      if (typeof insee[type] === "undefined") {
        insee[type] = {}
      }

      insee[type][zone] = {
        zone: "Données "+zone,
        subgroups: []
      }

      series[1].forEach(function (b) {
        insee[type][zone].subgroups.push({name: b.title, value: b.nb})
      })
    })
  })

  let populationChart = BarChart('svg#population-chart', [national.activites, insee.activites[z]], {width: 800, height: 150})
  let socioChart = BarChart('svg#csp-chart', [national.csp, insee.csp[z]], {width: 800, height: 150})
  let immoChart = BarChart('svg#immobilier-chart', [national.logement, insee.logement[z]], {width: 800, height: 150})

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

    const tooltip = d3.select('body')
                      .append('div')
                      .attr('id', 'tooltip-barchar-'+Math.random().toString(36).slice(2))
                      .attr('class', 'd3_tooltip')
                      .attr('style', 'position: absolute; visibility: hidden');

    // axe y
    svg.append("g")
      .call(d3.axisLeft(y).tickSize(0))
      .select(".domain").remove()

    // bars
    const niveau = svg.append("g")
       .selectAll("g")
       .data(stacked)
       .enter().append("g")
         .attr('transform', "translate(" + 10 + ",0)")
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

          .on("mouseover", function() { return tooltip.style("visibility", "visible") })
          .on("mousemove", function(d) {
            const subgroupkey = d3.select(this.parentNode).datum().key
            return tooltip
              .text(d.data.subgroups[subgroupkey].name + " : " + Math.round(d[1] - d[0]) + "%")
              .style("top", (d3.event.pageY + 25)+"px")
              .style("left", (d3.event.pageX + 25)+"px")
          })
          .on("mouseout", function(){ return tooltip.style("visibility", "hidden") });

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

    return svg;
  }
</script>
