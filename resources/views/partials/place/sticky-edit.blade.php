<div class="has-background-warning edit-banner">
  <div class="container">
    <p class="has-text-centered has-text-weight-bold py-2">
      Vous êtes en mode édition. Revenir à la <a href="{{ route('place.show', ['slug' => $slug]) }}">page consultation du lieu</a>.
    </p>
  </div>
  <button class="button is-info mx-4" id="modal-help-btn" title="Aide" data-modal="modal-help">
    <i class="fa fa-question"></i>
  </button>
  <button
    <?php if($place->isPublish()):?>
    class="button is-danger is-light" title="Dé-publier le lieu">
    <a class="has-text-black" href="{{ route('place.publish', ['slug' => $slug, 'auth' => $auth]) }}">
      <span class="icon">
        <i class="fa fa-users-slash"></i>
      </span>
    </a>
    <?php else : ?>
        class="button" title="Publier le lieu">
        <a class="has-text-black" href="{{ route('place.publish', ['slug' => $slug, 'auth' => $auth]) }}">
          <span class="icon">
            <i class="fa fa-globe"></i>
          </span>
        </a>
        <?php endif ?>
  </button>
  <a href="{{ route('place.csv', ['slug' => $slug, 'auth' => $auth]) }}">
    <button class="button is-success ml-4" title="Télécharger le csv">
      <span class="icon">
        <i class="fa fa-download"></i>
      </span>
    </button>
  </a>

  <span><a class="has-text-primary mx-4" href="{{ route('place.show', ['slug' => $slug]) }}"><i class='fas fa-times'></i></a></span>
</div>

