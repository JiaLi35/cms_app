<?php
$database = connectToDB();

$id = $_POST["id"];
$title = $_POST["title"];
$content = $_POST["content"];
$status = $_POST["status"];
$image = $_FILES["image"];

if (empty($title) || empty($content) || empty($status) || empty($id)){
    $_SESSION["error"] = "Please fill up all the fields.";
    header("Location: /manage-posts-edit?id=" . $id);
    exit;
} 

// if image is not empty, then do image upload
if ( !empty( $image["name"] ) ) {
    // where is the upload folder
    $target_folder = "uploads/";
    // add the image name to the upload folder path
    // YYMMDDHHIISS (put date to prevent overwriting of files)
    $target_path = $target_folder . date("YmdHisv") . "_" . basename( $image["name"] );
    // move the file to the uploads folder
    move_uploaded_file( $image["tmp_name"] , $target_path );

// update the post with image path

    $sql = "UPDATE posts SET title = :title, content = :content, status = :status, image = :image WHERE id = :id"; 

    $query = $database->prepare($sql);

    $query->execute([
        "id" => $id,
        "title" => $title,
        "content" => $content,
        "status" => $status,
        "image" => $target_path
    ]);

} else {
    // update the post

    $sql = "UPDATE posts SET title = :title, content = :content, status = :status WHERE id = :id"; 

    $query = $database->prepare($sql);

    $query->execute([
        "id" => $id,
        "title" => $title,
        "content" => $content,
        "status" => $status
    ]);

}

$_SESSION["success"] = "Post updated successfully.";
header("Location: /manage-posts");
exit;