<?php 
// todo: 1. connect to database
$database = connectToDB();

// todo: 2. get all the data from the form using $_POST
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];
$role = $_POST["role"];

/* 
    todo: 3. error checking
    - make sure all the fields are not empty (done)
    - make sure the password is match (done)
    - make sure the email provided does not exist in the system (done)
*/

if ( empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
    $_SESSION["error"] = "Please fill up all the fields.";
    header("Location: /manage-users-add");
    exit;
} else if ($password !== $confirm_password){
    $_SESSION["error"] = "Your passwords do not match.";
    header("Location: /manage-users-add");
    exit;
} else {
    $user = getUserByEmail($email);

    if ($user){
        $_SESSION["error"] = "This email already exists.";
        header("Location: /manage-users-add");
        exit;
    } else {
        // todo: create the user account. you need to assign the role to the user

        /*
            role options: 
            - user
            - editor 
            - admin
        */

        $sql = "INSERT INTO users (`name`, `email`,`password`,`role`) VALUES (:name, :email, :password, :role)";

        $query = $database->prepare($sql);

        $query->execute([
            "name" => $name,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "role" => $role
        ]);

        // set success message
        $_SESSION["success"] = "Account created successfully. Please login with your email and password.";
        // todo: redirect back to the /manage-users page
        header("Location: /manage-users-add");
        exit;
    }
}



