<?php

// connect to the database
$database = connectToDB();

// get the comment ID from the URL
$comment_id = $_GET["id"];
$post_id = $_GET["post_id"];
$user_id = $_SESSION["user"]["id"];

// error checking
// make sure all the fields are not empty
if (empty($comment_id) || empty($user_id) || empty($post_id)) {
    setError( "All the fields are required.", "/post?id=" . $post_id);
}

// delete the comment from the database
$sql = "DELETE FROM comments WHERE id = :comment_id AND user_id = :user_id";
// prepare (put everything into the bowl)
$query = $database->prepare($sql);
// execute (cook it)
$query->execute([
    'comment_id' => $comment_id,
    'user_id' => $user_id
]);

// redirect back to the post
header("Location: /post?id=" . $post_id);
exit;
