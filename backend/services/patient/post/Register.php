<?php
class Register {
    function execute(PDO $pdo){
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $first_name = htmlspecialchars($data['first_name'] ?? '');
        $last_name = htmlspecialchars($data['last_name'] ?? '');
        $tc_no = htmlspecialchars($data['tc_no'] ?? '');
        $birth_date = htmlspecialchars($data['birth_date'] ?? '');
        $gender_name = htmlspecialchars($data['gender_name'] ?? '');
        $blood_id = htmlspecialchars($data['blood_id'] ?? '');
        $phone_num = htmlspecialchars($data['phone_num'] ?? '');
        $email = htmlspecialchars($data['email'] ?? '');
        $password = htmlspecialchars($data['password'] ?? '');

        if(empty($first_name)){
            throw new NullFirstNameException();
        }
        if(!is_string_text($first_name) || strlen($first_name) < 2){
            throw new InvalidFirstNameException();
        }

        if(empty($last_name)){
            throw new NullLastNameException();
        }
        if(!is_string_text($last_name) || strlen($last_name) < 2){
            throw new InvalidLastNameException();
        }

        if(empty($tc_no)){
            throw new NullTcNoException();
        }
        if(!is_string_number($tc_no) || strlen($tc_no) !== 11){
            throw new InvalidTcNoException();
        }

        if(empty($birth_date)){
            throw new NullBirthDateException();
        }

        if(empty($gender_name)){
            throw new NullGenderNameException();
        }
        // Map frontend gender selection to database allowed values ('M', 'F')
        if (strcasecmp($gender_name, 'Male') === 0) {
            $gender_name = 'M';
        } else if (strcasecmp($gender_name, 'Female') === 0) {
            $gender_name = 'F';
        }

        if(empty($blood_id)){
            throw new NullBloodIdException();
        }

        if(empty($phone_num)){
            throw new NullPhoneNumException();
        }
        if(!isValidPhoneNumber($phone_num)){
            throw new InvalidPhoneNumException();
        }

        if(empty($email)){
            throw new NullEmailException();
        }
        if(!isValidEmail($email)){
            throw new InvalidEmailException();
        }

        if(empty($password)){
            throw new NullPasswordException();
        }
        if((strlen($password) < 8) || (strlen($password) > 16)){
            throw new PasswordLengthException();
        }
        if(is_string_number($password) || is_string_text($password)){
            throw new WeakPasswordException();
        }

        try{
            // check if email or tc_no exists
            $query = 'SELECT email, tc_no FROM Patient WHERE email = :email OR tc_no = :tc_no';
            $statement = $pdo->prepare($query);
            $statement->execute(['email' => $email, 'tc_no' => $tc_no]);
            
            if($existingUser = $statement->fetch()){
                if ($existingUser['email'] === $email) {
                    throw new EmailAlreadyExistsException();
                }
                if ($existingUser['tc_no'] === $tc_no) {
                    throw new TcNoAlreadyExistsException();
                }
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Store registration data in session to be inserted after verification
            $_SESSION['registration_data'] = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'tc_no' => $tc_no,
                'birth_date' => $birth_date,
                'gender_name' => $gender_name,
                'blood_id' => $blood_id,
                'phone_num' => $phone_num,
                'email' => $email,
                'pat_password' => $hashed_password
            ];

            $jwt = new JwToken();

            // only for a short time store email to find user again
            // we will give extra 3 minute for user to press "resend code" button
            // after time passed, kill user
            $_SESSION['email_jwt'] = $jwt->generateJwt($email, '', 181);
            
            $sendCode = new SendCode();
            // this feels so stupid
            $sendCode->execute($_SESSION['email_jwt']);

            return true;
        }catch(PDOException $e){
            throw new CouldNotRetrievePatientDataException();
        }
    }
}