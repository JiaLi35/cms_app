<?php

  $search_keyword = isset($_GET["search"]) ? $_GET["search"] : "";

  // TODO: 1. connect to database
  $database = connectToDB();

  // TODO: 2.1
  $sql = "SELECT * FROM posts WHERE status = 'publish' 
          AND (title LIKE :keyword OR content LIKE :keyword)  
          ORDER BY id DESC";
  
  // TODO: 2.2
  $query = $database->prepare( $sql );
  // TODO: 2.3
  $query->execute([
    "keyword" => "%$search_keyword%"
  ]);
  // TODO: 2.4
  $posts = $query->fetchAll();
?>
<?php require "parts/header.php"; ?>

    <div class="container mx-auto my-5" style="max-width: 500px;">
      <h1 class="h1 mb-4 text-center">My Blog</h1>
      <p><?= (isUserLoggedIn() ? "Welcome back, " . $_SESSION["user"]["name"] : "" ); ?></p>
      <form
        method="GET"
        action="/" 
        class="mb-2 d-flex align-items center gap-2">
        <input type="text" name="search" class="form-control" placeholder="Type a keyword to search..." value="<?=$search_keyword;?>">
        <button class="btn btn-primary"><i class="bi bi-search"></i></button> 
        <a href="/" class="btn btn-dark">Reset</a>
      </form>
      <?php foreach ($posts as $index => $post) : ?>
      <div class="card mb-2">
          <?php if (!empty($post["image"])) : ?>
            <img src="<?= $post["image"]; ?>" class="card-image-top">
          <?php endif; ?>
        <div class="card-body">
          <h5 class="card-title"><?= $post["title"]; ?></h5>
          <p class="card-text"><?= $post["content"]; ?></p>
          <div class="text-end">
            <a href="/post?id=<?=$post["id"]?>" class="btn btn-primary btn-sm">Read More</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
      <div class="mt-4 d-flex justify-content-center gap-3">
        <?php if ( isUserLoggedIn() ) : ?>
        <a href="/logout" class="btn btn-link btn-sm">Logout</a>
        <a href="/dashboard" class="btn btn-link btn-sm">Access the Dashboard</a>
        <?php else : ?>
        <a href="/login" class="btn btn-link btn-sm">Login</a>
        <a href="/signup" class="btn btn-link btn-sm">Sign Up</a>
        <?php endif; ?>
      </div>
    </div>

<?php require "parts/footer.php"; ?>