<?php

namespace App\Exports;

use App\Models\Place;
use InvalidArgumentException;
use JsonException;
use SplFileInfo;
use SplFileObject;
use Exception;
use LogicException;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class BDDJsonExport
{
    private $place;
    private $schema;
    private $schemaFile = __DIR__.'/../../storage/app/places/schema.json';

    private $decoded = [];

    private $_headers = ['CategorieId', 'QuestionId', 'Type', 'Reponse'];
    private $newFilename;
    private $exportDir;

    public function __construct(string $slug, string $schema = '')
    {
        if ($schema) {
            $this->schemaFile = $schema;
        }

        $this->schema = new SplFileInfo($this->schemaFile);
        if ($this->schema->isFile() === false) {
            throw new InvalidArgumentException(__CLASS__.' require a valid file, ['.$this->schemaFile.'] provided.');
        }

        $this->schema = $this->schema->openFile('r');
        $this->schema = json_decode($this->schema->fread($this->schema->getSize()), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonException($this->schemaFile.' must be a valid json.');
        }

        $this->place = Place::find($slug, false);

        if ($this->place === false) {
            throw new InvalidArgumentException($slug.' does not exist');
        }

        $this->_extract();
    }

    public function setExportDir($path)
    {
        $dir = new SplFileInfo($path);
        if ($dir->isDir() === false) {
            throw new Exception($path.' is not a valid directory');
        }

        if ($dir->isWritable() === false) {
            throw new Exception($path.' is not a writable directory');
        }

        $this->exportDir = $dir;
    }

    /**
     * @return SplFileObject
     */
    public function save()
    {
        if (($this->exportDir instanceof SplFileInfo) === false) {
            throw new LogicException("You must specify the exportDir first");
        }

        $this->_setNewFilename();

        $file = new SplFileObject($this->exportDir.DIRECTORY_SEPARATOR.$this->newFilename, 'w+');

        $file->fputcsv($this->_headers, ';');

        foreach ($this->decoded as $key => $line) {
            if (strpos($line, '|') === false) {
                continue;
            }

            $split = explode('|', $line); // 0: cat, 1: question, 2: type, 3: champs
            $reponse = $this->place->get($key);

            if (is_array($reponse)) {
                $reponse = implode(',', $reponse);
            }

            $file->fputcsv([
                $split[0],
                $split[1],
                $split[2],
                trim(str_replace("\n", ' ', $reponse))
            ], ';');
        }

        return $file;
    }

    public function getDecoded()
    {
        return $this->decoded;
    }

    private function _setNewFilename()
    {
        $this->newFilename = $this->place->getSlug().'.genere.csv';
    }

    private function _extract()
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($this->schema));

        // on itère sur chaque élément du tableau (récursivement)
        foreach ($iterator as $leaf) {
            $path = [];

            // pour chaque élément, on récupère la profondeur depuis la profondeur 0
            foreach (range(0, $iterator->getDepth()) as $depth) {
                $path[] = $iterator->getSubIterator($depth)->key();
            }

            // on enregistre la clé construite, avec la valeur courante de l'élément
            $this->decoded[join('->', $path)] = $iterator->current();
        }
    }
}
