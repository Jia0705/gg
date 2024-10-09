<?php 

  // check if user is logged in or not
  checkIfuserIsNotLoggedIn();

  // check if the user is admin or not
  checkIfIsNotAdmin();

  // get the id from the URL /manage-users.edit?id=1
  $id = $_GET['id'];

  // connect to the database
  $database = connectToDB();

  // load the existing data from the user
  // sql command
  $sql = "SELECT * FROM users WHERE id = :id";
  // prepare
  $query = $database->prepare($sql);
  // execute
  $query->execute([
    'id' => $id
  ]);
  // fetch
  $user = $query->fetch(); // get only one row of data

  /*
    name - $user['name']
    email - $user['email']
    role - $user['role']
  */

require "parts/header.php"; ?>
<div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Edit User</h1>
      </div>
      <div class="card mb-2 p-4">
        <!--
        Requirements:
        - [DONE] setup the form with action route and method
        - [DONE] Add names into the fields
        - [DONE] setup a hidden input for the $user['id']
        - [DONE] display the error message
        -->
        <form method="POST" action="/user/edit">
          <?php require "parts/error_message.php"?>
          <div class="mb-3">
            <div class="row">
              <div class="col">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>" />
              </div>
              <div class="col">
                <label for="email" class="form-label">Email</label>
                <input 
                  type="email" 
                  class="form-control" 
                  id="email" 
                  value="<?= $user['email']; ?>"
                  disabled 
                  />
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role">
              <option value="">Select an option</option>

              <?php if ( $user['role'] == 'user' ) : ?>
                <option value="user" selected>User</option>
              <?php else: ?>
                <option value="user">User</option>
              <?php endif; ?>

              <option value="editor" <?= $user['role'] == 'editor' ? "selected" : "" ?>>Editor</option>

              <?php if ( $user['role'] == 'admin' ) : ?>
                <option value="admin" selected>Admin</option>
              <?php else: ?>
                <option value="admin">Admin</option>
              <?php endif; ?>

            </select>
          </div>
          <div class="d-grid">
            <input type="hidden" name="id" value="<?= $user["id"]; ?>" />
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
      <div class="text-center">
        <a href="/manage-users" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Users</a
        >
      </div>
    </div>
    <?php require 'parts/footer.php';