<?php

$database = connectToDB(); 

// get the form data
$title = $_POST["title"];
$content = $_POST["content"];
$user_id = $_SESSION["user"]["id"];

// error checking
// make sure all the fields are not empty
if ( empty( $title ) || empty( $content ) ) {
    setError( "All the fields are required.", "/manage-posts-add" );
}

// Image upload
$image = null; // Default image is null
if (!empty($_FILES['image']['name'])) { // Check if image is uploaded
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    
    // Check if the file type is allowed
    $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if (in_array($imageFileType, $allowedFileTypes) && $_FILES["image"]["size"] <= 2000000) {
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        $image = $targetFile;
    }
}


// insert data into the database
$sql = "INSERT INTO posts (`title`, `content`, `user_id`, `image`) VALUES (:title, :content, :user_id, :image)";
// prepare (put everything into the bowl)
$query = $database->prepare($sql);
// execute (cook it)
$query->execute([
    'title' => $title,
    'content' => $content,
    'user_id' => $user_id,
    'image' => $image
]);

// redirect to manage posts
$_SESSION["success"] = "Post added successfully.";
header("Location: /manage-posts");
exit;