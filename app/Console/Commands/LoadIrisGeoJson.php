<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LoadIrisGeoJson extends Command
{
  protected $signature = 'iris:load';
  protected $description = "Load iris";
  public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        print_r("Hello");
    }
}
