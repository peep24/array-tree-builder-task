<?php

$data = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'movies_with_array_for_id_parent.json'), true);

/** @var array<int, bool> $idMap */
$idMap = [];

foreach ($data as $item) {
    $id = $item['id']['type'] . ':' . $item['id']['id'];
    $idMap[$id] = true;
}

$noParentIds = [];
foreach ($data as $item) {
    $parentId = ($item['parent']['type'] ?? '') . ':' . ($item['parent']['id'] ?? '');
    if (!isset($idMap[$parentId])) {
        $noParentIds[] = $item['id']['type'] . ':' . $item['id']['id'];
    }
}

$noParentCount = count($noParentIds);
echo "{$noParentCount} items have no existing parent. First 25:\n";
echo implode("\n", array_slice($noParentIds, 0, 25)) . "\n";