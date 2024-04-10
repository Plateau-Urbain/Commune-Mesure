<?php

namespace App\Console\Commands;

trait ExtractTypeformValue {
    public function extract_val(string $keys, $answers, $logger) {
        $logger->info('Extracting values', ['keys' => $keys]);

        $key = explode('|', $keys);
        $file = $answers;
        foreach ($file as $question) {
            // Question at root level
            if (count($key) === 3) {
                $questionID = 0;
                $questionType = 1;
                $valueType = 2;
            } else {
                $questionID = 1;
                $questionType = 2;
                $valueType = 3;
            }

            if ($question->field->id !== $key[$questionID]) {
                continue;
            }

            if ($key[$valueType] === "choices") {
                $logger->info('Answers type : choices', ['key' => $key[$questionID]]);
                if (isset($question->choices) && isset($question->choices->labels)) {
                    foreach($question->choices->labels as $label) {
                        $logger->info('Answer : '.$label);
                    }

                    return $question->choices->labels;
                } elseif(isset($question->choice->label)) {
                    $logger->info('Answer : '.$question->choice->label);
                    return [$question->choice->label];
                } else {
                    $logger->info('Answer : '.$question->choices->other);
                    return [$question->choices->other];
                }
            }

            if ($key[$questionType] == 'short_text' || $key[$questionType] == 'long_text') {
                $key[$questionType] = 'text';
            }

            if ($key[$questionType] === "number" and $question->{$key[$questionType]} === "") {
                return 0;
            }

            if ($key[$questionType] == 'yes_no') {
                $key[$questionType] = 'boolean';
            }

            if ($key[$questionType] == 'rating') {
                $key[$questionType] = 'number';
            }

            if ($key[$questionType] == 'website') {
                $key[$questionType] = 'url';
            }

            if ($key[$questionType] == 'file_upload') {
                $key[$questionType] = 'file_url';
            }

            $logger->info('Answers type : '.$key[$questionType], ['key' => $key[$questionID]]);
            $logger->info('Answer : '.$question->{$key[$questionType]});

            return $question->{$key[$questionType]};
        }
    }
}
