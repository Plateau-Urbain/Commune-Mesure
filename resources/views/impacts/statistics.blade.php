<div class="content">
<div class="hero is-large is-light">
  <div class="section container is-fullhd">
      <h1 class="title is-1 has-text-centered">Les statistiques</h1>
  </div>
  <div class="section has-text-centered font-color-theme pt-0">
    <div class="columns is-mobile">
      <div class="column">
        <div class="field">
          <div class="control">
            <div class="select is-normal is-success">
              <select style="display: inline-block;" name="1" id="titleCmpLeft" class="is-focused" >
                @foreach ($places[0]->data->compare as $key_name => $programmations )
                <optgroup label="{{ $key_name }}">
                  @foreach ($programmations as $key_prog_name => $programmation )
                  <option @if($key_prog_name == "etp") id="stats_selectedLeftValue"
                                                        selected
                                                      @endif
                                            value="{{ $key_prog_name }}" >{{ $programmation->title }}</option>
                  @endforeach
                </optgroup>
                @endforeach
              </select>
            </div>
              <strong class="is-size-4" style="margin-left: 10px;">en fonction de</strong>
            <div class="select is-success" style="margin-left:1em;">
              <select style="display: inline-block;" name="2" id="titleCmpRight" class="is-focused">
                @foreach ($places[0]->data->compare as $key_name => $programmations )
                <optgroup label="{{ $key_name }}">
                  @foreach ($programmations as $key_prog_name => $programmation )
                  <option value="{{ $key_prog_name }}" @if($key_prog_name == "event") id="stats_selectedRightValue"
                      selected
                  @endif >{{ $programmation->title }}</option>
                  @endforeach
                </optgroup>
                @endforeach
              </select>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section pt-0" >
    <div class="container">
      <div class="card is-rounded">
        <div id="stats-chart"></div>
      </div>
    </div>
  </div>
</div>
<template id="detail-chart">
  <div class="" id="detail_list">
    <p id="leftPlaceIndicator"></p>
    <p id="rightPlaceIndicator"></p>
  </div>
</template>
</div>
