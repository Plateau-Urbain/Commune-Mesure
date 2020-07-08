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
      createResilienceBar(select);

      select.onchange = (event) => {
        createResilienceBar(select)
      }
      yAxe = xAxe = "total";
      dataPopFirst.data = getDataPopPlace("La-Ferme-du-Bonheur-Nanterre", dataPopFirst.position);
      dataPopSecond.data = getDataPopPlace("Coco-Velten-Marseille", dataPopSecond.position);

      populationAxesChart(null, null);
      comparePopulationPlaces();
    }
    </script>
@endsection
@section('content')
<div class="columns is-gapless">
    <div class="column is-2">
    <div class="section scrolling-menu">
      <aside class="menu">
        <p class="menu-label">
          statistiques
        </p>
        <ul class="menu-list">
          <li>
            <ul>
              <li><a href="#descriptionStatistic">Description</a></li>
              <li><a href="#compareStatistic">Comparer deux lieux</a></li>
              <li><a href="#graphStatistic">Graphique de la population</a></li>
            </ul>
          </li>
        </ul>
        <p class="menu-label">
          Données
        </p>
        <ul class="menu-list">
          <li>
            <ul>
              <li><a href="#descriptionData">Description</a></li>
              <li><a href="#resilienceData">Les données sur la résiliences</a></li>
            </ul>
          </li>
        </ul>
      </aside>
    </div>
  </div>
  <div class="column">
    @include('impacts.statistics')
    @include('impacts.datas')
  </div>
@endsection
