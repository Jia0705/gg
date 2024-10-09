<?php

    // 1. connect to database
    $database = connectToDB();
    // 2. load the "publish" posts data
    $sql = "SELECT 
                posts.id, posts.title, posts.content, posts.status, posts.user_id, posts.image, users.name
                FROM posts 
                JOIN users 
                ON posts.user_id = users.id 
                WHERE posts.status = 'publish'";
    $query = $database->prepare($sql);
    $query->execute();
    $posts = $query->fetchAll();

require "parts/header.php"; ?>
<div class="container my-5">
    <h1 class="h1 mb-4 text-center">COOL BLOG</h1>
    <div class="row">
        <!--  foreach all the posts -->
        <?php foreach ($posts as $post) : ?> 
            <div class="col-md-4 mb-4">
                <div class="card">
                    <?php if (!empty($post['image'])) : ?>
                        <img src="<?= $post['image']; ?>" class="card-img-top" alt="Post Image">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= $post['title']; ?></h5>
                        <p class="card-text">Author: <?=$post['name']; ?></p>
                        <div class="text-end">
                            <a href="/post?id=<?= $post['id']; ?>" class="btn btn-primary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-4 d-flex justify-content-center gap-3">
    <?php if (isset($_SESSION['user'])) : ?>
        <!-- show dashboard and logout link if user is logged in -->
        <a href="/dashboard" class="btn btn-link btn-sm">Dashboard</a>
        <a href="/logout" class="btn btn-link btn-sm">Logout</a>
    <?php else : ?>
        <!-- show login and signup link if user is not logged in -->
        <a href="/login" class="btn btn-link btn-sm">Login</a>
        <a href="/signup" class="btn btn-link btn-sm">Sign Up</a>
    <?php endif; ?>
    </div>
</div>
<?php require 'parts/footer.php'; ?>
