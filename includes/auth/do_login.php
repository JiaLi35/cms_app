<?php
$database = connectToDB();

$email = $_POST["email"];
$password = $_POST["password"];

if ( empty($email) || empty($password) ){
    echo "Please fill up all the fields";
} else {
    // sql command
    $sql = "SELECT * FROM users WHERE email = :email";

    // prepare
    $query = $database->prepare($sql);

    // execute
    $query->execute([
        "email" => $email
    ]);

    // fetching data 
    $user = $query->fetch();

    if ( $user ){
        // verify password
        if (password_verify($password, $user["password"])){
            // store user data in user session
            $_SESSION["user"] = $user;

            header("Location: /");
            exit;

        } else {
            echo "Incorrect Password";
        }
    } else {
        echo "This email does not exist";
    }

}