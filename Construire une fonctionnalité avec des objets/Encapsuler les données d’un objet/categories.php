<?php
class Category {
    private string $name; // Private and typed property

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $newName): void {
        if (strlen($newName) > 2) { // Validation checks the data!
            $this->name = $newName;
        } else {
            echo "Error: Name is too short!<br>";
        }
    }
}

$cat = new Category();
$cat->setName("A"); // Will display the error
$cat->setName("Web Development"); // Success
echo "The name is now: " . $cat->getName();
?>