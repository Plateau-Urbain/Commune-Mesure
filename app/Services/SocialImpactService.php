<?php

namespace App\Services;

use App\Models\Place;

class SocialImpactService extends AbstractTypeformService
{
    protected $schema = '/app/places/schema_social_impact.json';
    protected $questionnaire = '/app/places/social_impact_questions.json';
    private static $axes = ['impact_social', 'projet_urbain'];

    public function getCleanedTypeformQuestionForSocialImpact(Place $impactSocial, $searchId = null) {
        return parent::getCleanedTypeformQuestion(
            $impactSocial,
            storage_path() . $this->schema,
            storage_path() . $this->questionnaire,
            self::$axes,
            $searchId
        );
    }
}