<?php

// connect to the database
$database = connectToDB();

// get form data
$post_id = $_POST["post_id"];
$user_id = $_SESSION["user"]["id"];
$comment = $_POST["comment"];

// error checking
// make sure all the fields are not empty
if (empty($post_id) || empty($user_id) || empty($comment)) {
    setError( "All the fields are required.", "/post?id=" . $post_id);
}

// insert comment into the database
$sql = "INSERT INTO comments (`post_id`, `user_id`, `comment`) VALUES (:post_id, :user_id, :comment)";
// prepare (put everything into the bowl)
$query = $database->prepare($sql);
// execute (cook it)
$query->execute([
    'post_id' => $post_id,
    'user_id' => $user_id,
    'comment' => $comment
]);

// redirect back to the post
header("Location: /post?id=" . $post_id);
exit;
