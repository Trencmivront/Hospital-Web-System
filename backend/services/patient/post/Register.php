<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
class Register {
    function execute(PDO $pdo){
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $tc_no = $data['tc_no'];
        $birth_date = $data['birth_date'];
        $gender_name = $data['gender_name'];
        $blood_id = $data['blood_id'];
        $phone_num = $data['phone_num'];
        $email = $data['email'];
        $password = $data['password'];

        if(empty($first_name)){
            throw new NullFirstNameException();
        }
        if(empty($last_name)){
            throw new NullLastNameException();
        }
        if(empty($tc_no)){
            throw new NullTcNoException();
        }
        if(empty($birth_date)){
            throw new NullBirthDateException();
        }
        if(empty($gender_name)){
            throw new NullGenderNameException();
        }
        if(empty($blood_id)){
            throw new NullBloodIdException();
        }
        if(empty($phone_num)){
            throw new NullPhoneNumException();
        }
        if(empty($email)){
            throw new NullEmailException();
        }
        if(empty($password)){
            throw new NullPasswordException();
        }

        try{
            // check if email exists
            $query = 'SELECT patient_id FROM Patient WHERE email = :email';
            $statement = $pdo->prepare($query);
            $statement->execute(['email' => $email]);

            if($statement->fetch()){
                throw new EmailAlreadyExistsException();
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = 'INSERT INTO Patient (first_name, last_name, tc_no, birth_date, gender_name, blood_id, phone_num, email, is_email_verified, pat_password, usr_role)
                      VALUES (:first_name, :last_name, :tc_no, :birth_date, :gender_name, :blood_id, :phone_num, :email, false, :pat_password, \'PATIENT\')';
            $statement = $pdo->prepare($query);
            $statement->execute([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'tc_no' => $tc_no,
                'birth_date' => $birth_date,
                'gender_name' => $gender_name,
                'blood_id' => $blood_id,
                'phone_num' => $phone_num,
                'email' => $email,
                'pat_password' => $hashed_password
            ]);

            $jwt = new JwToken();

            // only for a short time store email to find user again
            // we will give extra 3 minute for user to press "resend code" button
            // after time passed, kill user
            $_SESSION['email_jwt'] = $jwt->generateJwt($email, '', 300);
            
            $sendCode = new SendCode();
            // this feels so stupid
            $sendCode->execute($_SESSION['email_jwt']);

            return true;
        }catch(PDOException $e){
            throw new CouldNotRetrievePatientDataException();
        }
    }
}