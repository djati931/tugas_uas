<?php

function euclideanDistance($a, $b) {
    return sqrt(($a[0] - $b[0])**2 + pow($a[1] - $b[1], 2));
}

function knnPredict($trainingData, $input, $k) {
    $distances = [];
    foreach ($trainingData as $data) {
        $distance = euclideanDistance($input, $data);
        $distances[] = ['distance' => $distance, 'label' => $data[2]];
    }
    usort($distances, fn($a, $b) => $a['distance'] <=> $b['distance']);
    $nearest = array_slice($distances, 0, $k);

    $votes = [];
    foreach ($nearest as $n) {
        $label = $n['label'];
        $votes[$label] = ($votes[$label] ?? 0) + 1;
    }

    arsort($votes);
    return array_key_first($votes);
}

function crossValidate($data, $kFolds, $kValue) {
    shuffle($data);
    $foldSize = floor(count($data) / $kFolds);
    $accuracyList = [];

    for ($i = 0; $i < $kFolds; $i++) {
        $testData = array_slice($data, $i * $foldSize, $foldSize);
        $trainData = array_merge(
            array_slice($data, 0, $i * $foldSize),
            array_slice($data, ($i + 1) * $foldSize)
        );

        $correct = 0;
        foreach ($testData as $test) {
            $predicted = knnPredict($trainData, $test, $kValue);
            if ($predicted === $test[2]) {
                $correct++;
            }
        }

        $accuracy = $correct / count($testData);
        $accuracyList[] = $accuracy;
    }

    return array_sum($accuracyList) / count($accuracyList);
}

function cariKTerbaik($data, $kFolds = 5, $maksK = 9) {
    $hasil = [];
    for ($k = 1; $k <= min($maksK, count($data) - 1); $k += 2) {
        $akurasi = crossValidate($data, $kFolds, $k);
        $hasil[$k] = $akurasi;
    }
    arsort($hasil); // urutkan dari akurasi tertinggi
    $kTerbaik = array_key_first($hasil);
    return ['k' => $kTerbaik, 'akurasi' => $hasil[$kTerbaik], 'semua' => $hasil];
}
?>