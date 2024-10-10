<?php 
require "parts/header.php"; 

// Check if a user is logged in
checkIfuserIsNotLoggedIn();
?>
<div class="container my-5">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <h1 class="h1 mb-4 text-center">Contact Us</h1>

      <!-- Display any success or error messages -->
      <?php require "parts/success_message.php"?>
      
      <?php require "parts/error_message.php"?>

      <!-- Contact form -->
      <form action="/contact/submit" method="POST">
        <div class="mb-3">
          <label for="name" class="form-label">Your Name</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Your Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Your Message</label>
          <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
      </form>
    </div>
  </div>
</div>

<div class="text-center mt-5">
  <a href="/" class="btn btn-link btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<?php require "parts/footer.php"; ?>
