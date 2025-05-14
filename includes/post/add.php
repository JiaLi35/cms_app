<?php
$database = connectToDB();

$title = $_POST["title"];
$content = $_POST["content"];
// get the file from the form (must have that enctype="multipart/form-data")
$image = $_FILES["image"];

    if (empty($title) || empty($content)){
        $_SESSION["error"] = "Please fill up all the fields.";
        header("Location: /manage-posts-add");
        exit;
    } 

    // trigger the file upload
    // make sure $image is not empty
    if ( !empty( $image ) ) {
        // where is the upload folder
        $target_folder = "uploads/";
        // add the image name to the upload folder path
        $target_path = $target_folder . basename( $image["name"] );
        // move the file to the uploads folder
        move_uploaded_file( $image["tmp_name"] , $target_path );
    }


    $sql = "INSERT INTO posts (`title`, `content`, `image`,`user_id`) VALUES (:title, :content, :image, :user_id)";

    $query = $database->prepare($sql);

    $query->execute([
        "title" => $title,
        "content" => $content, 
        "image" => isset($target_path) ? $target_path : "",
        "user_id" => $_SESSION["user"]["id"]
    ]);

    $_SESSION["success"] = "Post created successfully!";
    header("Location: /manage-posts");
    exit;