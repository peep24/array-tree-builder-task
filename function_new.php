<?php


function buildTree(array $items): ?array {

    // Get a mapping of each item by ID, and pre-prepare the "children" property.
    $idMap = [];
    foreach ($items as $item) {
        $idMap[$item['id']] = $item;
        $idMap[$item['id']]['children'] = [];
    }

    // Store a reference to the treetop if we come across it.
    $treeTop = null;

    // Map items to their parents' children array.
    foreach ($idMap as $id => $item) {
        if ($item['parent'] && isset($idMap[intval($item['parent'])])) {
            $parent = &$idMap[intval($item['parent'])];
            $parent['children'][] = &$idMap[$id];
        } else if ($item['parent'] === null) {
            $treeTop = &$idMap[$id];
        }
    }

    return $treeTop;
}

$data = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'input_large.json'));
echo json_encode(buildTree($data), JSON_PRETTY_PRINT);