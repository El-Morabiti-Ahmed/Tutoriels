<?php

require_once '../../backend/classes/CatManager.php';

class CategoryController {
    public function listCategories(): void {
        $manager = new CategoryManager();
        $categories = $manager->getAll();
        
        // 1. Prepare raw data (decoupled from HTML)
        $data = [];
        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'color' => $category->getColor(),
                'icon' => $category->getIcon()
            ];
        }
        
        // 2. Set response headers
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *'); // Convenient for local development
        
        // 3. Return raw JSON payload
        echo json_encode($data);
    }
}

$controller = new CategoryController();
$controller->listCategories();

?>