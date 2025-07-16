<?php

namespace App\Services;

abstract class AbstractTypeformService
{
    protected function findElementById($array, $id) {
        foreach ($array as $element) {
            if (isset($element['properties']) && is_array($element['properties']) && isset($element['properties']['fields']) && is_array($element['properties']['fields'])) {
                $result = $this->findElementById($element['properties']['fields'], $id);
                if ($result !== null) {
                    return $result;
                }
            }
            if (isset($element['id']) && $element['id'] == $id) {
                return $element;
            }
        }
        return null;
    }

    public function fillQuestionLine($model, $typeform, &$questionsAnswer, $question_type, $axe, $question_key, $schema, $searchId = null) {

        if ($question_type === 0 || $question_type == "") return;

        $parts = explode('|', $question_type);
        list(, $question_id, $question_type) = $parts;
        $typeform_question = $this->findElementById($typeform['fields'], $question_id);
        if ($typeform_question !== null) {
            $questionsAnswer[$axe][$question_key]["title"] = $typeform_question["title"];
            $questionsAnswer[$axe][$question_key]["id"] = $typeform_question["id"];

            $answer = isset($schema["blocs"][$axe]) ? $model->get("blocs->{$axe}->donnees->{$question_key}") :$model->get("{$axe}->{$question_key}");

            $questionsAnswer[$axe][$question_key]["answer"] = $answer;
            $questionsAnswer[$axe][$question_key]["choices"] = null;

            switch ($question_type) {
                case "short_text":
                case "long_text":
                    $questionsAnswer[$axe][$question_key]["type"] = "text";
                    break;
                case "yes_no":
                    $questionsAnswer[$axe][$question_key]["type"] = "toggle";
                    break;
                case "multiple_choice":
                    $type = $typeform_question['properties']['allow_multiple_selection'] === true ? "checkbox" : "select";
                    $questionsAnswer[$axe][$question_key]["type"] = $type;
                    $possibleAnswers = array_fill_keys(array_column($typeform_question["properties"]["choices"], "label"), 0);

                    if ($answer && is_array($answer)) {
                        foreach ($answer as $a) {
                            foreach ($possibleAnswers as $key => $value) {
                                if ($key === $a) {
                                    $possibleAnswers[$key] = 1;
                                }
                            }
                        }
                    }

                    $questionsAnswer[$axe][$question_key]["choices"] = $possibleAnswers;
                    break;
                default:
                $questionsAnswer[$axe][$question_key]["type"] = $question_type;
                    break;
            }

            if ($searchId === $typeform_question["id"]) {
                return $questionsAnswer[$axe][$question_key];
            }
        }
        return null;
    }

    public function getCleanedTypeformQuestion($model, $schema, $questionnaire, $axes, $searchId = null) {
        $typeform = json_decode(file_get_contents($questionnaire), true);
        $schema = json_decode(file_get_contents($schema), true);

        $questionsAnswer = [];
        foreach ($axes as $axe) {
            $axeData = isset($schema["blocs"][$axe]) ? $schema["blocs"][$axe]["donnees"] : $schema[$axe];
            foreach ($axeData as $question_key => $question_type) {
                if (is_array($question_type)) {
                    foreach($question_type as $key => $value) {
                        $q = $this->fillQuestionLine($model, $typeform, $questionsAnswer, $value, $axe, $question_key."->".$key, $schema, $searchId);
                        if ($q !== null) {
                            return $q;
                        }
                    }
                } else {
                   $q = $this->fillQuestionLine($model, $typeform, $questionsAnswer, $question_type, $axe, $question_key, $schema, $searchId);
                   if ($q !== null) {
                        return $q;
                    }
                }
            }
        }
        return $questionsAnswer;
    }

    /**
     * Checks if the provided answer is authorized for the given question.
     * Supports checkbox, toggle, and select types.
     */
    public function authorizedAnswer(array $question, $answer): bool {
        if ($question['type'] === "checkbox") {
            foreach($answer as $a) {
                if (!in_array($a, array_keys($question['choices']))) {
                    return false;
                }
            }
        }

        if($question['type'] === "toogle" && $answer !== "No" && $answer !== "Yes") {
            return false;
        }

        if ($question['type'] === "select") {
            if (!in_array($answer, array_keys($question['choices']))) {
                return false;
            }
        }

        return true;
    }
}
