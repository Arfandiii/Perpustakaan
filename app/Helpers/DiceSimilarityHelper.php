<?php

namespace App\Helpers;

class DiceSimilarityHelper
{
    public static function calculateDiceSimilarity(array $setA, array $setB)
    {
        $intersection = array_intersect($setA, $setB);
        $diceSimilarity = (2 * count($intersection)) / (count($setA) + count($setB));
        return $diceSimilarity;
    }

    public static function calculateConfusionMatrix(array $predicted, array $actual)
    {
        $TP = $FP = $FN = $TN = 0;

        foreach ($predicted as $index => $value) {
            if ($value == 1 && $actual[$index] == 1) {
                $TP++;
            } elseif ($value == 1 && $actual[$index] == 0) {
                $FP++;
            } elseif ($value == 0 && $actual[$index] == 1) {
                $FN++;
            } elseif ($value == 0 && $actual[$index] == 0) {
                $TN++;
            }
        }

        return [
            'TP' => $TP,
            'FP' => $FP,
            'FN' => $FN,
            'TN' => $TN,
        ];
    }

    public function calculateMetrics($TP, $FP, $FN, $TN)
    {
        // Precision = TP / (TP + FP)
        $precision = $TP / ($TP + $FP);

        // Recall = TP / (TP + FN)
        $recall = $TP / ($TP + $FN);

        // Accuracy = (TP + TN) / (TP + TN + FP + FN)
        $accuracy = ($TP + $TN) / ($TP + $TN + $FP + $FN);

        return [
            'precision' => $precision,
            'recall' => $recall,
            'accuracy' => $accuracy,
        ];
    }
}