<?php


function buildTree(array $data): ?array {

    $originalLength = count($data);
    $obj = [];
    while ($originalLength > 0) {
        foreach ($data as $item) {
            $name = $item['name'];
            $parent = $item['parent'];

            $a = isset($obj[$name]) ? $obj[$name] : array('name' => $name, 'id'=>$item['id']);

            if (($parent)) {

                $path = get_nested_path($parent, $obj, array(['']));
                try {
                    insertItem($obj, $path, $a);
                } catch (Exception $e) {
                    continue;
                    //echo 'Caught exception: ', $e->getMessage(), "\n";
                }
            }

            $obj[$name] = isset($obj[$name]) ? $obj[$name] : $a;
            $originalLength--;
        }
    }

    $firstKey = array_key_first($obj);
    return $obj[$firstKey];
}

function get_nested_path($parent, $array, $id_path)
{

    if (is_array($array) && count($array) > 0) {

        foreach ($array as $key => $value) {
            $temp_path = $id_path;

            array_push($temp_path, $key);

            if ($key == "id" && $value == $parent) {
                array_shift($temp_path);
                array_pop($temp_path);
                return $temp_path;
            }

            if (is_array($value) && count($value) > 0) {
                $res_path = get_nested_path(
                    $parent, $value, $temp_path);

                if ($res_path != null) {
                    return $res_path;
                }
            }
        }
    }
    return null;
}

function insertItem(&$array, $path, $toInsert)
{
    $target = &$array;
    foreach ($path as $key) {
        if (array_key_exists($key, $target))
            $target = &$target[$key];
        else throw new Exception('Undefined path: ["' . implode('","', $path) . '"]');
    }

    $target['children'] = isset($target['children']) ? $target['children'] : [];
    $target['children'][$toInsert['name']] = $toInsert;
    return $target;
}

$data = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'input_large.json'), true);
echo json_encode(buildTree($data), JSON_PRETTY_PRINT);