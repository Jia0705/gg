<?php

    // connect to database 
    $database = connectToDB();

    // get all the data from the form using $_POST
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $role = $_POST["role"];
    

    /* 
        error checking
        - make sure all the fields are not empty
        - make sure the password is match
        - make sure the password length is at least 8 characters
        
    */
    if ( empty( $name ) || empty( $email ) || empty( $password ) || empty( $confirm_password )  || empty( $role) ) {
        setError( "All the fields are required.", '/manage-users-add' );
    } else if ( $password !== $confirm_password ) {
        //  make sure password is match
        setError( "The password is not match", '/manage-users-add' );
    } else if ( strlen( $password ) < 8 ) {
        // make sure the password length is at least 8 chars
        setError( "Your password must be at least 8 characters", '/manage-users-add' );
    } else {  

        // make sure the email entered does not exists yet
        $sql = "SELECT * FROM users where email = :email";
        $query = $database->prepare( $sql );
        $query->execute([
            'email' => $email
        ]);
        $user = $query->fetch(); // get only one row of data

        // create the user account. Remember to assign role to the user
        if ( $user ) {
            setError("The email provided has already been used.","/manage-users-add");
        } else {
            // create the user account
            // sql command (recipe)
            $sql = "INSERT INTO users (`name`,`email`,`password`,`role`) VALUES (:name, :email, :password, :role)";
            // prepare (put everything into the bowl)
            $query = $database->prepare( $sql );
            // execute (cook it)
            $query->execute([
                'name' => $name,
                'email' => $email,
                'password' => password_hash( $password, PASSWORD_DEFAULT ),
                'role' => $role
            ]);
        
        // redirect back to /manage-users page
        header("Location: /manage-users");
        exit;
    }
}
    
    
   
      
