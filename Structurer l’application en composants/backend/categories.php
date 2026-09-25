<?php
// 1. Make the response into a Json
header('Content-Type: application/json');

// 2. Prepare the table of data
$categories = [
    ["id" => 1, "name" => "Web Dev"],
    ["id" => 2, "name" => "Design UI/UX"]
];

// 3. Converts the php table into Json and echos it
echo json_encode($categories);
?>