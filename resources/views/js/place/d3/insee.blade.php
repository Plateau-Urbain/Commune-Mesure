<script>
  const _DATA = JSON.parse('@JSON($place->get("blocs->data_territoire->donnees->insee"))')
  const insee = {}
  const zone_selector = document.getElementById("selectGeo");

  // Taille considérée comme mobile par bulma pour 
  let is_bulma_mobile = (window.innerWidth < 768)
  
  // Les différentes zones dans l'ordre (hors national)
  const zones = ['iris', 'commune', 'departement', 'region']

  // Zones avec des totaux de données à zéro par défaut
  // {iris: 0, commune: 0, departement: 0, region: 0}
  const init_total_par_zone = zones.reduce((acc,curr)=> (acc[curr]=0,acc),{})

  const zone_labels = {National: 'National', iris: 'Iris', commune: 'Commune', departement: 'Département', region: 'Région'}
  const zone_labels_mobile = {National: 'National', iris: 'Iris', commune: ['Com-', 'mune'], departement: ['Départe-', 'ment'], region: 'Région'}

  let svgwidth = parseInt(d3.select('svg#population-chart').style('width'), 10)
  let svgheight = parseInt(d3.select('svg#population-chart').style('height'), 10)
  
  let populationChart
  let socioChart
  let immoChart
  let z = zones[0]
  
  let populationChartTitle = "Population"
  let socioChartTitle = "Catégories socioprofessionnelles"
  let immoChartTitle = "Immobilier"

  // Initialise les totaux des données des zones à zéro pour chaque serie (dans l'idée d'identifier des zones sans données quand on aura chargé les données)
  let total_par_zone_par_serie = {
    activites: init_total_par_zone,
    csp: init_total_par_zone,
    logement: init_total_par_zone
  }

  /**
   * Crée un tableau avec deux entrées : le national et le premier non vide (iris généralement)
   */
  function fillDatasForSerie(serie) {

    // On intialise avec les données nationales qui sont toujours là
    serie_datas = [national[serie]]

    // S'il y a des données pour la zone
    if (total_par_zone_par_serie[serie][z] > 0) {
      serie_datas.push(insee[serie][z])
    } else {
      // On prend la première zone qui a des valeurs
      for (const [zone, total] of Object.entries(total_par_zone_par_serie[serie])) {
        console.log(zone + " / " + total)
        if (total > 0) {
          console.log(insee[serie][zone])
          serie_datas.push(insee[serie][zone])
          break
        }
      }
    }

    return serie_datas
  }

  function drawBars() {
    const bars_tooltips = document.getElementsByClassName('d3_tooltip bar') || []
    Array.from(bars_tooltips).forEach(function (tooltip) {
      tooltip.remove()
    })

    populationChart = BarChart('svg#population-chart', fillDatasForSerie('activites'), {width: svgwidth, height: svgheight, title: populationChartTitle})

    if (svgwidth < 640) {
      socioChartTitle = "CSP"
    }

    socioChart = BarChart('svg#csp-chart', fillDatasForSerie('csp'), {width: svgwidth, height: svgheight, title: socioChartTitle})
    immoChart = BarChart('svg#immobilier-chart', fillDatasForSerie('logement'), {width: svgwidth, height: svgheight, title: immoChartTitle})
  }

  // Reformatage des données au load
  window.addEventListener('load', (event) => {

    Object.entries(_DATA).forEach(function (zones) {
      const zone = zones[0]; // iris, commune, departement, region

      Object.entries(zones[1]).forEach(function (series) {
        const type = series[0] // activites, logement, csp

        if (typeof insee[type] === "undefined") {
          insee[type] = {}
        }

        insee[type][zone] = {
          zone: zone,
          subgroups: []
        }

        series[1].forEach(function (b) {
          insee[type][zone].subgroups.push({name: b.title, value: b.nb})
        })
      })
    })

    // On rempli le tableau des totaux par zone avec les bonnes valeurs
    // Et si pas de valeur on change le select de zone pour le dire
    for (const [serie, totaux] of Object.entries(total_par_zone_par_serie)) {
      for (const zone of Object.keys(totaux)) {
        total_zone = insee[serie][zone].subgroups.reduce((accum, item) => accum +  parseInt(item.value, 0), 0)
        // Met le total réellement calculé dans total_par_zone_par_serie
        total_par_zone_par_serie[serie][zone] = total_zone
        // Modifie le select de zone pour signifier qu'il n'y a pas de données
        if (total_zone == 0) {
          var opts = zone_selector.options
          for (var opt, j = 0; opt = opts[j]; j++) {
            if (opt.value == zone) {
              if (opt.getAttribute('nodata')) {
                opt.setAttribute('nodata', (parseInt(opt.getAttribute('nodata'), 0) + 1));
              } else {
                opt.setAttribute('nodata', 1);
                opt.disabled = true
                opt.text = opt.text + ' (Pas suffisamment de données)'
                // On init les graphes sur une autre zone pour pas avoir des bars vides (anti covid19)
                if (z == zone) {
                  z = zones[zones.indexOf(zone) + 1]
                }
              }
            }
          }
        }
      }
    }

    drawBars()

  });

  zone_selector.addEventListener('change', function (event) {
    z = event.target.value;
    populationChart.remove()
    socioChart.remove()
    immoChart.remove()

    drawBars()
  })

  window.addEventListener('resize', function () {
    populationChart.remove()
    socioChart.remove()
    immoChart.remove()

    const chartsContainer = document.querySelector('#charts-insee').getBoundingClientRect()

    svgwidth = parseInt(chartsContainer.width, 10)
    svgheight = parseInt(chartsContainer.height, 10)

    is_bulma_mobile = (window.innerWidth < 768)

    drawBars()
  })

  const national = {
    activites: {
      zone: "National",
      subgroups: [
        {name: "Actif occupé", value: 63.70},
        {name: "Autre inactif", value: 8.70},
        {name: "Chômeur (Actif inoccupé)", value: 10.30},
        {name: "Retraités ou préretraités", value: 6.70},
        {name: "Élèves, étudiants et stagiaires non rémunérés", value: 10.60}
      ]
    },

    logement: {
      zone: "National",
      subgroups: [
        {name: "Appart/Maison inoccupé", value: 0},
        {name: "Appartement", value: 43.71},
        {name: "Maison", value: 56.29}
      ]
    },

    csp: {
      zone: "National",
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

  function BarChart(element, data, {width = 1200, height = 100, title = "Graph"} = {}) {
    const margin = {top: 20, right: 0, bottom: 40, left: is_bulma_mobile ? 45 : 85}
    const w = width - margin.left - margin.right
    const _title = title
    
    // Les différents carrés de la barre
    const subgroups = Object.keys(data[0].subgroups)

    // Les différentes barres
    const groups    = d3.map(data, function (d) { return d.zone; }).keys()

    color.domain(subgroups)

    const x = d3.scaleLinear()
                .domain([0, 100])
                .range([0, w])

    const y = d3.scaleBand()
                .range([0, 70])
                .domain(groups)    // normalisation (cent pour centage)
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
                      .attr('class', 'd3_tooltip bar')
                      .attr('style', 'position: absolute; visibility: hidden');

    // Titre
    const svgTitle = svg.append('text')
      .text(_title + '')
      .attr('transform', 'translate(10,-5)')
      .attr('text-anchor', 'left')
      .style('font-size', '1.25rem')
      .style('font-family', 'Renner Black')
      .style('alignement-baseline', 'middle')
      .style('text-transform', 'uppercase')
      .attr('fill', '#262631')

      // L'engrenage cliquable (plus gros sur mobile parce que pas de texte)
      const gear_font_size = is_bulma_mobile ? '1rem' : '0.6rem'
      svgTitle.append('tspan')
              .attr('dx', '10')
              .style('font-family', '"Font Awesome 6 free"')
              .style('font-size', gear_font_size)
              .style('cursor', 'pointer')
              .attr('data-modal', 'modal-insee')
              .classed('bars_param', true)
              .text('\uf013') // gear

      svgTitle.append('tspan')
        .attr('dx', '1')
        .attr('data-modal', 'modal-insee')
        .classed('bars_param', true)
        .classed('is-hidden-mobile', true)
        .style('font-size', '0.6rem')
        .style('text-transform', 'unset')
        .style('cursor',  'pointer')
        .text('Changer la comparaison')

    // axe y
    const series_labels = svg.append("g").style('font-size', '12px').attr('text-anchor', 'end')

    // Les labels pour chaque série
    let trans_y_labs = 25 // translation y pour le text
    data.forEach((d) => {
      const zlabel = is_bulma_mobile ? zone_labels_mobile[d.zone] : zone_labels[d.zone]
      console.log(zlabel)
      if (Array.isArray(zlabel)) {
        coucou = series_labels.append('g')
        .attr('transform', "translate(0,"+(trans_y_labs-3)+")").append('text')
        coucou.append('tspan').attr('text-anchor', 'end').text(zlabel[0])
        coucou.append('tspan').attr('text-anchor', 'end').attr('x', '0').attr('dy', '10').text(zlabel[1])
      } else {
        series_labels.append('g')
        .attr('transform', "translate(0,"+trans_y_labs+")")
        .append('text')
        .text(zlabel)
      }

      trans_y_labs += trans_y_labs + 10
    })

    // bars
    const niveau = svg.append("g").classed('bars_group', true)
       .selectAll("g")
       .data(stacked)
       .enter().append("g")
         .attr('transform', "translate(10,10)")
         .attr("fill", function (d) { return color(d.key) });

    const carres = niveau.selectAll("rect")
         .data(function (d) { return d })
         .enter().append("rect")
           .attr("x", function (d) { return x(d[0]) })
           .attr("y", function (d) { return y(d.data.zone) })
           .attr("width", function (d) {
              let rw = x(d[1]) - x(d[0]) - 7
              if (rw < 0) rw += 7
             return rw
           })
           .attr("height", y.bandwidth() - 10)

          .on("mouseover", function() { return tooltip.style("visibility", "visible") })
          .on("mousemove", function(d) {
            const subgroupkey = d3.select(this.parentNode).datum().key
            return tooltip
              .text(d.data.subgroups[subgroupkey].name + " : " + Math.round(d[1] - d[0]) + "%")
              .style("top", (d3.event.pageY + 25)+"px")
              .style("left", (d3.event.pageX + 25)+"px")
          })
          .on("mouseout", function(){ return tooltip.style("visibility", "hidden") });

    const legends = svg.append('g')
      .attr('transform', 'translate(15,0)')
      .selectAll('g')
      .data(subgroups)
      .enter().append('g')

    const legendCircle = legends.append('rect')
        .attr('width', 10).attr('height', 10).attr('y', -5).attr('x', -5)
        .attr('fill', d => color(d))

    const legendText = legends.append('text')
      .text((d) => data[0].subgroups[d].name)
        .attr('y', 4)
        .attr('dx', 10)
        .attr("text-anchor", 'left')
        .style("alignment-baseline", "middle")
        .style("font-size", '12px')

    const legends_width_start = 0
    const legends_height_start = d3.select('.bars_group').node().getBBox().height + 30

    legends.each(function () {
      el = d3.select(this)

      el.attr('transform', function () {
        const translate = 'translate(%x%,%y%)'
        const prev = this.previousSibling

        if (prev === null) {
          legends_width = legends_width_start
          legends_height = legends_height_start
          return translate.replace('%x%', 0).replace('%y%', legends_height)
        }

        const bounds = d3.select(prev).node().getBBox()
        legends_width += bounds.width + 15

        if (legends_width + d3.select(this).node().getBBox().width > w) {
          legends_width = legends_width_start
          legends_height += 20
        }

        return translate.replace('%x%', legends_width).replace('%y%', legends_height)
      })
    })

    // on retaille la hauteur du svg
    total_h = document.querySelector(element).attributes.getNamedItem('height');
    total_h.value = svg.node().getBoundingClientRect().height + 20

    return svg;
  }
</script>

@push('modals')
  @include('components/modals/modalInsee')
@endpush
