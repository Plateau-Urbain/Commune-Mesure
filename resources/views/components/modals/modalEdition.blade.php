<span class="icon-edit" style="position: absolute">
    <i class="fa fa-pen modal-crayon" data-modal="{{$chemin}}" title="Éditer la section"></i>
</span>
<div class="modal" id="{{$chemin}}">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Modifier le texte</p>
      <i class="fas fa-times modal-croix" title="Fermer modale" ></i>
    </header>
    <form method="POST" id="" action="">
      <section class="modal-card-body">
        <textarea class="textarea">{{ \app\Models\Place::getValueByChemin($place,$chemin) }}</textarea>
      </section>
      <footer class="modal-card-foot">
        <button class="button" type="submit">Enregistrer</button>
      </footer>
    </form>
  </div>
</div>
