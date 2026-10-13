<?php
class Category {
    public string $name;

    public function __construct($initialname) {
        $this->name = $initialname; 
    }

    public function setName(string $newName): void {
        if (strlen($newName) > 2) {
            $this->name = $newName;
        } else {
            echo "Error: Name is too short!<br>";
        }
    }

    public function getName(): string {
        return $this->name;
    }
}


class ManageCategorie {
    public function getAll(): array {
        return [
            new Category("Web Dev"),
            new Category("Design")
        ];
    }
}





class CategoryController {
    public function listerCategories(): void {
        $gestion = new ManageCategorie();
        $categories = $gestion->getAll();
        
        foreach ($categories as $cat) {
            echo $cat->getName() . "<br>";
        }
    }
}

// Test d'exécution
$controller = new CategoryController();
$controller->listerCategories();
?>
