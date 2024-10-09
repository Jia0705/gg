<?php

  // check if user is logged in or not
  checkIfuserIsNotLoggedIn();

  // check if the user is admin or not
  checkIfIsNotAdmin();

  //get the id from the URL /manage-users.edit?id=1
  $id = $_GET['id'];
?>

<?php require "parts/header.php"; ?>
<div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Change Password</h1>
      </div>
      <div class="card mb-2 p-4">
        <!--
        Requirements:
        - [DONE] setup the form with action route and method
        - [DONE] Add names into the fields
        - [DONE] setup a hidden input for the $user['id']
        - display the error message
        -->
        <form method="POST" action="/user/changepwd">
          <div class="mb-3">
          <?php require "parts/error_message.php"?>
            <div class="row">
              <div class="col">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" />
              </div>
              <div class="col">
                <label for="confirm-password" class="form-label"
                  >Confirm Password</label
                >
                <input
                  name="confirm_password"
                  type="password"
                  class="form-control"
                  id="confirm-password"
                />
              </div>
            </div>
          </div>

          <!-- hidden input field for id -->
          <input type="hidden" name="id" value="<?= $id; ?>">
    
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">
              Change Password
            </button>
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