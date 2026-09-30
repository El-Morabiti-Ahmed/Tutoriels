<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

$file = __DIR__ . '/categories.json';

// Initialize default categories file if it doesn't exist
if (!file_exists($file)) {
    $categories = [
        ["id" => 1, "name" => "Development", "color" => "red", "icon" => "code"],
        ["id" => 2, "name" => "UI/UX Design", "color" => "blue", "icon" => "palette"],
        ["id" => 3, "name" => "Productivity", "color" => "green", "icon" => "check-circle"]
    ];

    file_put_contents($file, json_encode($categories, JSON_PRETTY_PRINT));
}

$categories = json_decode(file_get_contents($file), true) ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);

    // Generate a unique ID (based on highest existing ID to avoid duplicate keys after deletions)
    $maxId = 0;
    foreach ($categories as $cat) {
        if (isset($cat['id']) && $cat['id'] > $maxId) {
            $maxId = $cat['id'];
        }
    }
    $data['id'] = $maxId + 1;

    $categories[] = $data;

    file_put_contents($file, json_encode($categories, JSON_PRETTY_PRINT));

    echo json_encode($data);

} 
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data['id'] ?? null;

    $categories = array_filter($categories, function ($category) use ($id) {
        return $category['id'] != $id;
    });

    $categories = array_values($categories);

    file_put_contents($file, json_encode($categories, JSON_PRETTY_PRINT));

    echo json_encode([
        "message" => "Category deleted successfully"
    ]);

} 
else {

    echo json_encode($categories);

}