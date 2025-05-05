<?php
$database = connectToDB();

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

if ( empty($name) || empty($email) || empty($password) || empty($confirm_password)){
    echo "Please fill up all the fields";
} else if ( $password !== $confirm_password) {
    echo "Please enter the same passwords";
} else {
    $sql = "SELECT * FROM users WHERE email = :email";

    $query = $database->prepare($sql);

    $query->execute([
        "email" => $email
    ]);

    $user = $query->fetch();
    
    if ($user){
        echo "This user already exists, please log in.";
    } else {
        $sql = "INSERT INTO users (`name`, `email`, `password`) VALUES (:name, :email, :password)";

        $query = $database->prepare($sql);

        $query->execute([
            "name" => $name,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT)
        ]);

        header("Location: /login");
        exit;
    }
}