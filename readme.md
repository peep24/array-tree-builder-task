I have a problem that has been stressing me out for weeks now and i cannot find a clean solution to it that does not involve recursion. 

This is the problem:
Take a flat array of nested associative arrays and group this into one deeply nested object. The top level of this object will have its parent property as null. 

This is my solution but i admit it is far from perfect. I am fairly certain this can be done in a single loop without any recursion, but for the life of me i cannot work it out!

```
//Example single fork
$data = array(

    //Top of Tree
    0 => array(
        "name" => "A",
        "parent" => null,
        "id" => 1,
    ),

    //B Branch
    1 => array(
        "name" => "B",
        "parent" => "1",
        "id" => 2,
    ),
    2 => array(
        "name" => "B1",
        "parent" => "2",
        "id" => 3,
    ),
    3 => array(
        "name" => "B2",
        "parent" => "3",
        "id" => 4,
    ),
    4 => array(
        "name" => "B3",
        "parent" => "4",
        "id" => 5,
    ),

    //C Branch
    5 => array(
        "name" => "C",
        "parent" => "1",
        "id" => 6,
    ),
    6 => array(
        "name" => "C1",
        "parent" => "6",
        "id" => 7,
    ),
    7 => array(
        "name" => "C2",
        "parent" => "7",
        "id" => 8,
    ),
    8 => array(
        "name" => "C3",
        "parent" => "8",
        "id" => 9,
    ),

);
```

```
Actual anonymised example
array:7214 [▼
  0 => array:3 [▼
    "name" => ""
    "parent" => null
    "id" => 
  ]
  1 => array:3 [▼
    "name" => ""
    "parent" => 
    "id" => 
  ]
  2 => array:3 [▼
    "name" => ""
    "parent" => 
    "id" => 
  ]
  3 => array:3 [▼
    "name" => ""
    "parent" => 
    "id" => 
  ]
  4 => array:3 [▼
    "name" => ""
    "parent" => 
    "id" => 
  ]
  5 => array:3 [▼
    "name" => ""
    "parent" => 
    "id" => 
  ]
  6 => array:3 [▼
    "name" => ""
    "parent" => 
    "id" => 
  ]
  7 => array:3 [▼
    "name" => ""
    "parent" => 
    "id" => 
  ]
  8 => array:3 [▼
    "name" => ""
    "parent" => 
    "id" => 
  ]
  9 => array:3 [▼
    "name" => ""
    "parent" => 
    "id" => 
  ]
  10 => array:3 [▼
    "name" => ""
    "parent" => 
    "id" => 
  ]
```

```
Another example deeper nesting 
{
   "name":"top",
   "id":xxx,
   "children":{
      "second":{
         "name":"second",
         "id":xxx,
         "children":{
            "Third":{
               "name":"third",
               "id":xxx,
               "children":{
                  "fourth":{
                     "name":"fourth",
                     "id":xxx
                  }
               }
            }
         }
      }
   }
}
```

```

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

echo json_encode($obj['A']);
```

```

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
```

