<?php 

  // check if user is logged in or not
  checkIfuserIsNotLoggedIn();

  // check if the user is admin or not
  checkIfIsNotAdmin();

require "parts/header.php"; ?>
<div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Add New User</h1>
      </div>
      <div class="card mb-2 p-4">
        <!--
        1. form method and action
        2. field's name
        3. display error message
        -->
        <?php require "parts/error_message.php"?>
        <form action="/user/add" method="post">
          <div class="mb-3">
            <div class="row">
              <div class="col">
                <label for="name" class="form-label" >Name</label>
                <input type="text" name="name" class="form-control" id="name" />
              </div>
              <div class="col">
                <label for="email" class="form-label" >Email</label>
                <input name="email" type="email" class="form-control" id="email" />
              </div>
            </div>
          </div>
          <div class="mb-3">
            <div class="row">
              <div class="col">
                <label for="password" class="form-label" >Password</label>
                <input type="password"  name="password" class="form-control" id="password" />
              </div>
              <div class="col">
                <label for="confirm-password" class="form-label"
                  >Confirm Password</label
                >
                <input
                  type="password"
                  class="form-control"
                  id="confirm-password"
                  name="confirm_password"
                />
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" class="form-control" id="role">
              <option value="">Select an option</option>
              <option value="user">User</option>
              <option value="editor">Editor</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Add</button>
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