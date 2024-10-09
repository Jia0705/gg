<?php

    $database = connectToDB();  

    // get all the data from the form using $_POST
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // error checking
    // make sure all the fields are not empty
    if ( empty( $name ) || empty( $email ) || empty( $password ) || empty( $confirm_password ) ) {
        setError( "All the fields are required.", '/signup' );
    } else if ( $password !== $confirm_password ) {
        //  make sure password is match
        setError( "The password is not match", '/signup' );
    } else if ( strlen( $password ) < 8 ) {
        // make sure the password length is at least 8 chars
        setError( "Your password must be at least 8 characters", '/signup' );
    } else {
        // make sure the email entered does not exists yet
        $sql = "SELECT * FROM users where email = :email";
        $query = $database->prepare( $sql );
        $query->execute([
            'email' => $email
        ]);
        $user = $query->fetch(); // get only one row of data

        if ( $user ) {
            setError("The email provided has already been used.","/signup");
        } else {
            // create the user account
            // sql command (recipe)
            $sql = "INSERT INTO users (`name`,`email`,`password`) VALUES (:name, :email, :password)";
            // prepare (put everything into the bowl)
            $query = $database->prepare( $sql );
            // execute (cook it)
            $query->execute([
                'name' => $name,
                'email' => $email,
                'password' => password_hash( $password, PASSWORD_DEFAULT )
            ]);

            $_SESSION["success"] = "Account has been created. Please login with your email and password.";
            header("Location: /login");
            exit;
        }
    }