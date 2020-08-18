<script>
var activitiesMerits = JSON.parse("{{ json_encode($place->structure) }}".replace(/&quot;/g,'"'));
var myActivities = activitiesMerits.activities;
var myMerits = activitiesMerits.merits;
var graph = {
  nodes: [],
  edges: []
};
  var s = new sigma(
    {
      renderer: {
        container: document.getElementById('sigma'),
        type: 'canvas'
      },
      settings: {
        edgeLabelSize: 'proportional',
        minArrowSize: 10
      }
    }
  );

  var graph = {
    nodes: [],
    edges: []
  };


  myActivities.concat(myMerits).map(function(d, i){
    graph.nodes.push({
      id:  i,
      label: d.text,
      x: Math.random(),
      y: Math.random(),
      size: 1,
      color: d.color
    });
  });
  myActivities.map(function(d, i){
    d.edge.map(function(e, t){
      graph.edges.push({
        id: 'edge'+i+''+e,
        source: i,
        target: myActivities.length+e,
        color: d.color,
        type: 'curvedArrow'
      });
    })

  });

  s.graph.read(graph);
  s.refresh();
  s.startForceAtlas2();
  window.setTimeout(function() {s.killForceAtlas2()}, 5000);

</script>
