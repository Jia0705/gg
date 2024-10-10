<?php 
  // check if user is logged in.
  checkIfuserIsNotLoggedIn();

  require "parts/header.php"; 
?>
<div class="container mx-auto my-5" style="max-width: 700px;">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h1 fw-bold">Add New Post</h1>
  </div>
  <div class="card shadow-sm p-4 mb-4 bg-white rounded">
    <?php require "parts/error_message.php"; ?>
    <form method="POST" action="/post/add" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="post-title" class="form-label fw-semibold">Title</label>
        <input type="text" class="form-control border-secondary" id="post-title" name="title" placeholder="Enter post title" />
      </div>
      <div class="mb-3">
        <label for="image" class="form-label fw-semibold">Upload Image</label>
        <input type="file" name="image" id="image" class="form-control border-secondary">
      </div>
      <div class="mb-3">
        <label for="post-content" class="form-label fw-semibold">Content</label>
        <textarea class="form-control border-secondary" id="post-content" rows="8" name="content" placeholder="Write your post content here"></textarea>
      </div>
      <div class="text-end">
        <button type="submit" class="btn btn-primary px-4 py-2">Add Post</button>
      </div>
    </form>
  </div>
  <div class="text-center mt-4">
    <a href="/manage-posts" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to Posts</a>
  </div>
</div>

<?php require 'parts/footer.php'; ?>
