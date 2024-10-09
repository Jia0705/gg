<?php 

  // check if whoever that viewing this page is logged in.
  // if not logged in, you want to redirect back to login page
  checkIfuserIsNotLoggedIn();

  // get the id from the URL
  $id = $_GET["id"];

  $database = connectToDB();
  // 2. get all the posts
  // 2.1
  $sql = "SELECT * FROM posts WHERE id =:id";
  // 2.2
  $query = $database->prepare( $sql );
  // 2.3
  $query->execute([
    'id' => $id
  ]);
  // 2.4
  $post = $query->fetch();

require "parts/header.php"; ?>
<div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Edit Post</h1>
      </div>
      <div class="card mb-2 p-4">
        <?php require "parts/error_message.php"; ?>
        <form method="POST" action="/post/edit" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="post-title" class="form-label">Title</label>
            <input
              type="text"
              class="form-control"
              id="post-title"
              value="<?= $post['title']; ?>"
              name="title"
            />
          </div>
          <div class="mb-3">
        <label for="image" class="form-label">Upload New Image (optional)</label>
        <input type="file" name="image" id="image" class="form-control">
        <?php if ($post['image']): ?>
            <p>Current Image:</p>
            <img src="<?=$post['image']; ?>" alt="Post Image" style="max-width: 200px;">
        <?php endif; ?>
    </div>
          <div class="mb-3">
            <label for="post-content" class="form-label">Content</label>
            <textarea class="form-control" id="post-content" rows="10" name="content"><?= $post['content']; ?></textarea
            >
          </div>
          <div class="mb-3">
            <label for="post-content" class="form-label">Status</label>
            <select class="form-control" id="post-status" name="status">

              <?php if ( $post['status'] == 'publish' ) : ?>
                <option value="publish" selected>Publish</option>
              <?php else: ?>
                <option value="publish">Publish</option>
              <?php endif; ?>

              <?php if ( $post['status'] == 'pending' ) : ?>
                <option value="pending" selected>Pending Review</option>
              <?php else: ?>
                <option value="pending">Pending Review</option>
              <?php endif; ?>

            </select>
          </div>
          <div class="text-end">
            <input type="hidden" name="id" value="<?= $post['id']; ?>" />
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
      <div class="text-center">
        <a href="/manage-posts" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Posts</a
        >
      </div>
    </div>
    <?php require 'parts/footer.php';