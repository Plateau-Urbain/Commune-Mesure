@extends('layout')
@section('head_css')
    @parent
@endsection
@section('script_js')
    @parent
    <script src="https://unpkg.com/rough-viz@1.0.5"></script>
    @include('components.impacts.chart-datas')
@endsection
@section('content')
  <div class="container">
      <div class="hero is-large is-light">
          <div class="section">
            <div class="columns">
                <div class="column content">
                  <h1 class="title is-1 has-text-centered">Les données</h1>
                </div>
                <div class="column is-half has-text-centered">
                  <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de Bischheim était au <a href="#">Christkindelsmärik</a> en compagnie de Richard Schirmeck (celui qui a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa Nüdle dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
                  <blockquote><p>Wotch a kofee avec ton bibalaekaess et ta wurscht ? Yeuh non che suis au réchime, je ne mange plus que des Grumbeere light et che fais de la chym avec Chulien. Tiens, un rottznoz sur le comptoir.</p></blockquote>
                  <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci vielmols mais che dois partir à la Coopé de Truchtersheim acheter des mänele et des rossbolla pour les gamins. Hopla tchao bissame ! Consectetur adipiscing elit</p>
                  <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias</p>
                  <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci</p>
                </div>
            </div>

            <div class="field">
              <div class="control">
                <label for="resilience-select" class="title">Choisissez un indicateur:</label>
                <div class="select is-small is-success" style="margin-top:1em;">
                  <select name="resilience" id="resilience-select" class="is-focused" onchange="createResilienceBar(this)">
                      @foreach($places[0]->data->resilience as $type_resilience => $resilience)
                        <option value="{{ $type_resilience }}">{{ $resilience->title }}</option>
                      @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="section" id="sectionResilienceBar">
          </div>
      </div>
  </div>
@endsection
