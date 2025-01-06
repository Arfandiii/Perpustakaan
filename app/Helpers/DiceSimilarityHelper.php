<?php

namespace App\Helpers;

use App\Models\Book;

class DiceSimilarityHelper
{
    public static function calculateDiceSimilarity($tokens1, $tokens2)
    {
        $intersection = array_intersect($tokens1, $tokens2);
        $diceSimilarity = (2 * count($intersection)) / (count($tokens1) + count($tokens2));
        return $diceSimilarity;
    }

    public static function calculateConfusionMatrix(array $predicted, array $actual)
    {
        $TP = $FP = $FN = $TN = 0;

        // Menghitung TP dan FP
        foreach ($predicted as $predictedId) {
            if (in_array($predictedId, $actual)) {
                $TP++;  // Buku relevan yang diprediksi benar
            } else {
                $FP++;  // Buku tidak relevan yang diprediksi relevan
            }
        }

        // Menghitung FN
        foreach ($actual as $trueResult) {
            if (!in_array($trueResult, $predicted)) {
                $FN++;  // Buku relevan yang tidak diprediksi relevan
            }
        }

        // TN adalah total buku - (TP + FP + FN)
        // Menghitung TN
        $totalBooks = Book::count();  // Mengasumsikan bahwa total buku adalah jumlah elemen di actual
        $TN = $totalBooks - ($TP + $FP + $FN);


        return [
            'TP' => $TP,
            'FP' => $FP,
            'FN' => $FN,
            'TN' => $TN,
        ];
    }

    public static function calculateMetrics($TP, $FP, $FN, $TN)
    {
        $precision = ($TP + $FP) > 0 ? $TP / ($TP + $FP) : 0;
        $recall = ($TP + $FN) > 0 ? $TP / ($TP + $FN) : 0;
        // $accuracy = ($TP + $TN + $FP + $FN) > 0 ? ($TP + $TN) / ($TP + $FP + $FN + $TN) : 0;

        return [
            'precision' => round($precision * 100, 2),
            'recall' => round($recall * 100, 2),
            // 'accuracy' => round($accuracy * 100, 2),
        ];
    }

        public static function calculateConfusionMatrixForDebug(array $predicted, array $actual)
    {
        $TP = $FP = $FN = $TN = 0;

        // Menghitung TP dan FP
        foreach ($predicted as $predictedId) {
            if (in_array($predictedId, $actual)) {
                $TP++;  // Buku relevan yang diprediksi benar
            } else {
                $FP++;  // Buku tidak relevan yang diprediksi relevan
            }
        }

        // Menghitung FN
        foreach ($actual as $trueResult) {
            if (!in_array($trueResult, $predicted)) {
                $FN++;  // Buku relevan yang tidak diprediksi relevan
            }
        }

        // TN adalah total buku - (TP + FP + FN)
        // Menghitung TN
        $totalBooks = 10;
        $TN = $totalBooks - ($TP + $FP + $FN);


        return [
            'TP' => $TP,
            'FP' => $FP,
            'FN' => $FN,
            'TN' => $TN,
        ];
    }
}