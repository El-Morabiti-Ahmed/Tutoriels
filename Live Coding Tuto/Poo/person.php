<?php
class person{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function display(){
        echo "The name of this person is: " . $this->name;
    }
}

$person = new person("ahmed");
$person->display();


?>