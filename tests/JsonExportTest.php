<?php

use App\Exports\OriginalJsonExport;
use InvalidArgumentException;
use JsonException;
use Exception;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class JsonExportTest extends TestCase
{
    /**
     * Test pour un non-fichier.
     *
     * @return void
     */
    public function testInvalidFile()
    {
        $this->expectException(InvalidArgumentException::class);
        $export = new OriginalJsonExport('foo');
    }

    /**
     * Test pour un fichier erroné
     *
     * @return void
     */
    public function testInvalidJson()
    {
        $this->expectException(JsonException::class);
        $file = new SplFileObject(
            tempnam(sys_get_temp_dir(), "CMTEST_"),
            'w'
        );
        $file->fwrite("{'foo': bar}");
        $export = new OriginalJsonExport($file->getPathname());

        //clean
        unlink($file->getPathname());
    }

    /**
     * Test pour le répertoire d'export
     *
     * @return void
     */
    public function testExportDir()
    {
        $file = new SplFileObject(storage_path('import').'/Ground_Control.json');
        $export = new OriginalJsonExport($file->getPathname());

        $this->expectException(Exception::class);
        $export->setExportDir('/foo');

        $this->expectException(Exception::class);
        $export->setExportDir('/');

        $export->setExportDir(sys_get_temp_dir());
    }

    /**
     * Test extraction
     *
     * @return void
     */
    public function testExportExtract()
    {
        $file = new SplFileObject(storage_path('import').'/Ground_Control.json');
        $export = new OriginalJsonExport($file->getPathname());

        $this->assertNotCount(0, $export->getDecoded());
    }
}
