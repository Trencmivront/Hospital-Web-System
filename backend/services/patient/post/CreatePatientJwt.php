<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

class CreatePatientJwt {
    function execute(PDO $pdo) : bool{

    if(isset($_SESSION['is_email_verified'])){
        if($_SESSION['is_email_verified'] == false){
            throw new Exception("Email Is Not Verified. Please verify your email first.");
        }
    }
    else {
        throw new UserIsNotAuthenticatedException();
    }
    
    $jwt = new JWToken();
    // take email from jwt
    $email = $jwt->openToken($_SESSION['email_jwt'])->user_id;
    // erase email from session
    unset($_SESSION['email_jwt']);

    try{
        // simply because I didn't want to store patient information before authentication with email
        $query = 'SELECT patient_id, usr_role FROM Patient WHERE email = ?';
        $statement = $pdo->prepare($query);
        $statement->execute([$email]);

        $user = $statement->fetch();

        $patient_id = $user['patient_id'];
        $usr_role = $user['usr_role'];

        // from now on, if this JWT is present, patient is logged in
        /* If present but could not be decoded, patient should be
        sent to the log in page */
        // If user choosed remember me option, we will create timeless jwt, until patient logs out
        if(isset($_SESSION['remember_me']) && $_SESSION['remember_me'] === true){
            $_SESSION['patient_jwt'] = $jwt->generateJwt($patient_id, $usr_role);
        }
        else{
            $_SESSION['patient_jwt'] = $jwt->generateJwt($patient_id, $usr_role, 3600);
        }

        unset($_SESSION['remember_me']);

        return true;
    }catch(PDOException $e){
        throw new UserNotFoundException();
    }
}
}
