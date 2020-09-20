@extends('layout')

@section('content')
    <div class="hero hero is-light">
        <section class="section">
            <div class="column">
                <h1 class="title">Envoyez-nous vos interrogations</h1>
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">De</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <p class="control is-expanded has-icons-left">
                                <input class="input" type="text" placeholder="Nom">
                                <span class="icon is-small is-left">
          <i class="fas fa-user"></i>
        </span>
                            </p>
                        </div>
                        <div class="field">
                            <p class="control is-expanded has-icons-left has-icons-right">
                                <input class="input is-success" type="email" placeholder="Email" value="alex@dupont.fr">
                                <span class="icon is-small is-left">
          <i class="fas fa-envelope"></i>
        </span>
                                <span class="icon is-small is-right">
          <i class="fas fa-check"></i>
        </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label"></div>
                    <div class="field-body">
                        <div class="field is-expanded">
                            <div class="field has-addons">
                                <p class="control">
                                    <a class="button is-static">
                                        +33
                                    </a>
                                </p>
                                <p class="control is-expanded">
                                    <input class="input" type="tel" placeholder="Numéro de téléphone">
                                </p>
                            </div>
                            <p class="help">Veuillez ne pas saisir le premier zéro</p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Département</label>
                    </div>
                    <div class="field-body">
                        <div class="field is-narrow">
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select>
                                        <option>Business development</option>
                                        <option>Marketing</option>
                                        <option>Sales</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label">
                        <label class="label">Déjà membre?</label>
                    </div>
                    <div class="field-body">
                        <div class="field is-narrow">
                            <div class="control">
                                <label class="radio">
                                    <input type="radio" name="member">
                                    Oui
                                </label>
                                <label class="radio">
                                    <input type="radio" name="member">
                                    Non
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Sujet</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input class="input is-danger" type="text" placeholder="Exemple : Partenariat">
                            </div>
                            <p class="help is-danger">
                                Champs obligatoire
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Question</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <textarea class="textarea" placeholder="Comment pouvons-nous vous aider ?"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label">
                        <!-- Left empty for spacing -->
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <button class="button is-primary">
                                    Envoyer ce message
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
