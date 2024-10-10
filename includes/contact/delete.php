<?php
// Check if user is logged in and if they are an admin
checkIfuserIsNotLoggedIn();

// Connect to the database
$database = connectToDB();

// Get the contact ID 
$id = $_POST["id"];

// Error checking
if (empty($id)) {
    setError("Invalid ID.", "/manage-contacts");
    exit;
}

// Delete the contact from the database
$sql = "DELETE FROM contacts WHERE id = :id";
$query = $database->prepare($sql);
$query->execute([
    'id' => $id
]);

// Set success message and redirect back to manage contacts page
$_SESSION['success'] = "Message deleted successfully.";
header("Location: /manage-contacts");
exit;
