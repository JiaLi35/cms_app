<?php require "parts/header.php"; ?>

    <div class="container mx-auto my-5" style="max-width: 500px;">
      <h1 class="h1 mb-4 text-center">My Blog</h1>
      <p><?= (isUserLoggedIn() ? "Welcome back, " . $_SESSION["user"]["name"] : "" ); ?></p>
      <div class="card mb-2">
        <div class="card-body">
          <h5 class="card-title">Post 4</h5>
          <p class="card-text">Here's some content about post 4</p>
          <div class="text-end">
            <a href="/post" class="btn btn-primary btn-sm">Read More</a>
          </div>
        </div>
      </div>
      <div class="card mb-2">
        <div class="card-body">
          <h5 class="card-title">Post 3</h5>
          <p class="card-text">This is for post 3</p>
          <div class="text-end">
            <a href="/post" class="btn btn-primary btn-sm">Read More</a>
          </div>
        </div>
      </div>
      <div class="card mb-2">
        <div class="card-body">
          <h5 class="card-title">Post 2</h5>
          <p class="card-text">This is about post 2</p>
          <div class="text-end">
            <a href="/post" class="btn btn-primary btn-sm">Read More</a>
          </div>
        </div>
      </div>
      <div class="card mb-2">
        <div class="card-body">
          <h5 class="card-title">Post 1</h5>
          <p class="card-text">This is a post</p>
          <div class="text-end">
            <a href="/post" class="btn btn-primary btn-sm">Read More</a>
          </div>
        </div>
      </div>

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