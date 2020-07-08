<br/>
<br/>

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
