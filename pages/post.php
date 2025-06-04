<?php
  // TODO: 1. connect to database
  $database = connectToDB();
  // TODO: 2. get all the users
    // get id from the url 
  $id = $_GET["id"];
  // TODO: 2.1
  $sql = "SELECT posts.*, users.name 
            FROM posts 
            JOIN users 
            ON posts.user_id = users.id 
            WHERE posts.id = :id";
  // TODO: 2.2
  $query = $database->prepare( $sql );
  // TODO: 2.3
  $query->execute([
    "id" => $id
  ]);
  // TODO: 2.4 fetch
  $post = $query->fetch(); // get only the first row of the match data
?>

<?php require "parts/header.php"; ?>

    <div class="container mx-auto my-5" style="max-width: 500px;">
      <h1 class="h1 mb-4 text-center"><?= $post["title"]; ?></h1>
      <h3 class="mb-4">By <?= $post["name"]; ?></h3>
      <div class="mb-2">
        <img src="<?= $post["image"]; ?>" class="img-fluid">
      </div>
      <?php
      /*
        $content = "1,2,3,4,5";
        $content_array = explode(",", $content);
        $content_array = [1, 2, 3, 4, 5];
      */
      
        // $content = $post["content"];  
        // $content_array = explode("\n", $content);
        // foreach($content_array as $paragraph){
        //   echo "<p>$paragraph</p>";
        // }

        echo nl2br($post["content"]);
      ?>
      <div class="text-center mt-3">
        <a href="/" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back</a
        >
      </div>
    </div>

<?php require "parts/footer.php"; ?>
