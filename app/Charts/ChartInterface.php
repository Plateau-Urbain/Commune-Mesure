<?php

namespace App\Charts;

interface ChartInterface
{
    public function build($data);
    public function getDatasets(): array;
    public function getLabels(): array;
    public function getId(): string;
    public function getType(): string;
}
