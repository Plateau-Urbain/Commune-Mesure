<script>
  function comparePlacePoints(selectcmpL, selectcmpR){

    var leftTitle = selectcmpL.options[selectcmpL.selectedIndex].text;
    var rightTitle = selectcmpR.options[selectcmpR.selectedIndex].text;
    if(leftTitle == '--' || rightTitle == "--"){
      console.log(selectcmpL);
      console.log(selectcmpR);
        return;
    }

    if(leftTitle == rightTitle){
      alert("Vous ne pouvez pas comparer un même lieu.");
      return;
    }
    document.getElementById("titleCmpLeft").innerHTML = leftTitle;
    document.getElementById("titleCmpRight").innerHTML = rightTitle;

    loadCompare("#compareLeftTop", 50);
    loadCompare("#compareRightTop", 82);
    loadCompare("#compareLeftBottom", 20);
    loadCompare("#compareRightBottom", 15);
    document.getElementById("cmpBlock").style.display = "block";
  }
</script>
