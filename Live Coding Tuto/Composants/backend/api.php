<?php
header("Content-Type:application/json");

$data = [
    [
        "id" => 1,
        "name" => "ahmed",
    ],
    [
        "id" => 2,
        "name" => "anwar"
    ],
    [
        "id" => 3,
        "name" => "adam"
    ]
];

echo json_encode($data);



?>