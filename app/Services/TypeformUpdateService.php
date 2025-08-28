<?php

namespace App\Services;

class TypeformUpdateService
{
    public function updateArrayValueWithKeys(&$array, $keysString, $newValue) {
        $keys = explode("__", $keysString);
        $tempArray = &$array;

        foreach ($keys as $index => $key) {
            if ($index === count($keys) - 1 && ctype_upper(substr($key, 0, 1))) {
                $key = str_replace('_', ' ', $key);
            }

            if (!isset($tempArray[$key])) {
                $tempArray[$key] = [];
            }
            $tempArray = &$tempArray[$key];
        }
        $tempArray = $newValue;
        return true;
    }

    public function getFirstKey($array) {
        $keys = array_keys($array);
        return isset($keys[0]) ? $keys[0] : null;
    }

    /**
     * Transforme les activites pour la sauvegarde (tableau associatif -> tableau indexé)
     */
    public function transformActivitesForSave($activitesData) {
        if (!is_array($activitesData)) {
            return $activitesData;
        }

        return array_keys(
            array_filter($activitesData, function ($v) {
                return $v === 'Yes' || $v === true || $v === 1;
            })
        );
    }

    /**
     * Transforme les activites pour l'affichage (tableau indexé -> tableau associatif)
     */
    public function transformActivitesForDisplay($activitesData) {
        if (!is_array($activitesData)) {
            return $activitesData;
        }

        $activitesArray = [];
        foreach ($activitesData as $activite) {
            $activitesArray[$activite] = 'Yes';
        }
        return $activitesArray;
    }

    public function handleUpdate($requestData, &$data, $questionAnswer, $dataKey, $service)
    {
        switch ($questionAnswer['type']) {
            case 'checkbox':
                if (!$service->authorizedAnswer($questionAnswer, array_keys($requestData[$dataKey]))) {
                    throw new \Exception('Answer not authorized');
                }
                $result = $this->updateArrayValueWithKeys($data, $dataKey, array_keys($requestData[$dataKey]));
                break;
            case 'toggle':
                if (!$service->authorizedAnswer($questionAnswer, $requestData[$dataKey])) {
                    throw new \Exception('Answer not authorized');
                }
                $result = $this->updateArrayValueWithKeys($data, $dataKey, $requestData[$dataKey]);
                break;
            case 'select':
                if (!$service->authorizedAnswer($questionAnswer, $requestData[$dataKey])) {
                    throw new \Exception('Answer not authorized');
                }
                $result = $this->updateArrayValueWithKeys($data, $dataKey, [$requestData[$dataKey]]);
                break;
            case 'text':
                $result = $this->updateArrayValueWithKeys($data, $dataKey, htmlspecialchars($requestData[$dataKey]));
                break;
            case 'number':
                $result = $this->updateArrayValueWithKeys($data, $dataKey, intval($requestData[$dataKey]));
                break;
            case 'rating':
                $result = $this->updateArrayValueWithKeys($data, $dataKey, intval($requestData[$dataKey]));
                break;
            case 'date':
                $result = $this->updateArrayValueWithKeys($data, $dataKey, htmlspecialchars($requestData[$dataKey]));
                break;
            default:
                throw new \Exception('Unsupported question type ' . $questionAnswer['type']);
        }
        return $result;
    }
}
