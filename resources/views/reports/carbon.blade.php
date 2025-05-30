<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .chart { text-align: center; }
        h1,h2,h3,p {text-align: center;}
        .page-break {
            page-break-after: always;
        }
        h2 {margin-top: 50px}
        h3 { margin-top:50px;}
        p {margin-top: 20px;}
        img {max-width: 600px;}
    </style>
</head>
<body>
    <div style="text-align: right">
      <img src="{{ base_path() . '/public/images/logos/commune-mesure.png' }}" width="150" />
    </div>
    <p>{{$placeName}}<p>
    <h1>Bilan carbone</h1>
    <p>Retrouvez ci-dessous les différents graphiques faisant état des émissions carbone, classés par thématique.</p>

    <div>
      <h2>Répartition des émissions par thématique</h2>
      <div class="chart">
        <img src="{{ $generalChart }}">
      </div>
      <p>Les émissions carbone du tiers lieux ont été de {{$generalEmission}} tCO2e</p>
    </div>

    <div class="page-break"></div>

    <div>
      <h2>Energie</h2>
      <div class="chart">
          <img src="{{ $energyChart }}">
      </div>
    </div>

    <div class="page-break"></div>

    @if ($foodChart !== "" || $beverageChart !== "")
      <div>
        <h2 style="margin-top:0 !important;">Alimentation</h2>
        <p>Le total des émissions carbone lié à l'alimentation est de {{ $foodAndBeverageTotal }} kgCO2e</p>
        <div>
          @if ($foodChart !== '')
            <div>
              <h3 style="margin-top:20px !important;">Nourriture</h3>
              <div class="chart">
                <img src="{{ $foodChart }}">
              </div>
            </div>
          @endif
          @if ($beverageChart !== '')
            <div>
              <h3 style="margin-top:20px !important;">Boisson</h3>
              <div class="chart">
                <img src="{{ $beverageChart }}">
              </div>
            </div>
          @endif
        </div>
      </div>
      <div class="page-break"></div>
    @endif

    @if ($businessCommuteChart !== "")
      <h2>Déplacement des salariés entre leur domicile et leur lieu de travail</h2>
      <div class="chart">
        <img src="{{ $businessCommuteChart }}">
      </div>
    @endif

    <h2>Déplacement professionnel des salariés</h2>
    <div class="chart">
      <img src="{{ $businessTripChart }}">
    </div>

    <div class="page-break"></div>

    <h2>Déplacement des usagers réguliers</h2>
    <div class="chart">
      <img src="{{ $visitorCommuteChart }}">
    </div>

    <h2>Déplacement des visiteurs</h2>
    <div class="chart">
      <img src="{{ $visitorTripChart }}">
    </div>

    <div class="page-break"></div>

    <p>Le total des émissions carbone lié aux achats est de {{ $purchaseTotal }} kgCO2e</p>

    @if ($purchaseMaterialChart !== "")
      <h2>Achat de matériel</h2>
      <div class="chart">
        <img src="{{ $purchaseMaterialChart }}">
      </div>
    @endif

    <h2>Achat globaux</h2>
    <div class="chart">
      <img src="{{ $purchaseChart }}">
    </div>

    <div class="page-break"></div>

    @if($fretChart !== "" || $fretVehiculeChart !== "")
      @if($fretChart !== "")
        <h2>Fret global</h2>
        <div class="chart">
          <img src="{{ $fretChart }}">
        </div>
      @endif

      @if ($fretVehiculeChart !== "")
        <h2>Véhicules de la structure</h2>
        <div class="chart">
          <img src="{{ $fretVehiculeChart }}">
        </div>
      @endif

      <div class="page-break"></div>
    @endif

    @if ($dechetsChart !== "")
      <h2>Déchets</h2>
      <div class="chart">
        <img src="{{ $dechetsChart }}">
      </div>

      <div class="page-break"></div>
    @endif

    <h2>Immobilisations</h2>
    <div class="chart">
      <img src="{{ $immobilisationChart }}">
    </div>

    <h2>Immobilisations numérique</h2>
    <div class="chart">
      <img src="{{ $immobilisationNumeriqueChart }}">
    </div>

    @if ($autresChart !== "")
      <div class="page-break"></div>

      <h2>Autres émissions</h2>
      <div class="chart">
        <img src="{{ $autresChart }}">
      </div>
    @endif
</body>
</html>
