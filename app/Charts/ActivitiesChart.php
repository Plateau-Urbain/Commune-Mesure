<?php

namespace App\Charts;

class ActivitiesChart implements ChartInterface
{
    protected $type = 'polarArea';
    protected $id = 'chart-activities';
    protected $labels = [];
    protected $datasets = [];

    const colors = [
        'rgba(186, 200, 255, %s)',
        'rgba(77, 171, 247, %s)',
        'rgba(11, 114, 133, %s)',
        'rgba(64, 192, 87, %s)',
        'rgba(252, 196, 25, %s)',
        'rgba(217, 72, 15, %s)'
    ];

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function getDatasets(): array
    {
        return $this->datasets;
    }

    public function build($data)
    {
        $this->labels = str_replace('_', ' - ', array_keys($data));
        $dataset['label'] = 'Activités';
        $dataset['backgroundColor'] = array_map(function ($string) {
            return sprintf($string, '0.3');
        }, self::colors);
        $dataset['borderColor'] = array_map(function ($string) {
            return sprintf($string, '1');
        }, self::colors);
        $dataset['data'] = array_values($data);

        $this->datasets[] = $dataset;

        return $this;
    }
}
