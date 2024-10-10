<?php 

  // check if user is logged in or not
  checkIfuserIsNotLoggedIn();

  // 1. connect to the database
  $database = connectToDB();
  
  // 2. get all the contact messages
  // 2.1
  $sql = "SELECT contacts.id, contacts.name, contacts.email, contacts.message 
          FROM contacts";
  // 2.2
  $query = $database->prepare( $sql );
  // 2.3
  $query->execute();
  // 2.4
  $contacts = $query->fetchAll();
  
  require "parts/header.php"; 
?>
<div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Manage Messages</h1>
      </div>
      <div class="card mb-2 p-4">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Message</th>
              <th scope="col" class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- 3. use foreach to display all the contact messages -->
             <?php foreach ($contacts as $contact) :?>
            <tr>
              <th scope="row"><?= $contact['id']?></th>
              <td><?= $contact['name']?></td>
              <td><?= $contact['email']?></td>
              <td><?= $contact['message']?></td>
              <td class="text-end">
                <div class="buttons">
                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-contact-<?= $contact['id']; ?>">
                    <i class="bi bi-trash"></i>
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="delete-contact-<?= $contact['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Contact: <?= $contact['name']; ?></h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                          This action cannot be reversed. Are you sure you want to delete this contact message?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <form method="POST" action="/contact/delete">
                            <input type="hidden" name="id" value="<?= $contact['id']; ?>" />
                            <button class="btn btn-danger"><i class="bi bi-trash"></i> Delete Now</button>
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
        <a href="/dashboard" class="btn btn-link btn-sm"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
      </div>
    </div>
    <?php require 'parts/footer.php'; ?>
