<div class="container"  id="descriptionData">
      <div class="section">
        <div class="columns">
            <div class="column">
                <h1 class="title is-1 has-text-centered">Les données</h1>
                <figure class="image is-128x128">
                    <img src="{{ url('/images/datas.svg') }}" >
                </figure>
            </div>

            <div class="content column is-three-fifths">
                <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias du messti de Bischheim était au <a href="#">Christkindelsmärik</a> en compagnie de Richard Schirmeck (celui qui a un blottkopf), le mari de Chulia Roberstau, qui lui trempait sa Nüdle dans sa Schneck ! Yo dû, Pfourtz ! Ch'espère qu'ils avaient du Kabinetpapier, Gal !</p>
                <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci vielmols mais che dois partir à la Coopé de Truchtersheim acheter des mänele et des rossbolla pour les gamins. Hopla tchao bissame ! Consectetur adipiscing elit</p>
                <p>Hopla vous savez que la mamsell Huguette, la miss Miss Dahlias</p>
                <p>Tu restes pour le lotto-owe ce soir, y'a baeckeoffe ? Yeuh non, merci</p>
            </div>
        </div>
      </div>

      <div class="section" id="resilienceData">
        <div class="column">
          <div class="Progress-label is-inline-block" style="background-color:#e34c26;"></div>
          <span>Startup</span>
          <div class="Progress-label is-inline-block" style="background-color:#4F5D95;"></div>
          <span>Associations</span>
          <div class="Progress-label is-inline-block" style="background-color:#563d7c;"></div>
          <span>Artistes</span>
          <div class="Progress-label is-inline-block" style="background-color:#f1e05a;"></div>
          <span>Autres</span>
        </div>
        <div class="field is-horizontal">
          <div class="field-label is-normal">
            <label for="resilience-select" class="label">Choisissez un indicateur:</label>
          </div>
          <div class="field-body">
            <div class="field">
              <div class="control">
                <div class="select is-small is-success">
                  <select name="resilience" id="resilience-select" class="is-focused">
                      @foreach($places[0]->data->resilience->type as $key => $resilience)
                        <option value="{{ $key }}">{{ $resilience->title }}</option>
                      @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="tabs is-right is-small" data-tab-group="indicateurs">
          <ul>
            <li class="is-active">
              <a href="#charts">
                <span class="icon is-small"><i class="fas fa-chart-line" aria-hidden="true"></i></span>
                <span>Graphiques</span>
              </a>
            </li>
            <li>
              <a href="#raw">
                <span class="icon is-small"><i class="fas fa-table" aria-hidden="true"></i></span>
                <span>Données</span>
              </a>
            </li>
          </ul>
        </div>
        <div class="tabs-content" data-tab-group="indicateurs">
            <div class="tab is-active" data-tab="charts">
                <div class="section" id="sectionResilienceBar">
                    {{-- Généré par le JS --}}
                </div>
            </div>
            <div class="tab" data-tab="raw">
                <div class="section">
                    <pre>@json($places[0]->data->resilience, JSON_PRETTY_PRINT)</pre>
                </div>
            </div>
        </div>
      </div>
  </div>
