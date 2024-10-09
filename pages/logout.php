<?php

    // remove user session
    unset( $_SESSION['user'] );
    
    // redirect the user back to home page
    header("Location: /");
    exit;