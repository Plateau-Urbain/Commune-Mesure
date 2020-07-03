<div class="columns is-flex is-vcentered is-centered">
  <div class="column">
    <div class="location-home">
      @svg('../public/images/location_home.svg')
     <div class="" id="owner">Propriétaire</div>
     <div class="" id="contract">Contrat</div>
    </div>
  </div>
  <!-- Loop on places //TODO use place selected from survey select-->
  @php ($place = $places[12])
  <div class="column">
    <div class="" id="illustration-contract">

      @foreach($sentences->groups as $key => $group)
      @php ($string = "")
      @php ($nb = 2)
        <h2 class="title">{{ $group->title }}</h2>
        <div class="">
        @foreach($group as $keygroup => $question)
          @if($keygroup !== "title")
          @php ($answer = $place->data->survey->groups->{"$key"}->{"$keygroup"}->answer)
            <figure class=" is-inline-block image is-128x128" title="{{ $question->question }}">
                <img  src="{{ url('/images/'.$question->answer->{$answer}->illustration) }}" >
            </figure>
            @php ($string =$string.' '.$question->answer->{$answer}->string)
            @if($nb != count((array)$group))
              <figure class=" is-inline-block image is5em">
                  <img  src="{{ url('/images/arrow.svg') }}" >
              </figure>
              @php ($nb = $nb + 1)
            @endif
          @endif
        @endforeach
        </div>
        <p class="subtitle">{{ sprintf($string, $place->name) }}</p>
      @endforeach
    </div>
  </div>
</div>

<div class="columns is-flex is-vcentered is-centered">
  <div class="column">
    <div id="budget-value-illustration">
      <figure class="image">
        <img  src="{{ url('/images/budget_value.svg') }}" >
      </figure>
      <div class="" id="budget-value-illustration-detail">
        <div>
          <p class="title">Un budget annuel de: {{ "120K €" }}</p>
          <p class="title">Un budget total de: {{ "150K €" }}</p>
        </div>
      </div>
    </div>
  </div>
  <div class="column is-one-fifth has-text-centered">
    <h2 class="title">{{ "Modèle économique" }}</h2>
    <div class="budget">
      <figure class="image is20em">
        <img  src="{{ url('/images/budget.svg') }}" >
      </figure>
      <div class="" id="budget-year">Budget annuel</div>
      <div class="" id="budget-fund">Origines des fonds</div>
      <div class="" id="budget-total">Budget total</div>
    </div>
  </div>
  <div class="column">
    <div id="budget-fund-illustration">
      <figure class="image">
        <img  src="{{ url('/images/budget_value.svg') }}" >
      </figure>
      <div class="" id="budget-fund-illustration-detail">
        <ul class="menu-list">
          <li class="title">Fonds public</li>
          <li class="title">Fonds privé</li>
        <ul>
      </div>
    </div>
  </div>
</div>


<script>
  function flashingBox(id){
    let illustrationContract = document.getElementById(id);
    illustrationContract.style.border = 'solid 1em  #e85048';
    illustrationContract.style.transition = 'border-width 0.6s linear';

    illustrationContract.style.animation = 'blinker 2s cubic-bezier(.5, 0, 1, 1) infinite alternate';
  }
  function flashingOffBox(id){
    let illustrationContract = document.getElementById(id);
    illustrationContract.style.border = null;
    illustrationContract.style.animation = null;
  }

  window.onload = (event) => {
    let contract = document.getElementById("contract");
    contract.addEventListener("mouseover", flashingBox.bind(null, "illustration-contract"));
    contract.addEventListener("mouseout", flashingOffBox.bind(null, "illustration-contract"));

    let budgetYear = document.getElementById("budget-year");
    budgetYear.addEventListener("mouseover", flashingBox.bind(null, "budget-value-illustration-detail"));
    budgetYear.addEventListener("mouseout", flashingOffBox.bind(null, "budget-value-illustration-detail"));

    let budgetTotal = document.getElementById("budget-total");
    budgetTotal.addEventListener("mouseover", flashingBox.bind(null, "budget-value-illustration-detail"));
    budgetTotal.addEventListener("mouseout", flashingOffBox.bind(null, "budget-value-illustration-detail"));

    let budgetFund = document.getElementById("budget-fund");
    budgetFund.addEventListener("mouseover", flashingBox.bind(null, "budget-fund-illustration-detail"));
    budgetFund.addEventListener("mouseout", flashingOffBox.bind(null, "budget-fund-illustration-detail"));



  }
</script>
