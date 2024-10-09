<?php

    // 1. connect to database
    $database = connectToDB();
    // 2. get all the data from the form using $_POST
    $name = $_POST["name"];
    $role = $_POST["role"];
    $id = $_POST["id"];
    // 3. do error checking - make sure all the fields are not empty
    if ( empty( $name ) || empty( $role ) ) {
        setError( "Please fill in the form.", '/manage-users-edit?id=' . $id );
    }
    // 4. update the user data
    
    // 4.1
    $sql = "UPDATE users SET name = :name, role = :role WHERE id = :id";
    // 4.2
    $query = $database->prepare( $sql );
    // 4.3
    $query->execute([
        'name' => $name,
        'role' => $role,
        'id' => $id
    ]);
    // 5. Redirect back to /manage-users
    header("Location: /manage-users");
    exit;