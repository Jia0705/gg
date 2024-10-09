<?php

$database = connectToDB();  

// get the post ID
$post_id = $_POST["id"];

// get the post to find image
$sql = "SELECT image FROM posts WHERE id = :id";

// prepare (put everything into the bowl)
$query = $database->prepare($sql);
// execute (cook it)
$query->execute([
    'id' => $post_id
]);
$post = $query->fetch();

if ($post) {
    // delete the image file 
    if (!empty($post['image']) && file_exists($post['image'])) {
        unlink($post['image']);
    }

    // delete the post from the database
    $sql = "DELETE FROM posts WHERE id = :id";
    $query = $database->prepare($sql);
    $query->execute(['id' => $post_id]);
}

// redirect back to /manage-posts page
$_SESSION["success"] = "Post deleted successfully.";
header("Location: /manage-posts");
exit;