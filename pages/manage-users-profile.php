<?php

// Check if the user is logged in
checkIfuserIsNotLoggedIn();

// Connect to the database
$database = connectToDB();

// Load the existing data from the user
$user_id = $_SESSION['user']['id'];
// SQL command
$sql = "SELECT * FROM users WHERE id = :user_id";
// Prepare
$query = $database->prepare($sql);
// Execute
$query->execute(['user_id' => $user_id]);
// Fetch
$user = $query->fetch();

require "parts/header.php"; ?>

<div class="container mx-auto my-5" style="max-width: 700px;">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Manage User Profile</h1>
    </div>
    <div class="card mb-2 p-4">
        <?php require "parts/success_message.php"; ?>
        <?php require "parts/error_message.php"; ?>
        <form method="POST" action="/user/profile">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?=$user['name']; ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email (cannot be changed)</label>
                <input type="email" class="form-control" id="email" value="<?=$user['email']; ?>" disabled>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Leave blank to keep current password">
            </div>
            <div class="text-end">
                <input type="hidden" name="user_id" value="<?= $user['id']; ?>" />
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
        </form>
    </div>
    <div class="text-center">
        <a href="/dashboard" class="btn btn-link btn-sm"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
    </div>
</div>

<?php require 'parts/footer.php'; ?>
