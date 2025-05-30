<?php

namespace App\Services;

use Ianw\QuickChart\QuickChart;

class ChartGenerator
{
    public function generateChart($data)
    {
        $qc = new \QuickChart([
            'width' => 600,
            'height' => 350,
            'version' => '2.9.4',
        ]);

        $qc->setConfig($data);

        return $qc->getShortUrl();
    }

    public function generateChartData(object $providedData, array $labels, array $keysToIgnore = [], int $totalToCalculatePercentage = 0)
    {
        $rawData = [];
        $percentageData = [];
        $adjustedLabels = [];
        $total = $providedData->total ?? 0;

        // If total is missing or zero, calculate total
        if ($total == 0) {
            $total = array_sum(array_filter(get_object_vars($providedData), function ($key) use ($keysToIgnore) {
                return $key !== 'total' && !in_array($key, $keysToIgnore);
            }, ARRAY_FILTER_USE_KEY));
        }

        $totalToCalculatePercentage = $totalToCalculatePercentage > 0 ? $totalToCalculatePercentage : $total;
        $totalValue = $totalToCalculatePercentage > 1000 ? $this->roundNum($totalToCalculatePercentage/1000) : $this->roundNum($totalToCalculatePercentage);
        $totalText = $totalToCalculatePercentage > 1000 ? "tCO2e" : "kgCO2e";

        $providedDataArray = get_object_vars($providedData);

        $filteredKeys = array_keys(array_filter($providedDataArray, function ($key) use ($keysToIgnore) {
            return $key !== 'total' && !in_array($key, $keysToIgnore);
        }, ARRAY_FILTER_USE_KEY));

        foreach ($filteredKeys as $i => $key) {
            $value = $providedDataArray[$key];
            $rawData[] = $this->roundNum($value);
            // Calculate percentage
            $percentage = $totalToCalculatePercentage > 0 ? ($value / $totalToCalculatePercentage) * 100 : 0;
            $percentageData[] = round($percentage, 2);
            // Label with RAW value
            $label = $labels[$i] ?? $key;
            if ($value < 1000) {
                $adjustedLabels[] = $label . " (" . $this->roundNum($value) . " kgCO2e)";
            } else {
                $adjustedLabels[] = $label . " (" . $this->roundNum($value/1000) . " tCO2e)";
            }

        }

        $config = <<<EOD
        {
            type: 'doughnut',
            data: {
                datasets: [
                    {
                        data: [{$this->arrayToString($percentageData)}],
                        borderWidth: 0,
                    }
                ],
                labels: [{$this->arrayToString($adjustedLabels, true)}]
            },
            options: {
                plugins: {
                    doughnutlabel: {
                        labels: [
                            {
                                text: {$totalValue},
                                font: {
                                    size: 20
                                }
                            },
                            {
                                text: '{$totalText}',
                            }
                        ]
                    },
                    datalabels: {
                        formatter: (value) => {
                            return value + '%';
                        },
                        display: (context) => {
                            return context.dataset.data[context.dataIndex] >= 4;
                        }
                    },
                }
            }
        }
        EOD;

        return $config;
    }

    private function roundNum($number) {
        return round($number, 2);
    }

    private function arrayToString(array $array, bool $isString = false) {
        if ($isString) {
            return "'" . implode("', '", $array) . "'";
        }
        return implode(', ', $array);
    }
}
