<div class="content">
<div class="hero is-large is-light">
  <div class="section container is-fullhd">
    <div class="columns">
    <div class="column" id="descriptionStatistic">
              <div class="columns">
                <figure class="image is-128x128"><img src="{{ url('/images/statistics.svg') }}" ></figure>
                <h1 class="title is-1 has-text-centered">Les statistiques</h1>
              </div>
    </div>
    <div class="column  is-three-fifths ">
              <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de Bischheim était au <a href="#">Christkindelsmärik</a> en compagnie de Richard Schirmeck (celui qui a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa Nüdle dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
              <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci vielmols mais che dois partir à la Coopé de Truchtersheim acheter des mänele et des rossbolla pour les gamins. Hopla tchao bissame ! Consectetur adipiscing elit</p>
              <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias</p>
              <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci</p>
    </div>
    </div>
  </div>
  <div class="section has-text-centered font-color-theme">
    <div class="columns">
      <div class="column">
        <div class="field">
        <div class="control">
        <label for="titleCmpLeft" class="title is-4">Indicateur en abscisse  :</label>
        <div class="select is-small is-success" style="margin-left:1em;">
          <select name="1" id="titleCmpLeft" class="is-focused">
            <option selected="selected">--</option>

            @foreach($compares['titles']['moyens'] as $name => $moyen)
            <option value="{{ $name }}">{{ $moyen }}</option>
            @endforeach
            @foreach($compares['titles']['realisations'] as $name => $realisation)
            <option value="{{ $name }}" <?php if ($name==="event"): ?> selected <?php endif; ?>>{{ $realisation }}</option>
            @endforeach
          </select>
        </div>
        </div>
        </div>
      </div>
      <div class="column">
        <div class="field">
        <div class="control">
        <label for="titleCmpRight" class="title is-4">Indicateur en ordonnée:</label>
        <div class="select is-small is-success" style="margin-left:1em;">
          <select name="2" id="titleCmpRight" class="is-focused">
            <option selected="selected">--</option>
            @foreach($compares['titles']['realisations'] as $name => $realisation)
            <option value="{{ $name }}">{{ $realisation }}</option>
            @endforeach
            @foreach($compares['titles']['moyens'] as $name => $moyen)
            <option value="{{ $name }}" <?php if ($name==="etp"): ?>selected<?php endif; ?>>{{ $moyen }}</option>
            @endforeach
          </select>
        </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section" >
    <div class="columns">
      <div class="column is-two-fifths">
        <!-- <div class="" id="chart-moyen-rea"></div> -->
        <div id="stats-chart" width="100" height="10"></div>
      </div>
      <div class="column">
      <div id="lieux_list">
        <table id="table_places">
            <tr>
                <th><input type="checkbox" name="" value="" onclick="selectAll(this)"></th>
                <th scope="col"><p class="lieux_title">Lieu</p></th>
                <th scope="col"><p class="lieux_selectedLeftValue" id="stats_selectedLeftValue">X</p></th>
                <th scope="col"><p class="lieux_selectedRightValue" id="stats_selectedRightValue">Y</p></th>
            </tr>
            <hr>
            @foreach($places as $n => $place)
            <tr class="place-tr">
                <th scope="row"><input type="checkbox" name="" value="" class="checkPlaces"></th>
                <th><p class="place_element" id="list_{{$place->name}}">{{$place->name}}</p></th>
                <td><p class="leftPlaceIndicator"></p></td>
                <td><p class="rightPlaceIndicator"></p></td>
            </tr>
            @endforeach
        </table>
      </div>
      </div>
    </div>
  </div>
</div>
</div>
