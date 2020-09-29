@extends('layout')
@section('head_css')
    @parent
@endsection
@section('script_js')
    @parent
    <script src="https://unpkg.com/rough-viz@1.0.5"></script>
    <script src="https://d3js.org/d3.v4.min.js"></script>
    <script src="https://x3dom.org/release/x3dom.js"></script>
    <script src='https://cdn.plot.ly/plotly-latest.min.js'>
    <script src="https://bl.ocks.org/Niekes/raw/d8007a5f71f45ab80a2977a8eb7ab3c9/d3-3d.js"></script>
    @include('components.impacts.d3-cloud-point-js')
    @include('components.impacts.chart-statistics') 
    <script>
    window.onload = (event) => {//TODO move in index.js

      var selectcmpleft = document.getElementById("first-city-select");
      var selectcmpright = document.getElementById("second-city-select");
      comparePlacePoints(selectcmpleft, selectcmpright);
      comparePlacePoints(selectcmpleft, selectcmpright);
      selectcmpleft.onchange = (event) => {
        comparePlacePoints(selectcmpleft, selectcmpright);
      }
      selectcmpright.onchange = (event) => {
        comparePlacePoints(selectcmpleft, selectcmpright);
      }

    }
    </script>
@endsection
@section('content')
@include('components.impacts.impact-menu')
<div class="column">
  @include('impacts.statistics')
  @include('impacts.datas')
</div>
@endsection
