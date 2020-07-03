@extends('layout')

@section('script_js')
    @parent
    <script>
        document.getElementById('stop1-male').setAttribute('offset', (100-91)+'%')
        document.getElementById('stop2-male').setAttribute('offset', (100-91)+'%')

        document.getElementById('stop1-female').setAttribute('offset', (100-84)+'%')
        document.getElementById('stop2-female').setAttribute('offset', (100-84)+'%')

        var financementctx = document.getElementById('financement-doughnut')
        var financementchart = new Chart(financementctx, {
            type: 'doughnut',
            options: {
                title: {
                    display: true,
                    text: 'Financement du projet',
                    fontFamily: "'Renner Bold', 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                    fontSize: 16,
                    padding: 5
                },
                cutoutPercentage: 90,
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 20
                    }
                }
            },
            data: {
                datasets: [{
                    data:[57, 34, 16, 4],
                    backgroundColor: [
                        '#e85048', '#deebee', '#ee7969', '#262631'
                    ]
                }],
                labels: [
                    'Région',
                    'Ville',
                    'Taxes',
                    'Donations'
                ]
            }
        })

        function surveyPlace(select){

        }

        function flashingBox(id){
          var illustrationContract = document.getElementById(id);
          illustrationContract.style.border = 'solid 1em  #e85048';
          illustrationContract.style.padding = '5px';
          illustrationContract.style.transition = 'border-width 0.6s linear';

          illustrationContract.style.animation = 'blinker 2s cubic-bezier(.5, 0, 1, 1) infinite alternate';
        }

        function flashingOffBox(id){
          var illustrationContract = document.getElementById(id);
          illustrationContract.style.border = null;
          illustrationContract.style.animation = null;
        }

        window.onload = (event) => {
          var contract = document.getElementById("contract");
          contract.addEventListener("mouseover", flashingBox.bind(null, "illustration-contract"));
          contract.addEventListener("mouseout", flashingOffBox.bind(null, "illustration-contract"));

          var owner = document.getElementById("owner");
          owner.addEventListener("mouseover", flashingBox.bind(null, "illustration-contract"));
          owner.addEventListener("mouseout", flashingOffBox.bind(null, "illustration-contract"));

          var budgetYear = document.getElementById("budget-year");
          budgetYear.addEventListener("mouseover", flashingBox.bind(null, "budget-value-illustration-detail"));
          budgetYear.addEventListener("mouseout", flashingOffBox.bind(null, "budget-value-illustration-detail"));

          var budgetTotal = document.getElementById("budget-total");
          budgetTotal.addEventListener("mouseover", flashingBox.bind(null, "budget-value-illustration-detail"));
          budgetTotal.addEventListener("mouseout", flashingOffBox.bind(null, "budget-value-illustration-detail"));

          var budgetFund = document.getElementById("budget-fund");
          budgetFund.addEventListener("mouseover", flashingBox.bind(null, "budget-fund-illustration-detail"));
          budgetFund.addEventListener("mouseout", flashingOffBox.bind(null, "budget-fund-illustration-detail"));
        }
    </script>
@endsection

@section('content')
    <h1 class="section title is-1 has-text-centered">Questionnaire</h1>
    <section class="section">
      <div class="field">
        <div class="control">
          <div class="columns">
            <div class="column is-one-fifth">
              <label for="second-city-select" class="title is-4">Choisissez un lieu:</label>
            </div>
            <div class="column">
              <div class="select is-small is-success">
                <select name="survey-place-select" id="survey-select" class="is-focused" onchange="surveyPlace(this)">
                    @foreach($places as $place)
                      <option value="{{ $place->title }}">{{ $place->name }}</option>
                    @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      @include('components.documentation.survey')
    </section>


    <section class="section">
        <div class="columns is-vcentered">
            <div class="column has-text-centered">
                <h2 class="title is-2 no-border">39%</h2>
                <h4 class="subtitle is-4">de femmes</h4>
            </div>
            <div class="column has-text-centered">
                <div class="columns is-multiline">
                @for ($i = 0; $i < 4; $i++)
                    <div class="column is-one-fifth">
                        @svg('assets/images/female.svg', 'very-small')
                    </div>
                @endfor
                @for ($i = 0; $i < 6; $i++)
                    <div class="column is-one-fifth">
                        @svg('assets/images/male.svg', 'very-small')
                    </div>
                @endfor
                </div>
            </div>
            <div class="column has-text-centered">
                <h2 class="title is-2 no-border">61%</h2>
                <h4 class="subtitle is-4">d'hommes</h4>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="columns is-vcentered">
            <div class="column is-2 has-text-centered is-offset-3">
                <h2 class="title is-2 no-border">84%</h2>
                <h4 class="subtitle is-4">d'emploi</h4>
            </div>
            <div class="column is-2 has-text-centered is-narrow">
                <div class="column">
                    @svg('assets/images/body.svg', 'small')
                </div>
            </div>
            <div class="column is-2 has-text-centered">
                <h2 class="title is-2 no-border">91%</h2>
                <h4 class="subtitle is-4">d'emploi</h4>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="columns is-vcentered has-text-centered">
            <div class="column is-3 is-offset-2">
                @for($i = 100; $i > 0;)
                    @for($j = 1; $j <= 10; $j++ && $i--)
                        <div class="squared
                        @if($i <= 48)
                            filled
                        @endif
                        "></div>
                    @endfor
                    <br>
                @endfor
                <h2 class="title is-2 no-border">48%</h2>
                <h4 class="subtitle is-4">de réinsertion</h4>
            </div>
            <div class="column is-3 is-offset-2">
                <canvas id="financement-doughnut" width="50px" height="50px"></canvas>
            </div>
        </div>
    </section>
@endsection
