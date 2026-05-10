<?php
    require_once dirname(__FILE__) . "/../../../emailVerification.php";
    require_once dirname(__FILE__) . "/../../../Jwt.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    function logIn(PDO $pdo){

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);


        $email = $data['email'];
        $password = $data['password'];

        if(empty($email)){
            throw new NullEmailException();
        }
        if(empty($password)){
            throw new NullPasswordException();
        }

        try{
            $query = 'SELECT pat_password FROM Patient WHERE email = (?)';
            $statement = $pdo->prepare($query);
            $statement->execute([$email]);

            $user = $statement->fetch();
            
            // if user not found
            if (!$user) {
                throw new UserNotFoundException();
            }

            // if user entered wrong password
            if(!password_verify($password, $user['pat_password'])){
                throw new IncorrectPasswordException();
            }

            $verificationCode = generateVerificationCode();

            // if email is wrong
            $isEmailSent = sendVerificationEmail($email, $verificationCode);
            if(!$isEmailSent){
                throw new CouldNotSendEmailException();
            };

            $jwt = new JwToken();

            // only for a shor time store email to find user again
            $_SESSION['email_jwt'] = $jwt->generateJwt($email, '', 181);

            // Store verification code in session as JWT for later use.
            // I set timer for 3 minutes and 1 second, extra time for page reload.
            $_SESSION['verification_code_jwt'] = $jwt->generateJwt($verificationCode, '', 181);

            return true;
        }catch(PDOException $e){
            throw new CouldNotRetrievePatientDataException();
        }
    }