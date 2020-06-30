@extends('layout')

@section('script_js')
    <script>
        document.getElementById('stop1-male').setAttribute('offset', (100-91)+'%')
        document.getElementById('stop2-male').setAttribute('offset', (100-91)+'%')

        document.getElementById('stop1-female').setAttribute('offset', (100-84)+'%')
        document.getElementById('stop2-female').setAttribute('offset', (100-84)+'%')
    </script>
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
@endsection
