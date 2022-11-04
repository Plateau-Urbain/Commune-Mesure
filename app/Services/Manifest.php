<?php

namespace App\Services;

use SplFileObject;
use SplFileInfo;
use RuntimeException;

class Manifest
{
    protected $sha;

    public function __construct(string $branch)
    {
        if ((new SplFileInfo(base_path().'/.git/refs/heads/'))->isDir()) {
            try {
                $file = new SplFileObject(base_path().'/.git/refs/heads/'.$branch);
            } catch (RuntimeException $e) {
                $head = substr(strrchr(file_get_contents(base_path().'/.git/HEAD'), " :"), 1);
                $file = new SplFileObject(base_path().'/.git/'.$head);
            } finally {
                $sha = $file->fread($file->getSize());
            }
        } else {
            $sha = sha1_file(base_path().'/public/css/app.css');
        }

        $this->sha = $sha;
    }

    public function getSha()
    {
        return '?'.$this->sha;
    }
}
