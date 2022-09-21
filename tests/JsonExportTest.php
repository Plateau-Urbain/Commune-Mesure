<?php

use App\Exports\OriginalJsonExport;
use Illuminate\Support\Str;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class JsonExportTest extends TestCase
{
    /**
     * Clean des fichiers
     *
     * @doesNotPerformAssertions
     * @return void
     */
    public function testClean()
    {
        array_map('unlink', glob(sys_get_temp_dir()."/CMTEST_*"));
    }

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
    public function testExportDirInvalid()
    {
        $file = new SplFileObject(storage_path('import').'/Ground_Control.json');
        $export = new OriginalJsonExport($file->getPathname());

        $this->expectException(Exception::class);
        $export->setExportDir('/foo');
    }

    /**
     * Test pour le répertoire d'export
     *
     * @return void
     */
    public function testExportDirNotWritable()
    {
        $file = new SplFileObject(storage_path('import').'/Ground_Control.json');
        $export = new OriginalJsonExport($file->getPathname());

        $this->expectException(Exception::class);
        $export->setExportDir('/');
    }

    /**
     * Test pour le répertoire d'export
     *
     * @doesNotPerformAssertions
     * @return void
     */
    public function testExportDirNoException()
    {
        $file = new SplFileObject(storage_path('import').'/Ground_Control.json');
        $export = new OriginalJsonExport($file->getPathname());

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

    /**
     * Test save sans exportDir
     *
     * @return void
     */
    public function testExportSaveNoExportDir()
    {
        $file = new SplFileObject(storage_path('import').'/Ground_Control.json');
        $export = new OriginalJsonExport($file->getPathname());

        $this->expectException(LogicException::class);
        $export->save();
    }

    /**
     * Test save
     *
     * @return void
     */
    public function testExportSaveFilename()
    {
        $file = new SplFileObject(storage_path('import').'/Ground_Control.json');
        $export = new OriginalJsonExport($file->getPathname());
        $export->setExportDir(sys_get_temp_dir());

        $exportedFile = $export->save();

        $expectedFilename = Str::of('Ground_Control')->slug('-').'.csv';
        $this->assertEquals($exportedFile->getFilename(), $expectedFilename);
        $this->assertEquals($exportedFile->getPathname(), sys_get_temp_dir().DIRECTORY_SEPARATOR.$expectedFilename);
        $this->assertFileExists($exportedFile->getPathname());
    }

    /**
     * Test save contenu
     *
     * @return void
     */
    public function testExportSaveContenu()
    {
        $file = new SplFileObject(storage_path('import').'/Ground_Control.json');
        $export = new OriginalJsonExport($file->getPathname());
        $export->setExportDir(sys_get_temp_dir());
        $exportedFile = $export->save();
        $exportedFile->setFlags(SplFileObject::READ_CSV);
        $exportedFile->setCsvControl(";");
        $exportedFile->rewind();

        $firstRow = $exportedFile->current();
        $this->assertIsArray($firstRow);
        $this->assertCount(7, $firstRow);
    }
}
