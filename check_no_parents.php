<?php

$data = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'input_large.json'), true);

/** @var array<int, bool> $idMap */
$idMap = [];

foreach ($data as $item) {
    $id = $item['id'];
    $idMap[$id] = true;
}

$noParentIds = [];
foreach ($data as $item) {
    $parentId = $item['parent'];
    if (!isset($idMap[$parentId])) {
        $noParentIds[] = $item['id'];
    }
}

$noParentCount = count($noParentIds);
echo "{$noParentCount} items have no existing parent:\n";
//echo implode("\n", $noParentIds) . "\n";