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
        h2 {margin-top: 100px}
        h3 { margin-top:50px;}
    </style>
</head>
<body>
    <h1>Bilan carbone</h1>
    <p>Retrouvez ci-dessous les différents graphiques faisant état des émissions carbone, classés par thématique.</p>

    <div>
      <h2>Répartition des émissions par thématique</h2>
      <div class="chart">
        <img src="{{ $generalChart }}" alt="Chart" style="max-width:600px;">
      </div>
      <p>Les émissions carbone du tiers lieux ont été de {{$generalEmission}} kgCO2e</p>
    </div>

    <div class="page-break"></div>

    <div>
      <h2>Energie</h2>
      <div class="chart">
          <img src="{{ $energyChart }}" alt="Chart" style="max-width:500px;">
      </div>
    </div>

    <div class="page-break"></div>

    <div>
      <h2>Alimentation</h2>
      <div>
        <div>
          <h3>Nourriture</h3>
          <div class="chart">
            <img src="{{ $foodChart }}" alt="Chart" style="max-width:500px;">
          </div>
        </div>

        <div>
          <h3>Boisson</h3>
          <div class="chart">
            <img src="{{ $beverageChart }}" alt="Chart" style="max-width:500px;">
          </div>
        </div>
      </div>
      <p>Le total des émissions carbone lié à l'alimentation est de {{ $foodAndBeverageTotal }} kgCO2e</p>
    </div>

    <div class="page-break"></div>

    <h2>Déplacement des salariés entre leur domicile et leur lieu de travail</h2>
    <div class="chart">
      <img src="{{ $businessCommuteChart }}" alt="Chart" style="max-width:500px;">
    </div>

    <h2>Déplacement professionnel des salariés</h2>
    <div class="chart">
      <img src="{{ $businessTripChart }}" alt="Chart" style="max-width:500px;">
    </div>

    <div class="page-break"></div>

    <h2>DEPLACEMENT USAGERS REGULIERS</h2>
    <div class="chart">
      <img src="{{ $visitorCommuteChart }}" alt="Chart" style="max-width:500px;">
    </div>

    <h2>DEPLACEMENT VISITEURS</h2>
    <div class="chart">
      <img src="{{ $visitorTripChart }}" alt="Chart" style="max-width:500px;">
    </div>

    <div class="page-break"></div>

    <h2>ACHAT DE MATERIEL</h2>
    <div class="chart">
      <img src="{{ $purchaseMaterialChart }}" alt="Chart" style="max-width:500px;">
    </div>

    <h2>ACHATS GLOBAUX</h2>
    <div class="chart">
      <img src="{{ $purchaseChart }}" alt="Chart" style="max-width:500px;">
    </div>

    <div class="page-break"></div>

    <h2>FRET VEHICULE</h2>
    <div class="chart">
      <img src="{{ $fretVehiculeChart }}" alt="Chart" style="max-width:500px;">
    </div>

    <h2>FRET</h2>
    <div class="chart">
      <img src="{{ $fretChart }}" alt="Chart" style="max-width:500px;">
    </div>

    <div class="page-break"></div>

    <h2>DECHETS</h2>
    <div class="chart">
      <img src="{{ $dechetsChart }}" alt="Chart" style="max-width:500px;">
    </div>

    <h2>IMMOBILISATION NUMERIQUE</h2>
    <div class="chart">
      <img src="{{ $immobilisationNumeriqueChart }}" alt="Chart" style="max-width:500px;">
    </div>
    Total immobilisation : {{ $immobilisationTotal }}

    <h2>AUTRES EMISSIONS</h2>
    <div class="chart">
      <img src="{{ $autresChart }}" alt="Chart" style="max-width:500px;">
    </div>
</body>
</html>
