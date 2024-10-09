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

$sql = "SELECT * FROM comments WHERE id = :comment_id AND user_id = :user_id";
// prepare (put everything into the bowl)
$query = $database->prepare($sql);
// execute (cook it)
$query->execute([
    'comment_id' => $comment_id,
    'user_id' => $user_id
]);
$comment = $query->fetch();

if (!$comment) {
    setError( "You cannot edit this comment.", "/post?id=" . $post_id);
}

// update comment form processing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updated_comment = $_POST["comment"];

// error checking
// make sure all the fields are not empty
    if (empty($updated_comment)) {
        setError( "All the fields are required.", "/comment/edit?id=" . $comment_id . "&post_id=" . $post_id);
    }

    $sql = "UPDATE comments SET comment = :comment WHERE id = :id";
// prepare (put everything into the bowl)
    $query = $database->prepare($sql);
// execute (cook it)
    $query->execute([
        'comment' => $updated_comment,
        'id' => $comment_id
    ]);

    header("Location: /post?id=" . $post_id);
    exit;
}

?>

<!-- comment Form -->
<?php require 'parts/header.php'; ?>
<div class="container my-5" style="max-width: 600px;">
    <h1>Edit Comment</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="comment" class="form-label">Edit Your Comment</label>
            <textarea class="form-control" id="comment" name="comment" rows="3" required><?=$comment['comment']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Comment</button>
    </form>
</div>
<?php require 'parts/footer.php'; ?>
