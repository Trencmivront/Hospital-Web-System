<?php
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
        if (isset($_SESSION['registration_data'])) {
            $regData = $_SESSION['registration_data'];
            
            $query = 'INSERT INTO Patient (first_name, last_name, tc_no, birth_date, gender_name, blood_id, phone_num, email, is_email_verified, pat_password, usr_role, updated_at, created_at)
                      VALUES (:first_name, :last_name, :tc_no, :birth_date, :gender_name, :blood_id, :phone_num, :email, true, :pat_password, \'PATIENT\', NOW(), NOW())';
            $statement = $pdo->prepare($query);
            $statement->execute([
                'first_name' => $regData['first_name'],
                'last_name' => $regData['last_name'],
                'tc_no' => $regData['tc_no'],
                'birth_date' => $regData['birth_date'],
                'gender_name' => $regData['gender_name'],
                'blood_id' => $regData['blood_id'],
                'phone_num' => $regData['phone_num'],
                'email' => $regData['email'],
                'pat_password' => $regData['pat_password']
            ]);

            $patient_id = $pdo->lastInsertId();
            $usr_role = 'PATIENT';

            unset($_SESSION['registration_data']);
        } else {
            // simply because I didn't want to store patient information before authentication with email
            $query = 'SELECT patient_id, usr_role FROM Patient WHERE email = ?';
            $statement = $pdo->prepare($query);
            $statement->execute([$email]);

            $user = $statement->fetch();

            if (!$user) {
                throw new UserNotFoundException();
            }

            $patient_id = $user['patient_id'];
            $usr_role = $user['usr_role'];
        }

        // from now on, if this JWT is present, patient is logged in
        /* If present but could not be decoded, patient should be
        sent to the log in page */
        // If user choosed remember me option, we will create timeless jwt, until patient logs out
        if(isset($_SESSION['remember_me']) && $_SESSION['remember_me'] === "true"){
            $_SESSION['patient_jwt'] = $jwt->generateJwt($patient_id, $usr_role);
        }
        else{
            $_SESSION['patient_jwt'] = $jwt->generateJwt($patient_id, $usr_role, 3600);
        }

        unset($_SESSION['remember_me']);
        unset($_SESSION['is_email_verified']); // Clear verification status after use

        return true;
    }catch(PDOException $e){
        throw new CouldNotRetrievePatientDataException();
    }
}
}
