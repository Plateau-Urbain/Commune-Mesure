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

function openLegend(){
  var checkBox = document.getElementById("legendCheckbox");
  if (checkBox.checked == true){
    actifChart.updateOptions({ legend: { show: true,}});
    cspChart.updateOptions({ legend: { show: true,}});
    immobilierChart.updateOptions({ legend: { show: true,}});
  } else {
    actifChart.updateOptions({ legend: { show: false,}});
    cspChart.updateOptions({ legend: { show: false,}});
    immobilierChart.updateOptions({ legend: { show: false,}});
  }
}
