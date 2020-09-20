function hlOne(row) { row.style.backgroundColor = "#CCC"; }
function hlTwo(row) { row.style.backgroundColor = "#DDD"; }
function hlThree(row) { row.style.backgroundColor = "#EEE"; }
function hlOff(row) { row.style.backgroundColor = "#FFF"; }
// menu overlay functions //
function openNav() {
  document.getElementById("myNav").style.display = "block";
}
function closeNav() {
  document.getElementById("myNav").style.display = "none";
}
// Toggle Div Visibility
const hide = e => e.style.display = 'none'
const show = e => e.style.display = ''
const toggleHide = function(selector) {
  [...document.querySelectorAll(selector)].forEach(e => e.style.display ? show(e) : hide(e))
}
function tabDivs(content, title) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(title).style.display = "block";
  content.currentTarget.className += " active";
}
