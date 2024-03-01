@php
$axesLabels = [
    "circularite_sobriete" => "Circularité et sobriété",
    "emission_gaz_effet_serre" => "Emission de GES",
    "biodiversite" => "Biodiversité",
    "environnement_physique" => "Environnement physique",
    "sensibilisation_engagement" => "Sensibilisation et engagement"
];
@endphp

@foreach ($questionAnswer as $axe => $questionsAnswers)
    <button class="accordion">{{$axesLabels[$axe]}}</button>
    <div class="panel-accordion">
        <div class="line header">
            <div class="question">Question</div>
            <div class="answer-container"><div class="answer">Votre réponse</div></div>
        </div>
        @foreach ($questionsAnswers as $question => $questionData)
            <div class="line">
                <div class="question">{{$questionData['title']}}</div>
                <div class="answer-container">
                    <div class="answer">
                        @if(is_array($questionData['answer']))
                            {{ implode(', ', $questionData['answer']) }}
                        @else
                            {{ $questionData['answer'] }}
                        @endif
                        @include('components.modals.modalEnvironmental', [
                            'chemin' => "blocs->".$axe."->donnees->".$question,
                            'id_section' => $axe,
                            'id' => $questionData['id'],
                            'type' => $questionData["type"],
                            'titre' => "Modifier votre réponse",
                            'description' => $questionData["title"],
                            'answer' => $questionData["answer"],
                            'choices' => $questionData["choices"]
                        ])
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endforeach
