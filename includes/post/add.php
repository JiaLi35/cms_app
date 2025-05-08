<?php
$database = connectToDB();

$title = $_POST["title"];
$content = $_POST["content"];

if (empty($title) || empty($content)){
    $_SESSION["error"] = "Please fill up all the fields.";
    header("Location: /manage-posts-add");
    exit;
} else {
    $sql = "INSERT INTO posts (`title`, `content`, `user_id`) VALUES (:title, :content, :user_id)";

    $query = $database->prepare($sql);

    $query->execute([
        "title" => $title,
        "content" => $content, 
        "user_id" => $_SESSION["user"]["id"]
    ]);

    $_SESSION["success"] = "Post created successfully!";
    header("Location: /manage-posts");
    exit;
}