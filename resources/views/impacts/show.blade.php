@extends('layout')
@section('head_css')
    @parent
@endsection
@section('script_js')
    @parent
    @include('partials.impacts.chart-statistics')
    <script>
    window.onload = (event) => {//TODO move in index.js

      var selectcmpleft = document.getElementById("titleCmpLeft");
      var selectcmpright = document.getElementById("titleCmpRight");

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
<div class="column">
  @include('impacts.statistics')
</div>
@endsection
