@extends('layout')

@section('head_css')
    @parent
@endsection

@section('content')
    <h1 class="section title is-1 has-text-centered">Questionnaire</h1>
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
    @svg('assets/images/body.svg', 'small')
@endsection
