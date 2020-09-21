<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/plugins/forceDirected.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script>
am4core.ready(function() {

am4core.useTheme(am4themes_animated);
var chart = am4core.create("chartdiv", am4plugins_forceDirected.ForceDirectedTree);

chart.colors.list = [
  am4core.color("#DEEBEE"),
  am4core.color("#DEEBEE"),
  am4core.color("#DEEBEE"),
  am4core.color("#DEEBEE"),
  am4core.color("#DEEBEE"),
  am4core.color("#F9F871")
];

var networkSeries = chart.series.push(new am4plugins_forceDirected.ForceDirectedSeries())
networkSeries.dataFields.linkWith = "linkWith";
networkSeries.dataFields.name = "name";
networkSeries.dataFields.id = "name";
networkSeries.dataFields.value = "value";
networkSeries.dataFields.children = "children";

networkSeries.nodes.template.label.text = "{name}"
networkSeries.fontSize = 8;
networkSeries.linkWithStrength = 0;

var nodeTemplate = networkSeries.nodes.template;
nodeTemplate.tooltipText = "{name}";
nodeTemplate.fillOpacity = 1;
nodeTemplate.label.hideOversized = true;
nodeTemplate.label.truncate = true;

var linkTemplate = networkSeries.links.template;
linkTemplate.strokeWidth = 1;
var linkHoverState = linkTemplate.states.create("hover");
linkHoverState.properties.strokeOpacity = 1;
linkHoverState.properties.strokeWidth = 2;

nodeTemplate.events.on("over", function (event) {
    var dataItem = event.target.dataItem;
    dataItem.childLinks.each(function (link) {
        link.isHover = true;
    })
})

nodeTemplate.events.on("out", function (event) {
    var dataItem = event.target.dataItem;
    dataItem.childLinks.each(function (link) {
        link.isHover = false;
    })
})

// function createThemeBackHead() {
//   var container = document.getElementById('theme-container');
//   var el = document.createElement("")
//   el.className = "theme-title"
//   container.appendChild(el)
// }
// for (var i = 0; i < array.length; i++) {
//   createThemeBackHead();
// }

var data = @json($place->structure);

var activitiesMerits = JSON.parse("{{ json_encode($place->structure) }}".replace(/&quot;/g,'"'));
var myActivities = activitiesMerits.activities;
var myMerits = activitiesMerits.merits;

console.log(data)
console.log(myActivities[0].text)
console.log(myMerits)

networkSeries.data = [
   {
      "name":myActivities[0].text,
      "value":102,
      "linkWith":[
         myMerits[3].text,
      ],
      "children":[
         {
            "name":myMerits[0].text,
            "value":14
         },
         {
            "name":myMerits[2].text,
            "value":1
         }
      ]
   },
   {
      "name":myActivities[1].text,
      "value":204,
      "linkWith":[
         myMerits[6].text,
      ],
      "children":[
      ]

   },
   {
      "name":myActivities[2].text,
      "value":216,
      "linkWith":[
         myMerits[5].text,
         myMerits[6].text,
      ],
      "children":[
      ]
   },
   {
      "name":myActivities[3].text,
      "value":167,
      "linkWith":[
         myMerits[0].text,
         myMerits[1].text
      ],
      "children":[
         {
            "name":myMerits[1].text,
            "value":2
         },
         {
            "name":myMerits[6].text,
            "value":2
         },
      ]
   },
   {
      "name":myActivities[4].text,
      "value":158,
      "linkWith":[
         "",
      ],
      "children":[
         {
            "name":myMerits[1].text,
            "value":5
         },
         {
            "name":myMerits[4].text,
            "value":1
         },
      ]
   },
   {
      "name":myActivities[5].text,
      "value":88,
      "linkWith":[
         myMerits[6].text,
      ],
      "children":[
      ]
   },
   {
      "name":myActivities[6].text,
      "value":88,
      "linkWith":[
         myMerits[6].text,
      ],
      "children":[
         {
            "name":myMerits[5].text,
            "value":2
         },
      ]
   },

];


});
</script>
