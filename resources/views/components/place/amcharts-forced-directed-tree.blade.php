<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/plugins/forceDirected.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script>
am4core.ready(function() {

am4core.useTheme(am4themes_animated);
var chart = am4core.create("chartdiv", am4plugins_forceDirected.ForceDirectedTree);

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

networkSeries.data = [
   {
      "name":myActivities[0].text,
      "value":102,
      "linkWith":[
         ""
      ],
      "children":[
         {
            "name":myMerits[0].text,
            "value":14
         },
         {
            "name":myMerits[2].text,
            "value":1
         },
         {
            "name":myMerits[3].text,
            "value":1
         },
      ]
   },
   {
      "name":myActivities[1].text,
      "value":204,
      "linkWith":[
         "",
      ],
      "children":[
         {
            "name":myMerits[6].text,
            "value":1
         },
      ]
   },
   {
      "name":myActivities[2].text,
      "value":216,
      "linkWith":[
         "",
      ],
      "children":[
         {
            "name":"Carol",
            "value":10
         },
         {
            "name":"Celia",
            "value":2
         },
         {
            "name":"Julie",
            "value":6
         },
         {
            "name":"Chloe",
            "value":1
         },
         {
            "name":"Bonnie",
            "value":4
         },
         {
            "name":"Messy Girl (Cheryl)",
            "value":5
         },
         {
            "name":"Jill",
            "value":1
         },
         {
            "name":"Elizabeth",
            "value":8
         },
         {
            "name":"Aunt Millie",
            "value":2
         },
         {
            "name":"Mona",
            "value":11
         },
         {
            "name":"Emma",
            "value":7
         },
         {
            "name":"Charlie",
            "value":13
         }
      ]
   },
   {
      "name":myActivities[3].text,
      "value":167,
      "linkWith":[
         "Joey",
         "Phoebe"
      ],
      "children":[
         {
            "name":"Aurora",
            "value":2
         },
         {
            "name":"Jill Goodacre",
            "value":1
         },
         {
            "name":"Janice",
            "value":12
         },
         {
            "name":"Mrs Bing",
            "value":6
         },
         {
            "name":"Nina",
            "value":1
         },
         {
            "name":"Susie",
            "value":5
         },
         {
            "name":"Mary Theresa",
            "value":1
         },
         {
            "name":"Ginger",
            "value":2
         },
         {
            "name":"Joanna",
            "value":5
         },
         {
            "name":"Kathy",
            "value":9
         },
         {
            "name":"Mr Bing",
            "value":1
         }
      ]
   },
   {
      "name":myActivities[4].text,
      "value":158,
      "linkWith":[
         "Chandler",
         "Ross",
         "Joey",
         "Phoebe",
         "Mr Geller",
         "Mrs Geller"
      ],
      "children":[
         {
            "name":"Paolo",
            "value":5
         },
         {
            "name":"Barry",
            "value":1
         },
         {
            "name":"Dr Green",
            "value":3
         },
         {
            "name":"Mark3",
            "value":1
         },
         {
            "name":"Josh",
            "value":2
         },
         {
            "name":"Gunther",
            "value":2
         },
         {
            "name":"Joshua",
            "value":3
         },
         {
            "name":"Danny",
            "value":1
         },
         {
            "name":"Mr. Zelner",
            "value":1
         },
         {
            "name":"Paul Stevens",
            "value":3
         },
         {
            "name":"Tag",
            "value":4
         },
         {
            "name":"Melissa",
            "value":1
         },
         {
            "name":"Gavin",
            "value":2
         }
      ]
   },
   {
      "name":myActivities[5].text,
      "value":88,
      "linkWith":[
         "Phoebe",
         "Janice",
         "Mrs Green",
         "Kathy",
         "Emily",
         "Charlie"
      ],
      "children":[
         {
            "name":"Lorraine",
            "value":2
         },
         {
            "name":"Melanie",
            "value":2
         },
         {
            "name":"Erica",
            "value":2
         },
         {
            "name":"Kate",
            "value":4
         },
         {
            "name":"Lauren",
            "value":2
         },
         {
            "name":"Estelle",
            "value":1
         },
         {
            "name":"Katie",
            "value":2
         },
         {
            "name":"Janine",
            "value":9
         },
         {
            "name":"Erin",
            "value":1
         },
         {
            "name":"Cecilia",
            "value":3
         }
      ]
   },
   {
      "name":myActivities[6].text,
      "value":88,
      "linkWith":[
         "Phoebe",
         "Janice",
         "Mrs Green",
         "Kathy",
         "Emily",
         "Charlie"
      ],
      "children":[
         {
            "name":"Lorraine",
            "value":2
         },
         {
            "name":"Melanie",
            "value":2
         },
         {
            "name":"Erica",
            "value":2
         },
         {
            "name":"Kate",
            "value":4
         },
         {
            "name":"Lauren",
            "value":2
         },
         {
            "name":"Estelle",
            "value":1
         },
         {
            "name":"Katie",
            "value":2
         },
         {
            "name":"Janine",
            "value":9
         },
         {
            "name":"Erin",
            "value":1
         },
         {
            "name":"Cecilia",
            "value":3
         }
      ]
   },

];


});
</script>
