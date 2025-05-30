<?php

namespace App\Services;

use Psr\Log\LoggerInterface;

class CarbonFormDataExtractor
{
    use \App\Console\Commands\ExtractTypeformValue;

    private $answers;
    private $logger;

    public function __construct($answers, LoggerInterface $logger)
    {
        $this->answers = $answers;
        $this->logger = $logger;
    }

    /**
     * Recursively process the schema and extract values
     */
    public function processSchema(object $schema): array
    {
        $result = [];

        foreach ($schema as $key => $value) {
            if (is_object($value)) {
                // If it's an object (nested structure), recurse
                $result[$key] = $this->processSchema($value);
            } else {
                // If it's a value that needs extraction
                $result[$key] = $this->extract_val($value, $this->answers, $this->logger);
            }
        }

        return $result;
    }

    /**
     * Convert the extracted data to an object structure
     */
    public function toObject(array $data)
    {
        return json_decode(json_encode($data));
    }
}
