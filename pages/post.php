<?php

// 1. get the id from the URL
$id = $_GET["id"];
// 2. connect to Database
$database = connectToDB();
// 3. load the Post data
$sql = "SELECT posts.id, posts.title, posts.content, posts.user_id, posts.image, users.name 
        FROM posts 
        JOIN users 
        ON posts.user_id = users.id 
        WHERE posts.id = :id";  
$query = $database->prepare($sql);
$query->execute([
  'id' => $id
]);
$post = $query->fetch();

// Fetch comments to the post
$sql = "SELECT comments.*, users.name AS unknown 
        FROM comments 
        JOIN users ON comments.user_id = users.id 
        WHERE comments.post_id = :post_id";
$query = $database->prepare($sql);
$query->execute(['post_id' => $id]);
$comments = $query->fetchAll();

require "parts/header.php"; ?>

<div class="container my-5 ">
  <div class="row">
    <!-- post section -->
    <div class="col">
      <h1 class="h1 mb-2 text-center"><?=$post['title']; ?></h1>
      <h4 class="mb-4 text-center">By <?=$post['name']; ?></h4>
      <?php if (!empty($post['image'])) : ?>
          <div class="text-center mb-4">
              <img src="<?=$post['image']; ?>" alt="Post Image" class="img-fluid">
          </div>
      <?php endif; ?>
      <p><?= nl2br($post['content']); ?></p>
    </div>

    <!-- likes section -->
    <?php if (isset($_SESSION['user'])) : ?>
      <div class="mt-4 mb-4">
        <form method="POST" action="/like" id="likeForm">
            <input type="hidden" name="post_id" value="<?= $id; ?>">

            <!-- like -->
            <button type="submit" name="action" value="1" 
                class="btn btn-sm like-button <?= (isset($user_like) && $user_like['type'] == 1) ? 'liked' : 'btn-outline-danger'; ?>">
                <i class="bi <?= (isset($user_like) && $user_like['type'] == 1) ? 'bi-heart-fill' : 'bi-heart'; ?>"></i> Like
            </button>

            <!-- dislike -->
            <button type="submit" name="action" value="0" 
                class="btn btn-sm dislike-button <?= (isset($user_like) && $user_like['type'] == 0) ? 'disliked' : 'btn-outline-danger'; ?>">
                <i class="bi <?= (isset($user_like) && $user_like['type'] == 0) ? 'bi-heartbreak-fill' : 'bi-heartbreak'; ?>"></i> Dislike
            </button>
        </form>
    </div>
    <?php else : ?>
      <p class="mt-4">
        Please <a href="/login">log in</a> to like or dislike this post.
      </p>
    <?php endif; ?>

<!-- comments section -->
<div class="col mt-4">
    <h3>Comments</h3>
    <?php if (!empty($comments)) : ?>
        <div class="list-group">
            <?php foreach ($comments as $comment) : ?>
                <div class="list-group-item mb-3 p-3 border rounded">
                    <strong><?= $comment['unknown']; ?></strong>
                    <p><?= nl2br($comment['comment']); ?></p>
                    <?php if (isset($_SESSION['user']) && $comment['user_id'] == $_SESSION['user']['id']) : ?>
                        <div class="mt-2">
                            <a href="/comment/edit?id=<?= $comment['id']; ?>&post_id=<?= $id; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <a href="/comment/delete?id=<?= $comment['id']; ?>&post_id=<?= $id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this comment?');"><i class="bi bi-trash"></i></a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p>No comments yet. Be the first to comment!</p>
    <?php endif; ?>

    <!-- comment form -->
    <?php if (isset($_SESSION['user'])) : ?>
        <div class="mt-4">
            <h4>Leave a Comment</h4>
            <form method="POST" action="/comment/add">
                <textarea class="form-control mb-3" name="comment" placeholder="Write your comment..." rows="3" required></textarea>
                <input type="hidden" name="post_id" value="<?= $id; ?>">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    <?php else : ?>
        <p class="mt-4">Please <a href="/login">log in</a> to leave a comment.</p>
    <?php endif; ?>
</div>
<?php require 'parts/footer.php'; ?>
