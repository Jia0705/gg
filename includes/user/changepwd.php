<?php

    // connect to database
    $database = connectToDB();

    // get all the data from the form  using  $_POST
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $id = $_POST["id"];
    /* 
        do error checking 
        - all the fields are filled
        - password and confirm password is the same
    */

    if ( empty( $password ) || empty( $confirm_password ) ) {
        setError( "Please fill in all fields.", '/manage-users-changepwd?id=' . $id );
    } else if ( $password !== $confirm_password ) {
        setError( "Password must be the same.", '/manage-users-changepwd?id=' . $id);
    }

    // update the password. 
    // 4.1 - sql
    $sql = "UPDATE users SET password =:password WHERE id =:id";
    // 4.2 - prepare
    $query = $database -> prepare($sql);
    // 4.3 - execute - Remember hash the password before update
    $query->execute([
        'password' => password_hash( $password, PASSWORD_DEFAULT ),
        'id' => $id
    ]);
    // redirect back to /manage-users
    header("Location: /manage-users");
    exit;