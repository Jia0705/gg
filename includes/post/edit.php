<?php

// 1. connect to the database
$database = connectToDB();

// 2. get all the data from the form using $_POST
$post_id = $_POST["id"];
$title = $_POST["title"];
$content = $_POST["content"];
$status = $_POST["status"];

// 3. do error checking - make sure all the fields are not empty
if (empty($title) || empty($content) || empty($status)) {
    setError("Please fill in everything.", '/manage-posts-edit?id=' . $post_id);
    exit;
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
        // Delete the old image if a new one is uploaded
        $sql = "SELECT image FROM posts WHERE id = :id";
        $query = $database->prepare($sql);
        $query->execute(['id' => $post_id]);
        $oldPost = $query->fetch();
        if (!empty($oldPost['image']) && file_exists($oldPost['image']) && $oldPost['image'] !== 'null') {
            unlink($oldPost['image']);
        }
        // Move the new image to the target directory
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        $image = $targetFile;
    } else {
        setError("Invalid file type or file too large. Please upload a valid image.", '/manage-posts-edit?id=' . $post_id);
        exit;
    }
}

// 4. update the post 
// Prepare the base SQL query for updating
$sql = "UPDATE posts SET `title` = :title, `content` = :content, `status` = :status, `posted_on` = NOW()";

// Include the image in the update if one is provided
if ($image) {
    $sql .= ", `image` = :image";
}
$sql .= " WHERE `id` = :id";

// Prepare and execute the query
$query = $database->prepare($sql);
$params = [
    'title' => $title,
    'content' => $content,
    'status' => $status,
    'id' => $post_id
];
if ($image) {
    $params['image'] = $image;
}
$query->execute($params);

// 5. Redirect back to /manage-posts
$_SESSION["success"] = "Post updated successfully.";
header("Location: /manage-posts");
exit;
