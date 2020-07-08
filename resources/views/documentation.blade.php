@extends('layout')

@section('script_js')
    @parent

@endsection

@section('content')
    <section class="section">
      <h1 class="section title is-1 has-text-centered">Questionnaire</h1>
    <div class="columns">
      <div class="column">
        <figure class=" is-inline-block image">
            <img  src="/images/survey_illustration.svg" >
        </figure>
      </div>
      <div class="column">
        <div class="">
          <h1 class="title">Pourquoi un questionnaire ?</h1>
          <p class="content">
            Le seul moyen de le stopper serait d’arrêter tous les ordinateurs,
            ce qui aurait les mêmes conséquences que de laisser Prélude lancer les bombes.
             Depuis longtemps, toutes les installations à risque étaient contrôlées par des ordinateurs.
              Si l’on stoppait les ordinateurs, les centrales nucléaires s’emballeraient,
               les silos nucléaires cracheraient leur mort sur toute la planète. Bien entendu,
               l’économie mondiale dirigée par la bourse, s’effondrerait. David ne savait plus quoi faire et,
                manifestement, tous les militaires présents dans la salle comptaient sur lui pour
                résoudre cette crise.
            </p>
          </div>
          <br/><br/><br/>
          <h1 class="title">Echelle nationale</h1>
          <div class="columns">
            <div class="column">
              <p class=" is-inline-block">
                Internet n’est pas le seul réseau. Il existe un autre réseau plus performant.
                 Je ne t’apprendrais rien en te disant qu’Internet a été crée par l’armée Américaine
                  dans un but militaire. Internet n’était que le prototype. Un autre réseau a été
                  créé pour les militaires. Complètement indépendant d’Internet. Tirant des leçons
                   du premier réseau, le petit frère d’Internet est devenue un grand frère.
                </p>
              </div>
              <div class="column">
                <figure class="is-inline-block image is20em">
                    <img  src="/images/survey_place_illustration.svg" >
                </figure>
              </div>
            </div>
        </div>
      </div>
    </section>
@endsection
