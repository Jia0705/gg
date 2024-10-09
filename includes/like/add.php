<?php

// connect to the database
$database = connectToDB();

// get data from the form using $_POST
$post_id = $_POST["post_id"];
$action = $_POST["action"]; // 1 for like, 0 for dislike

// error checking
// make sure all the fields are not empty
if (empty($post_id) || !isset($action)) {
    setError("Invalid request.", "/post?id=" . $post_id);
}

// check if the user has already liked or disliked this post
$sql = "SELECT * FROM likes WHERE post_id = :post_id AND user_id = :user_id";
$query = $database->prepare($sql);
$query->execute([
    'post_id' => $post_id,
    'user_id' => $_SESSION['user']['id']
]);
$like = $query->fetch();

// update, insert, or delete like/dislike
if ($like) {
    if ($like['type'] == $action) {
        // user is cancel like/dislike
        $sql = "DELETE FROM likes WHERE id = :id";
        $query = $database->prepare($sql);
        $query->execute([
            'id' => $like['id']
        ]);
    } else {
        // update the existing like/dislike with the new type
        $sql = "UPDATE likes SET type = :type WHERE id = :id";
        $query = $database->prepare($sql);
        $query->execute([
            'type' => $action,
            'id' => $like['id']
        ]);
    }
} else {
    // insert a new like/dislike
    $sql = "INSERT INTO likes (`post_id`, `user_id`, `type`) VALUES (:post_id, :user_id, :type)";
    $query = $database->prepare($sql);
    $query->execute([
        'post_id' => $post_id,
        'user_id' => $_SESSION['user']['id'],
        'type' => $action
    ]);
}

// redirect back to the post page
header("Location: /post?id=" . $post_id);
exit;
