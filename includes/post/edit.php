<?php
$database = connectToDB();

$id = $_POST["id"];
$title = $_POST["title"];
$content = $_POST["content"];
$status = $_POST["status"];

if (empty($title) || empty($content) || empty($status)){
    $_SESSION["error"] = "Please fill up all the fields.";
    header("Location: /manage-posts-edit?id=" . $id);
    exit;
} else {
    $sql = "UPDATE posts SET title = :title, content = :content, status = :status WHERE id = :id"; 

    $query = $database->prepare($sql);

    $query->execute([
        "id" => $id,
        "title" => $title,
        "content" => $content,
        "status" => $status
    ]);

    $_SESSION["success"] = "Post updated successfully.";
    header("Location: /manage-posts");
    exit;
}