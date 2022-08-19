<?php

namespace App\Exports;

use InvalidArgumentException;
use JsonException;

class OriginalJsonExport
{
    private $file;
    private $decoded;

    public function __construct(string $filename)
    {
        if (is_file($filename) === false) {
            throw new InvalidArgumentException(__CLASS__.' require a valid filename. ['.$filename.'] provided');
        }

        $decoded = json_decode(file_get_contents($filename));

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonException($filename.' must be a valid json');
        }

        $this->_extract($decoded);
    }

    private function _extract($decoded)
    {
        foreach ($decoded->answers as $categories) {
            echo $categories->title.PHP_EOL;
        }
    }
}
