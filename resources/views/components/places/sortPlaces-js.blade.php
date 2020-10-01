<script>
  function sortPlaces(selectNode){
    var options = document.querySelectorAll("option.sort");
    var index = selectNode.selectedIndex;
    window.location.replace("{{ url('les-lieux/') }}/"+options[index].value);
  }
</script>
