<?php

namespace App\Charts;

class PopulationChart implements ChartInterface
{
    protected $type;
    protected $id;
    protected $labels = [];
    protected $datasets = [];

    const sex = [
        'male' => 'Hommes',
        'female' => 'Femmes'
    ];

    const colors = [
        'male' => 'rgba(255, 212, 59, %s)',
        'female' => 'rgba(105, 219, 124, %s)'
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

    public function setLabels(array $labels): void
    {
        foreach ($labels as $label => $value) {
            $tranche = explode('_', $label, 2);
            if (count($tranche) === 2 && in_array($tranche[1], $this->labels) === false) {
                $this->labels[] = $tranche[1];
            }
        }
            $this->labels = str_replace('_', ' - ', $this->labels);
            sort($this->labels);
    }

    public function build($data)
    {
        ksort($data);

        $this->setLabels($data);

        $datasets = [];
        $tmp = [];
        foreach ($data as $label => $value) {
            $tranche = explode('_', $label, 2);
            if (count($tranche) !== 2) {
                continue;
            }

            [$sex, $age] = $tranche;
            $tmp[$sex][$age] = $value;
        }

        foreach ($tmp as $sex => $values) {
            $dataset['label'] = self::sex[$sex];
            $dataset['backgroundColor'] = sprintf(self::colors[$sex], '0.3');
            $dataset['borderColor'] = sprintf(self::colors[$sex], '1');

            $dataset['data'] = array_values($values);

            $datasets[] = $dataset;
        }

        $this->datasets = $datasets;

        return $this;
    }
}
