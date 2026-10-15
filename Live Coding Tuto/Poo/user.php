<?php
class User{
    protected string $email;
    protected string $password;
    protected string $role;

    public function getrole(){
        return "This is a normal user <hr>";
    }
}

class Author extends User{
    private string $last_name;
    private string $first_name;
    private string $biography;

    public function getrole(){
        return "This is an author";
    }
}

$User = new user;
echo $User->getrole();
$Author = new Author;
echo $Author->getrole();






?>