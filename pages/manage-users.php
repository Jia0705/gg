<?php 

  // check if user is logged in or not
  checkIfuserIsNotLoggedIn();

  // check if the user is admin or not
  checkIfIsNotAdmin();

  // 1. connect to the database
  $database = connectToDB();
  
  // 2. get all the users
  // 2.1
  $sql = "SELECT * FROM users";
  // 2.2
  $query = $database->prepare( $sql );
  // 2.3
  $query->execute();
  // 2.4
  $users = $query->fetchAll();
  
  require "parts/header.php"; 
?>
<div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Manage Users</h1>
        <div class="text-end">
          <a href="/manage-users-add" class="btn btn-primary btn-sm">Add New User</a>
        </div>
      </div>
      <div class="card mb-2 p-4">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Role</th>
              <th scope="col" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- 3. use foreach to display all the users -->
             <?php foreach ($users as $index => $user) :?>
            <tr>
              <th scope="row"><?= $user['id']?></th>
              <td><?= $user['name']?></td>
              <td><?= $user['email']?></td>
              <td>
                <?php if ( $user['role'] == 'admin' ) : ?>
                  <span class="badge bg-success">Admin</span>
                <?php endif; ?>
                <?php if ( $user['role'] == 'editor' ) : ?>
                  <span class="badge bg-info">Editor</span>
                <?php endif; ?>
                <?php if ( $user['role'] == 'user' ) : ?>
                  <span class="badge bg-primary">User</span>
                <?php endif; ?>
              </td>
              <td class="text-end">
                <div class="buttons">
                  <a href="/manage-users-edit?id=<?= $user['id']; ?>" class="btn btn-success btn-sm me-2"><i class="bi bi-pencil"></i></a>
                  <a href="/manage-users-changepwd?id=<?= $user['id']; ?>" class="btn btn-warning btn-sm me-2"><i class="bi bi-key"></i></a>

                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-user-<?= $user['id']; ?>">
                    <i class="bi bi-trash"></i>
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="delete-user-<?= $user['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabdel">Delete User: <?= $user['name']; ?></h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                          This action cannot be reversed.
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <form method="POST" action="/user/delete">
                            <input type="hidden" name="id" value="<?= $user['id']; ?>" />
                            <button class="btn btn-danger"> <i class="bi bi-trash"></i> Delete Now</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="text-center">
        <a href="/dashboard" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Dashboard</a
        >
      </div>
    </div>
    <?php require 'parts/footer.php';
