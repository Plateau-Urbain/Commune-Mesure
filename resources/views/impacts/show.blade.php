@extends('layout')
@section('head_css')
    @parent
@endsection
@section('script_js')
    @parent
    <script src="https://unpkg.com/rough-viz@1.0.5"></script>
    @include('components.impacts.chart-statistics')
    @include('components.impacts.chart-datas')
    <script>
    window.onload = (event) => {//TODO move in index.js
      var select = document.getElementById("resilience-select")
      createResilienceBar(select)

      select.onchange = (event) => {
        createResilienceBar(select)
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
