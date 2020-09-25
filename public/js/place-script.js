function slideValeurs(value){
  var val = document.getElementById("slideValeurs");
  var valNew = document.getElementById("slideValeurs2");

  if (value === 1) {
    valNew.style.display = "none";
    val.style.display = "block";
    val.style.opacity = "1";
  }
  if (value === 2) {
    val.style.display = "none";
    valNew.style.display = "block";
    valNew.style.opacity = 1;
  }
}

function slideFinanceCompo(value){
  var old = document.getElementById("slideFinanceCompo");
  var nouveau = document.getElementById("slideFinanceCompo2");

  if (value === 1) {
    nouveau.style.display = "none";
    old.style.display = "block";
    old.style.opacity = "1";
  }
  if (value === 2) {
    old.style.display = "none";
    nouveau.style.display = "block";
    nouveau.style.opacity = "1";
  }

}

function showLegendChart(chart){
  chart.updateOptions({ legend: { show: true,}});
}

function hideLegendChart(chart){
  chart.updateOptions({ legend: { show: false,}});
}

function openLegend(checkBox){
  if (checkBox.checked == true){
    if(actifChart.el === checkBox.previousElementSibling)
      showLegendChart(actifChart)
    if(cspChart.el === checkBox.previousElementSibling)
      showLegendChart(cspChart);
    if(immobilierChart.el === checkBox.previousElementSibling)
      showLegendChart(immobilierChart);
  } else {
    if(actifChart.el === checkBox.previousElementSibling)
      hideLegendChart(actifChart)
    if(cspChart.el === checkBox.previousElementSibling)
      hideLegendChart(cspChart);
    if(immobilierChart.el === checkBox.previousElementSibling)
      hideLegendChart(immobilierChart);

  }
}
