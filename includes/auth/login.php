<?php

    $database = connectToDB();  

    // get all the data from the form using $_POST
    $email = $_POST["email"];
    $password = $_POST["password"];

    // error checking
    if ( empty( $email ) || empty( $password ) ) {
        setError( "All the fields are required.", "/login" );
    } else {
        // retrieve the user data from your users table using the email provided by the user
        //  sql command (recipe)
        $sql = "SELECT * FROM users WHERE email = :email";
        // prepare
        $query = $database->prepare($sql);
        // execute
        $query->execute([
            'email' => $email
        ]);
        // fetch 
        $user = $query->fetch(); // get only one row of data

        if ( $user ) {
            // verify the password
            if ( password_verify( $password, $user['password'] ) ) {
                // if password is correct, login the user
                $_SESSION['user'] = $user;

                // set success message
                $_SESSION["success"] = "Welcome back! How can I help you today?";

                // redirect back to dashboard
                header("Location: /dashboard");
                exit;
            } else {
                setError( "The password provided is incorrect", "/login" );
            }
        } else {
            setError( "The email provided does not exists", "/login" );
        }
    }