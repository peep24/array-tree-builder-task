<?php

function buildTree(array $items): ?array {

    // Get a mapping of each item by ID, and pre-prepare the "children" property.
    $idMap = [];
    foreach ($items as $item) {
        $id = $item['id']['id'];
        $idMap[$id ] = $item;
        $idMap[$id ]['children'] = [];
    }

    // Store a reference to the treetop if we come across it.
    $treeTop = null;

    // Map items to their parents' children array.
    foreach ($idMap as $id => $item) {
        if ($item['parent'] && isset($idMap[$item['parent']['id']])) {
            $parent = &$idMap[$item['parent']['id']];
            $parent['children'][] = &$idMap[$id];
        } else if ($item['parent'] === null) {
            $treeTop = &$idMap[$id];
        }
    }

    return $treeTop;
}

$data = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'movies_with_array_for_id_parent.json'), true);
// file_put_contents('output.json', json_encode(buildTree($data), JSON_PRETTY_PRINT));
echo json_encode(buildTree($data), JSON_PRETTY_PRINT);