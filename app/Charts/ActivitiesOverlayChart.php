<?php

namespace App\Charts;

class ActivitiesOverlayChart implements ChartInterface
{
    protected $type = '';
    protected $id = '';
    protected $labels = [];
    protected $datasets = [];

    const colors = [
        'rgba(186, 200, 255, %s)',
        'rgba(77, 171, 247, %s)'
    ];

public function __construct(string $id, string $type) {
  $this->id = $id;
  $this->type = $type;
}
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
        [$dataChart1, $dataChart2] = $data;
        $dataChart1 = (array) $dataChart1;
        $dataChart2 = (array) $dataChart2;
        ksort($dataChart1);
        ksort($dataChart2);
        $this->labels = str_replace('_', ' - ', array_keys($dataChart1));
        $dataset['label'] = 'Paris République';
        $dataset['backgroundColor'] = sprintf(self::colors[0], '0.3');
        $dataset['borderColor'] = array_map(function ($string) {
            return sprintf($string, '1');
        }, self::colors);
        $dataset['yAxisID'] = 'lieu-1';
        $dataset['data'] = array_values($dataChart1);
        $this->datasets[] = $dataset;
        $dataset['data'] = array_values($dataChart2);
        $dataset['type']= 'bar';
        $dataset['label']= 'Paris Laffitte';
        $dataset['yAxisID'] = 'lieu-2';
        $dataset['backgroundColor'] = sprintf(self::colors[1], '0.3');
        $this->datasets[] = $dataset;

        return $this;
    }
}
