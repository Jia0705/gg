<?php 
  // check if user is logged in or not
  checkIfuserIsNotLoggedIn();

  require "parts/header.php"; ?>

<div class="container mx-auto my-5" style="max-width: 800px;">
  <h1 class="h1 mb-4 text-center">Dashboard</h1>
  <?php require "parts/success_message.php"; ?>

  <div class="row">
    <!-- Manage Posts-->
    <div class="col">
      <div class="card mb-2">
        <div class="card-body">
          <h5 class="card-title text-center">
            <div class="mb-1">
              <i class="bi bi-pencil-square" style="font-size: 3rem;"></i>
            </div>
            Manage Posts
          </h5>
          <div class="text-center mt-3">
            <a href="/manage-posts" class="btn btn-primary btn-sm">Access</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Manage Users (Admin Only) -->
    <?php if ($_SESSION['user']['role'] == 'admin') : ?>
    <div class="col">
      <div class="card mb-2">
        <div class="card-body">
          <h5 class="card-title text-center">
            <div class="mb-1">
              <i class="bi bi-people" style="font-size: 3rem;"></i>
            </div>
            Manage Users
          </h5>
          <div class="text-center mt-3">
            <a href="/manage-users" class="btn btn-primary btn-sm">Access</a>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- Manage Profile -->
    <div class="col">
      <div class="card mb-2">
        <div class="card-body">
          <h5 class="card-title text-center">
            <div class="mb-1">
              <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
            </div>
            Manage Profile
          </h5>
          <div class="text-center mt-3">
            <a href="/manage-users-profile" class="btn btn-primary btn-sm">Access</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Manage Contacts (Admin Only) -->
    <?php if ($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'editor') : ?>
    <div class="col">
      <div class="card mb-2">
        <div class="card-body">
          <h5 class="card-title text-center">
            <div class="mb-1">
              <i class="bi bi-envelope" style="font-size: 3rem;"></i>
            </div>
              Feedback
          </h5>
          <div class="text-center mt-3">
            <a href="/manage-contacts" class="btn btn-primary btn-sm">Access</a>
          </div>
        </div>
      </div>
    </div>
    <?php else: ?>
    <!-- Contact Form -->
    <div class="col">
      <div class="card mb-2">
        <div class="card-body">
          <h5 class="card-title text-center">
            <div class="mb-1">
              <i class="bi bi-envelope" style="font-size: 3rem;"></i>
            </div>
              Contacts
          </h5>
          <div class="text-center mt-3">
            <a href="/contact" class="btn btn-primary btn-sm">Access</a>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

  </div>

  <div class="mt-4 text-center">
    <a href="/" class="btn btn-link btn-sm">
      <i class="bi bi-arrow-left"></i> Back
    </a>
  </div>
</div>

<?php require 'parts/footer.php'; ?>
