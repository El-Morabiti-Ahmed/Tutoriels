<?php
class Category {
    public $name;

    //The constructor is called during the "new Category(...)"
    public function __construct($initialname) {
        $this->name = $initialname; //We assign the parameter to the property of the current object
    }

    //A personalized method
    public function show() {
        echo "Display via method: " . $this->name;
    }
}

$cat = new Category("UI/UX Design");
$cat->show();
?>