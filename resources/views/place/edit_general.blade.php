@php
$axesLabels = [
    'presentation' => 'Présentation',
    'accessibilite' => 'Accessibilité',
    'valeurs' => 'Valeurs',
    'moyens' => 'Moyens',
    'composition' => 'Composition',
    'galerie' => 'Galerie',
    'reseaux_sociaux' => 'Réseaux sociaux',
    'evenements' => 'Événements',
    'activites' => 'Activités',
];
@endphp

@foreach ($questionAnswer as $axe => $questionsAnswers)
    <button class="accordion">{{ $axesLabels[$axe] ?? $axe }}</button>
    <div class="panel-accordion">
        <div class="line header">
            <div class="question">Question</div>
            <div class="answer-container"><div class="answer">Votre réponse</div></div>
        </div>
        @foreach ($questionsAnswers as $question => $questionData)
            <div class="line">
              @if(isset($questionData['title']))
              <div class="question">{{ $questionData['title'] }}</div>
              <div class="answer-container">
                  <div class="answer">
                      @if(is_array($questionData['answer']))
                          {{ implode(', ', $questionData['answer']) }}
                      @else
                          {{formatAnswer($questionData["answer"], $questionData["type"])}}
                      @endif
                      @include('components.modals.modalTypeformGeneric', [
                          'chemin' => "blocs->".$axe."->donnees->".$question,
                          'id_section' => $axe,
                          'id' => $questionData['id'],
                          'type' => $questionData["type"],
                          'titre' => "Modifier votre réponse",
                          'description' => $questionData["title"],
                          'answer' => $questionData["answer"],
                          'choices' => $questionData["choices"],
                          'route' => route('place.update_general', ['slug' => $slug, 'auth' => $auth, 'hash' => "blocs->".$axe."->donnees->".$question, 'id_section' => $axe])
                      ])
                  </div>
              </div>
              @endisset

            </div>
        @endforeach
    </div>
@endforeach
