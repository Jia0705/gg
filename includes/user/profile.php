<?php

// 1. connect to database
$database = connectToDB();

// 2. get all the data from the form using $_POST
$name = $_POST["name"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];
$user_id = $_SESSION["user"]["id"];

/*
    3. do error checking 
    - all the fields are filled 
    - password and confirm password must be the same
*/
if (empty($name)) {
    setError("Name cannot be empty.", '/manage-users-profile');
    exit; 
} else if (!empty($password) && $password !== $confirm_password) {
    setError("Passwords do not match.", '/manage-users-profile');
    exit; 
}

// 4. update the user data
if (!empty($password)) {
    // 4.1 - sql 
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // 4.2
    $sql = "UPDATE users SET name = :name, password = :password WHERE id = :user_id";
    $query = $database->prepare($sql);
    // 4.3 - execute
    $query->execute([
        'name' => $name,
        'password' => $hashed_password,
        'user_id' => $user_id
    ]);
} else {
    // 4.1 - sql 
    $sql = "UPDATE users SET name = :name WHERE id = :user_id";
    // 4.2
    $query = $database->prepare($sql);
    // 4.3 - execute
    $query->execute([
        'name' => $name,
        'user_id' => $user_id
    ]);
}

// data with the new name
$_SESSION['user']['name'] = $name;

// 5. redirect back to manage profile with success message
$_SESSION["success"] = "Profile updated successfully.";
header("Location: /manage-users-profile");
exit;
