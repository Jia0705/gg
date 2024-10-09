<?php if ( isset( $_SESSION["error"] ) ) : ?>
    <div class="alert alert-danger" role="alert">
    <?= $_SESSION["error"]; ?>
    <?php 
        // remove error after it's shown
        unset( $_SESSION["error"] ); 
    ?>
    </div>
<?php endif; ?>