<script type="text/javascript">
const tooltip_superficie_id = 'tooltip-superficie';

var superficie_totale = {{ $place->get('blocs->presentation->donnees->surfaces->totale') ?: 0 }};
var superficie_exterieure = {{ $place->get('blocs->presentation->donnees->surfaces->exterieur') ?: 0 }};
var superficie_bureaux = {{ $place->get('blocs->presentation->donnees->surfaces->bureau') ?: 0 }};
var superficie_ateliers = {{ $place->get('blocs->presentation->donnees->surfaces->atelier') ?: 0 }};

var superficie_interieure = superficie_totale - superficie_exterieure;
var superficie_autres = superficie_interieure - superficie_bureaux - superficie_ateliers;
var superficie_pc_interieur = superficie_interieure / superficie_totale;
var superficie_pc_bureaux = superficie_bureaux / superficie_interieure;
var superficie_pc_ateliers = superficie_ateliers / superficie_interieure;
var superficie_pc_autres = superficie_autres / superficie_interieure;
var superficie_width = svg_waffle.node().getBoundingClientRect().width;
var superficie_height = svg_waffle.node().getBoundingClientRect().height - 100;
var superficie_names = [
    'superficie_exterieur',
    'superficie_interieure_fond',
    'superficie_interieure_contour',
    'superficie_autres',
    'superficie_bureaux',
    'superficie_ateliers'
]

var superficie_human_keys = [
  'superficie_exterieur',
  'superficie_bureaux',
  'superficie_ateliers',
  'superficie_autres',
];

var function_superficie_width = function(d) {
    if (d == 'superficie_exterieur') return superficie_width - 20;
    if (d == 'superficie_interieure') return Math.sqrt(superficie_pc_interieur) * function_superficie_width('superficie_exterieur');
    if (d == 'superficie_interieure_fond') return function_superficie_width('superficie_interieure') + 25;
    if (d == 'superficie_interieure_contour') return function_superficie_width('superficie_interieure') + 25;
    if (d == 'superficie_autres') return function_superficie_width('superficie_interieure') * superficie_pc_autres;
    if (d == 'superficie_bureaux') return function_superficie_width('superficie_interieure') - function_superficie_width('superficie_autres');
    if (d == 'superficie_ateliers') return function_superficie_width('superficie_bureaux');
}

var function_superficie_height = function(d) {
    if (d == 'superficie_exterieur') return superficie_height - 20;
    if (d == 'superficie_interieure') return Math.sqrt(superficie_pc_interieur) * function_superficie_height('superficie_exterieur');
    if (d == 'superficie_interieure_fond') return function_superficie_height('superficie_interieure') + 25;
    if (d == 'superficie_interieure_contour') return function_superficie_height('superficie_interieure') + 25;
    if (d == 'superficie_autres') return function_superficie_height('superficie_interieure') + 5;
    if (d == 'superficie_bureaux') return function_superficie_width('superficie_interieure') * function_superficie_height('superficie_interieure') * superficie_pc_bureaux / function_superficie_width('superficie_bureaux');
    if (d == 'superficie_ateliers') return function_superficie_height('superficie_autres') - function_superficie_height('superficie_bureaux') - 5;
}

superficie_colors = ['#cb4f4a', '#df9f8d', '#f6e6de'];

var function_superficie_fill = function(d) {
    if (d == 'superficie_exterieur') return d3.rgb('green');
    if (d == 'superficie_ateliers') return d3.rgb(superficie_colors[0]);
    if (d == 'superficie_bureaux') return d3.rgb(superficie_colors[1]);
    if (d == 'superficie_autres') return d3.rgb(superficie_colors[2]);
    return d3.rgb('#f9f7f4');
}

var function_superficie_x = function(d) {
    if (d == 'superficie_exterieur') return 0;
    if (d == 'superficie_interieure_fond') return function_superficie_x('superficie_interieure') - 20;
    if (d == 'superficie_interieure_contour') return function_superficie_x('superficie_interieure') - 10;
    if (d == 'superficie_interieure') return (function_superficie_width('superficie_exterieur') - Math.sqrt(superficie_pc_interieur) * function_superficie_width('superficie_exterieur') ) ;
    if (d == 'superficie_bureaux') return function_superficie_x('superficie_interieure');
    if (d == 'superficie_autres') return function_superficie_x('superficie_bureaux') + function_superficie_width('superficie_bureaux') + 5;
    if (d == 'superficie_ateliers') return function_superficie_x('superficie_bureaux');

}

var function_superficie_y = function(d) {
    if (d == 'superficie_exterieur') return 0;
    if (d == 'superficie_interieure_fond') return function_superficie_y('superficie_interieure') - 20;
    if (d == 'superficie_interieure_contour') return function_superficie_y('superficie_interieure') - 10;
    if (d == 'superficie_interieure') return (function_superficie_height('superficie_exterieur') - Math.sqrt(superficie_pc_interieur) * function_superficie_height('superficie_exterieur')) ;
    if (d == 'superficie_autres') return function_superficie_y('superficie_interieure');
    if (d == 'superficie_bureaux') return function_superficie_y('superficie_interieure');
    if (d == 'superficie_ateliers') return function_superficie_y('superficie_interieure') + function_superficie_height('superficie_bureaux') + 5;
}

