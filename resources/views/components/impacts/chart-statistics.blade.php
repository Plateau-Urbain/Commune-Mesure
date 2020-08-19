<script>

  var colors = ["rgb(61, 30, 109, 0.3)","rgb(243, 119, 53, 0.3)",
  "rgb(193, 4, 236, 0.3)","rgb(105, 210, 30, 0.3)", "rgb(76, 138, 136, 0.3)",
  "rgb(238, 64, 53, 0.3)","rgb(243, 119, 54, 0.3)", "rgb(253, 244, 152, 0.3)",
  "rgb(123, 192, 67, 0.3)","rgb(3, 146, 207, 0.3)",
  "rgb(209, 17, 65, 0.3)","rgb(126, 141, 152, 0.3)","rgb(41, 168, 171, 0.3)",
  "rgb(198, 134, 66, 0.3)","rgb(210, 231, 255, 0.3)","rgb(255, 87, 51, 0.3)",
  "rgb(128, 229, 226, 0.3)","rgb(147, 128, 229, 0.3)","rgb(70, 41, 199, 0.3)", ];

  function getRandomColor(){
    return colors[getRandomInt(colors.length,0)];
  }
  function getRandomInt(max, min) {
    return min+Math.floor(Math.random() * Math.floor(max));
  }

  function comparePlacePoints(selectcmp){
    loadCompare("#compareLeftTop", 20);
    loadCompare("#compareRightTop", 50);
    loadCompare("#compareLeftBottom", 15);
    loadCompare("#compareRightBottom", 82);
  }
</script>
