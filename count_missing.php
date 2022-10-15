<?php

$data = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'fixed_data.json'), true);
$strData = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'output.json');

$count = 0;

forEach($data as $item) {
    $target = strpos($strData, '"id": ' . $item['id']);

    if ($target !== false){
        $count++;
    }
}

echo "out of " . count($data) . " potentially " . $count . " are missing.";



