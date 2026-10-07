<?php
header("Content-Type: application/json");
$json = "data/people.json";
$data = json_decode(file_get_contents($json), true);

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $new = json_decode(file_get_contents("php://input"), true);
    if($data !== []){
        $new['id'] = max(array_column($data, "id")) + 1;
    }else{
        $new['id'] = 1;
    }
    $data[] = $new;
}

$encoded = json_encode($data);
file_put_contents($json, $encoded);

echo $encoded;





?>