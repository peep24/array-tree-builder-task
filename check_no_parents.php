<?php

$data = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'movies_with_array_for_id_parent.json'), true);

$copy = $data;

foreach ($copy as $item) {

    if(is_null($item['parent'])){
        continue;
    } else {
        $filtered = array_filter($data, function($v) use($item) {
            return $v['id']['id'] == $item['parent']['id'] && $v['id']['type'] == $item['parent']['type'];
        });

        // echo json_encode($filtered) . "\n";
        // echo "\n";

        if(!$filtered) {
            echo json_encode($item) . "\n";;
        }
    }



}