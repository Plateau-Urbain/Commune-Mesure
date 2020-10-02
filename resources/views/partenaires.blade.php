@extends('layout')

@section('content')
    <div class="colums hero is-large is-light partenaires-block">
        <section class="section">
            <h1 class="title is-1 has-text-centered">Les partenaires</h1>
            <div class="columns">
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
            </div>
            <div class="columns">
            <div class="column partenaire_container">
                <p class="partenaires_text"><p>
                <img class="logo_partenaires" src="{{ url('/images/partenaires/Fondation_de_France.svg.png') }}" alt="">
            </div>
            <div class="column partenaire_container">
                <p class="partenaires_text"><p>
                <img class="logo_partenaires" src="{{ url('/images/partenaires/Copie de LogoPionnierLFI.png') }}" alt="">
            </div>
            <div class="column partenaire_container">
                <p class="partenaires_text"><p>
                <img class="logo_partenaires" src="" alt="">
            </div>
            </div>
        </section>
    </div>
@endsection
