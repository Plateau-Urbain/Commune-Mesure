<?php

namespace App\Services;

use App\Models\Place;

class PlaceService extends AbstractTypeformService
{
    protected $schema = '/app/places/schema_general_information.json';
    protected $questions =  '/app/places/general_questions.json';
    private static $axes = [
        'presentation', 'accessibilite', 'valeurs', 'moyens', 'composition', 'evenements', 'activites'
    ];

    public function getCleanedTypeformQuestionForPlace(Place $place, $searchId = null) {
        return parent::getCleanedTypeformQuestion(
            $place,
            storage_path() . $this->schema,
            storage_path() . $this->questions,
            self::$axes,
            $searchId
        );
    }
}
