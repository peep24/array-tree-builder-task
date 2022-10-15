<?php

$data = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'output.json'), true);

/** @var array<int, int> $countById */
$countById = [];

foreach ($data as $item) {
    $id = $item['id'];
    $countById[$id] = ($countById[$id] ?? 0) + 1;
}

/** @var array<int, int> $dupeFrequencyRollup */
$dupeFrequencyRollup = [];
foreach ($countById as $id => $count) {
    if ($count < 2) {
        continue;
    }

    $dupeFrequencyRollup[$count] = ($dupeFrequencyRollup[$count] ?? 0) + 1;
}

foreach ($dupeFrequencyRollup as $dupeCount => $count) {
    echo "Found {$dupeCount} duplicates {$count} times\n";
}