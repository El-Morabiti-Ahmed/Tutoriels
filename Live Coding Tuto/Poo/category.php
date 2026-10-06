<?php
class Category{
    private string $name;

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): Void {
        $this->name = $name;
    }
}

$cat = new Category(null);
$cat->setName('ahmed');
echo "my name is: " . $cat->getName();





?>