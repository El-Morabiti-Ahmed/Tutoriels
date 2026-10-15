<?php

require_once 'Category.php';

class CategoryManager {
    private static $dataFile = __DIR__ . '/../../data/categories.json';

    public function getAll(): array {
        if (!file_exists(self::$dataFile)) {
            return [];
        }
        
        $json = file_get_contents(self::$dataFile);
        $data = json_decode($json, true);
        
        $categories = [];
        foreach ($data as $row) {
            $categories[] = new Category(
                $row['id'], 
                $row['name'], 
                $row['color'], 
                $row['icon']
            );
        }
        
        return $categories;
    }
}