var function_superficie_text_1 = function(d) {
    if (! function_superficie_width(d)) {
        return ;
    }
    if (d == 'superficie_exterieur') return 'Extérieurs : '+parseInt(superficie_exterieure) + ' m²';;
    if (function_superficie_height(d) < 100) {
        if (d == 'superficie_autres') return 'Autres : '+ parseInt(superficie_autres) + ' m²';
        if (d == 'superficie_bureaux') return 'Bureaux : '+ parseInt(superficie_bureaux) + ' m²';
        if (d == 'superficie_ateliers') return 'Ateliers : '+ parseInt(superficie_ateliers) + ' m²';
    }else {
        if (d == 'superficie_autres') return 'Autres :';
        if (d == 'superficie_bureaux') return 'Bureaux :';
        if (d == 'superficie_ateliers') return 'Ateliers :';
    }
    return ;
}

var function_superficie_text_2 = function(d) {
    if (! function_superficie_width(d)) {
        return ;
    }
    if (function_superficie_height(d) >= 100) {
        if (d == 'superficie_autres') return parseInt(superficie_autres) + ' m²';
        if (d == 'superficie_bureaux') return parseInt(superficie_bureaux) + ' m²';
        if (d == 'superficie_ateliers') return parseInt(superficie_ateliers) + ' m²';
    }
}

var function_superficie_text_x = function(d) {
    return function_superficie_x(d) + function_superficie_width(d) / 2;
}

var function_superficie_text_y = function(d) {
    if (d == 'superficie_exterieur') {
        return ((function_superficie_height('superficie_exterieur') - function_superficie_height('superficie_interieure') ) / 2 );
    }
    return function_superficie_y(d) + function_superficie_height(d) / 2 ;
}

var superficie_rect_onmouseover = function(d, i) {
    d3.select('#'+tooltip_superficie_id)
      .style('opacity', function(a) {
          if (d == 'superficie_exterieur')  { return 1; }
          if (d == 'superficie_interieure') { return 1; }
          if (d == 'superficie_autres')     { return 1; }
          if (d == 'superficie_bureaux')    { return 1; }
          if (d == 'superficie_ateliers')   { return 1; }
          console.log('not opacity: '+d);
          return 0;
      } )
     .text( function(a) {
        if (d == 'superficie_exterieur') return 'Extérieurs : '+parseInt(superficie_exterieure) + ' m²';;
        if (d == 'superficie_autres') return 'Autres : '+ parseInt(superficie_autres) + ' m²';
        if (d == 'superficie_bureaux') return 'Bureaux : '+ parseInt(superficie_bureaux) + ' m²';
        if (d == 'superficie_ateliers') return 'Ateliers : '+ parseInt(superficie_ateliers) + ' m²';
      })
    d3.select('#text_'+d)
        .attr('class', 'highlight');
}

var superficie_rect_onmouseout = function(d, i) {
    d3.select('#text_'+d)
        .attr('class', 'normal');
    d3.select('#'+tooltip_superficie_id)
      .style('opacity', 0);
}

var superficie_figures = d3.select("#graph_superficie")
    .append('g')
    .attr('class', 'figures')

d3.select('body')
    .append('div')
    .attr('id', tooltip_superficie_id)
    .attr('class', 'd3_tooltip')
    .attr('style', 'position: absolute; opacity: 0;');

var superficie_rects = superficie_figures.selectAll('rect')
    .data(superficie_names)
    .enter()
    .append('rect')
    .attr('class', (d) => d)
    .attr('fill', function_superficie_fill )
    .attr('width', function_superficie_width )
    .attr('height', function_superficie_height )
    .attr('x', function_superficie_x )
    .attr('y', function_superficie_y )
    .on("mouseover", superficie_rect_onmouseover)
    .on("mouseout", superficie_rect_onmouseout)
    .on('mousemove', function(d) {
      d3.select('#'+tooltip_superficie_id)
        .style('left', (d3.event.pageX + 25) + 'px')
        .style('top', (d3.event.pageY + 25) + 'px')
    })
var superficie_gtexts = d3.select("#graph_superficie")
    .append('g')
    .attr('class', 'texts')

var superficie_texts = superficie_gtexts.selectAll('text')
    .data(superficie_names)
    .enter()
    .append('text')
    .attr('id', (d) => 'text_'+d)
    .attr('x', function_superficie_text_x )
    .attr('y', function_superficie_text_y )

superficie_texts.append('tspan')
    .text( function_superficie_text_1 )

superficie_texts.append('tspan')
    .text( function_superficie_text_2 )
    .attr('x', function_superficie_text_x )
    .attr('y', function_superficie_text_y )
    .attr('dy', '17' )

d3.select("#graph_superficie")
      .selectAll('legend')
      .data(superficie_human_keys)
      .enter()
      .append('circle')
      .attr('cx', function(d, i) { return center_x + (i % 2)* width_waffle / 2.5 + 10})
      .attr('cy', function(d, i) { return height_waffle + 30 * (1 + Math.floor( i / 2 )) })
      .attr('r', function(d) { return 10})
      .attr('fill', function_superficie_fill)

d3.select("#graph_superficie")
      .selectAll('legend-text')
      .data(superficie_human_keys)
      .enter()
      .append('text')
      .attr('x', function(d, i) { return center_x + (i % 2)* width_waffle / 2.5 + 30})
      .attr('y', function(d, i) { return height_waffle + 33 * (1 + Math.floor( i / 2 )) })
      .attr('fill', 'black')
      .text(function(d) {
        if (d == 'superficie_exterieur') return 'Superficie extérieure';
        if (d == 'superficie_autres') return 'Autres superficies';
        if (d == 'superficie_bureaux') return 'Superficie de bureaux';
        if (d == 'superficie_ateliers') return "Superficie d'ateliers";
      })

</script>
