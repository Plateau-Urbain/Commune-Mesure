@extends('layout')

@section('content')
    <div class="colums hero is-large is-light partenaires-block">
        <section class="section">
            <h1 class="title is-1 has-text-centered">Les partenaires</h1>
            <h2 class="subtitle is-2 has-text-centered mt-6">Le comité</h2>
            <img class="logo_partenaires" src="{{ url('/images/partenaires/Logos_partenaires.png') }}" alt="">

            <h2 class="subtitle is-2 has-text-centered mt-6">Les soutiens</h2>
            <div class="columns mt-4 mb-6">
                <div class="column partenaire_container">
                </div>
                <div class="column partenaire_container">
                    <div>
                      <p class="partenaires_text"><p>
                      <img class="logo_partenaires" src="{{ url('/images/partenaires/PUCA.jpg') }}" alt="">
                    </div>
                </div>
                <div class="column partenaire_container">
                    <p class="partenaires_text"><p>
                    <img class="logo_partenaires" src="{{ url('/images/partenaires/ANCT.jpg') }}" alt="">
                </div>
                <div class="column partenaire_container">
                    <p class="partenaires_text"><p>
                    <img class="logo_partenaires" src="{{ url('/images/partenaires/1200px-Ministe_re_de_la_transition_e_cologique_et_solidaire.svg.png') }}" alt="">
                </div>
                <div class="column partenaire_container">
                  <p class="partenaires_text"><p>
                  <img class="logo_partenaires" src="{{ url('/images/partenaires/Fondation_de_France.svg.png') }}" alt="">
                </div>
                <div class="column partenaire_container">
                  <p class="partenaires_text"><p>
                  <img class="logo_partenaires" src="{{ url('/images/partenaires/Copie de LogoPionnierLFI.png') }}" alt="">
                </div>
                <div class="column partenaire_container">
                </div>
              </div>
            <h2 class="subtitle is-2 has-text-centered mt-6">Les soutiens financiers</h2>
            <div class="columns mt-4 mb-6">
                <div class="column partenaire_container">
                </div>
                <div class="column partenaire_container">
                    <img class="logo_partenaires" src="{{ url('/images/partenaires/banque_des_territoires.png') }}" alt="">
                </div>
                <div class="column partenaire_container" >
                      <img class="logo_partenaires" src="{{ url('/images/partenaires/caisse_des_depots.png') }}" alt="" style='width:70%;'>
                </div>
                <div class="column partenaire_container">
                      <img class="logo_partenaires" src="{{ url('/images/partenaires/french_impact.png') }}" alt="" style="padding-top:20%">
                </div>

                <div class="column partenaire_container">
                </div>
              </div>

            </div>
        </section>
    </div>
@endsection
