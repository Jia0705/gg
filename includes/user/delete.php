<?php

    // 1. connect to Database
    $database = connectToDB();

    // 2. get the user_id from the form
    $user_id = $_POST["id"];

    // 3. delete the user
    // 3.1
    $sql = "DELETE FROM users where id = :id";
    // 3.2
    $query = $database->prepare( $sql );
    // 3.3
    $query->execute([
        'id' => $user_id
    ]);

    // 4. redireact to manage users
    header("Location: /manage-users");
    exit;