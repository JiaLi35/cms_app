<?php
  // TODO: 1. connect to database
  $database = connectToDB();

  // TODO: 2.1
  $sql = "SELECT * FROM posts WHERE status = 'publish' ORDER BY id DESC";
  
  // TODO: 2.2
  $query = $database->prepare( $sql );
  // TODO: 2.3
  $query->execute();
  // TODO: 2.4
  $posts = $query->fetchAll();
?>
<?php require "parts/header.php"; ?>

    <div class="container mx-auto my-5" style="max-width: 500px;">
      <h1 class="h1 mb-4 text-center">My Blog</h1>
      <p><?= (isUserLoggedIn() ? "Welcome back, " . $_SESSION["user"]["name"] : "" ); ?></p>
      <?php foreach ($posts as $index => $post) : ?>
      <div class="card mb-2">
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