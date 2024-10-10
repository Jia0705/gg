<?php
// connect to the database
$database = connectToDB();

// get form data
$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];

// error checking
if (empty($name) || empty($email) || empty($message)) {
    setError("All fields are required.", "/contact");
    exit;
}

// insert the contact message into the database
$sql = "INSERT INTO contacts (`name`, `email`, `message`) VALUES (:name, :email, :message)";
$query = $database->prepare($sql);
$query->execute([
    'name' => $name,
    'email' => $email,
    'message' => $message
]);

// set success message and redirect
$_SESSION['success'] = "Thank you for your message!";
header("Location: /contact");
exit;
