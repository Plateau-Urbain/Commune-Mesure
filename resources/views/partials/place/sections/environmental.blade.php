<section id="environmental" class="is-flex is-flex-direction-column is-justify-content-center content-block">
  <div class="columns">
    <div class="column is-8 is-offset-2">
      <h4 class="title has-text-primary no-border has-text-weight-normal is-uppercase">La partie environnementale</h4>
      <p>

      </p>

      <p class="mt-5">
        <a href="{{ route('environment.show',['slug' => $place->getSlug() ]) }}" class="button mt-2">Voir la partie environnementale</a>
        @isset($edit)
          <a href="{{ route('environment.edit',['slug' => $place->getSlug(), 'auth' => $auth ]) }}" class="button mt-2">Éditer la partie environnementale</a>
        @endisset
      </p>
    </div>
  </div>
</section>
