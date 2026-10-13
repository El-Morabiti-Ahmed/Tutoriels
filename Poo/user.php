<?php
class User {
    protected int $id;
    protected string $email;
    protected string $password;
    protected string $role;

    public function getRoleName(): string {
        return "Anonymous visitor <br>";
    }
}

class Author extends User {
    private string $last_name;
    private string $first_name;
    private string $biography;

    public function getRoleName(): string {
        return "Published author <br>";
    }
}

$user = new User;
echo $user->getRoleName();
$author = new Author;
echo $author->getRoleName();
?>