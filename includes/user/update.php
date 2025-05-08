<?php
$database = connectToDB();

$id = $_POST["id"];
$name = $_POST["name"];
$role = $_POST["role"];

if (empty($name) || empty($id) || empty($role)){
    $_SESSION["error"] = "Please fill up all the fields";
    header("Location: /manage-users-edit?id=" . $id);
    exit;
} else {
    $sql = "UPDATE users SET name = :name, role=:role WHERE id = :id";

    $query = $database->prepare($sql);

    $query->execute([
        "id" => $id,
        "name" => $name,
        "role" => $role
    ]);

    $_SESSION["success"] = "User has been updated successfully";
    header("Location: /manage-users");
    exit;
}