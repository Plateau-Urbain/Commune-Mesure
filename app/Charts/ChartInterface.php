<?php

namespace App\Charts;

interface ChartInterface
{
    public function build($data): void;
    public function setLabels(array $labels): void;
    public function getLabels(): array;
    public function getId(): string;
    public function getType(): string;
}
