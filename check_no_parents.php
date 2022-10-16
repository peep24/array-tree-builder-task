<?php

$data = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'fixed_data.json'), true);

/** @var array<int, bool> $idMap */
$idMap = [];

foreach ($data as $item) {
    $id = $item['type'] . $item['id'];
    $idMap[$id] = true;
}

$noParentIds = [];
foreach ($data as $item) {
    $parentId = $item['parent'];
    if (!isset($idMap[$parentId])) {
        $noParentIds[] = $item['type'] . $item['id'];
    }
}

$noParentCount = count($noParentIds);
echo "{$noParentCount} items have no existing parent. First 25:\n";
echo implode("\n", array_slice($noParentIds, 0, 25)) . "\n";