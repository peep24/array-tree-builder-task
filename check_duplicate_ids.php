<?php

$data = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'movies_with_array_for_id_parent.json'), true);

$copy = $data;

foreach ($copy as $item) {
    $filtered = array_filter($data, function($v) use($item) {
        return $v['id']['id'] == $item['id']['id'] && $v['id']['type'] == $item['id']['type'];
    });

    if(count($filtered) > 1) {
        echo json_encode($filtered);
    }

}



