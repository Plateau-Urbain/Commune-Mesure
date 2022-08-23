<?php

use App\Exports\BDDJsonExport;
use App\Models\Place;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BDDExportTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInvalidFile()
    {
        $this->expectException(InvalidArgumentException::class);
        $export = new BDDJsonExport('ground-control', 'foo');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPlaceDoesNotExist()
    {
        Place::factory()->hasName('place-1')->create();
        $this->expectException(InvalidArgumentException::class);
        $export = new BDDJsonExport('place-2');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExportExtract()
    {
        Place::factory()->hasName('place-1')->create();
        $export = new BDDJsonExport('place-1');

        $this->assertNotCount(0, $export->getDecoded());
    }

    public function testExportSave()
    {
        Place::factory()->hasName('place-1')->create();
        $export = new BDDJsonExport('place-1');
        $export->setExportDir(sys_get_temp_dir());

        $exportedFile = $export->save();
        $exportedFile->setFlags(SplFileObject::READ_CSV);
        $exportedFile->setCsvControl(';');
        $exportedFile->rewind();

        $firstRow = $exportedFile->current();
        $this->assertIsArray($firstRow);
        $this->assertCount(4, $firstRow);
    }
}
