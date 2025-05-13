<?php
  if (!isUserLoggedIn()){
    header("Location: /");
    exit;
  }

  // TODO: 1. connect to database
  $database = connectToDB();
  // TODO: 2. get all the users
  $user_id = $_SESSION["user"]["id"];
  // $user_id = 9;

  // TODO: 2.1
  /*
    use ORDER BY to sort by column
    use ASC to sort by ascending order (small to large)
    use DESC to sort by descending order (large to small)
  */

  if (isEditor()){
    $sql = "SELECT posts.*, users.name 
            FROM posts 
            JOIN users 
            ON posts.user_id = users.id 
            ORDER BY posts.id DESC";
    
    // TODO: 2.2
    $query = $database->prepare( $sql );
  
    // TODO: 2.3
    $query->execute();
  } else {
    $sql = "SELECT posts.*, users.name 
    FROM posts 
    JOIN users 
    ON posts.user_id = users.id 
    WHERE posts.user_id = :user_id 
    ORDER BY posts.id DESC";
    
    // TODO: 2.2
    $query = $database->prepare( $sql );
  
    // TODO: 2.3
    $query->execute([
      "user_id" => $user_id
    ]);
  }
    
  // TODO: 2.4
  $posts = $query->fetchAll();
?>

<?php require "parts/header.php"; ?>

    <div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Manage Posts</h1>
        <div class="text-end">
          <a href="/manage-posts-add" class="btn btn-primary btn-sm">
            Add New Post
          </a>
        </div>
      </div>
      <div class="card mb-2 p-4">
        <?php require "parts/message_success.php"; ?>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col" style="width: 40%;">Title</th>
              <th scope="col">Author</th>
              <th scope="col">Status</th>
              <th scope="col" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- write out posts -->
            <?php foreach ($posts as $post) : ?>
                <tr>
                  <th scope="row"><?= $post["id"]; ?></th>
                  <td><?= $post["title"]; ?></td>
                  <td class="text-center"><?= $post["name"]; ?></td>
                    <!-- status color -->
                    <?php if($post["status"] === "Publish") : ?>
                      <td><span class="badge bg-success"><?= $post["status"]; ?></span></td>
                    <?php else : ?>
                      <td><span class="badge bg-warning"><?= $post["status"]; ?></span></td>
                    <?php endif; ?>
                    <td class="text-end">
                      <!-- buttons start -->
                      <div class="buttons">
                        <?php if ($post["status"] === "Pending Review") : ?>
                        <a
                          href="/post?id=<?=$post["id"]?>"
                          target="_blank"
                          class="btn btn-primary btn-sm me-2 disabled"
                          ><i class="bi bi-eye"></i>
                        </a>
                        <?php else : ?>
                        <a
                          href="/post?id=<?=$post["id"]?>"
                          target="_blank"
                          class="btn btn-primary btn-sm me-2"
                          ><i class="bi bi-eye"></i>
                        </a>
                        <?php endif; ?>
                        <a
                          href="/manage-posts-edit?id=<?= $post["id"] ?>"
                          class="btn btn-secondary btn-sm me-2"
                          ><i class="bi bi-pencil"></i
                        ></a>
                        <!-- Button to trigger delete confirmation modal -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#postDeleteModal-<?= $post["id"]; ?>">
                        <i class="bi bi-trash"></i>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="postDeleteModal-<?= $post["id"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure you want to delete this post?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <p>You are tyring to delete this post: <?= $post["title"]; ?></p>
                                <p>This action cannot be reversed.</p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <!-- delete button -->
                                <form method="POST" action="/post/delete">
                                  <input type="hidden" name="id" value="<?= $post["id"]?>">
                                  <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> DELETE
                                  </button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- end of modal -->
                      </div>
                      <!-- end of buttons -->
                    </td>
                  </tr>
              <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="text-center">
        <a href="/dashboard" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Dashboard</a
        >
      </div>
    </div>

<?php require "parts/footer.php"; ?>
