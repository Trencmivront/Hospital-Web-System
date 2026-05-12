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
            $query = 'SELECT pat_password FROM Patient WHERE email = :email';
            $statement = $pdo->prepare($query);
            $statement->execute(['email' => $email]);

            $user = $statement->fetch();
            
            // if user not found
            if (!$user) {
                throw new UserNotFoundException();
            }

            // if user entered wrong password
            if(!password_verify($password, $user['pat_password'])){
                throw new IncorrectPasswordException();
            }

            $jwt = new JwToken();

            // only for a shor time store email to find user again
            // we will give extra 3 minute for user to press "resend code" button
            // after time passed, kill user
            $_SESSION['email_jwt'] = $jwt->generateJwt($email, '', 300);

            // this feels so stupid
            sendCode($_SESSION['email_jwt']);

            return true;
        }catch(PDOException $e){
            throw new CouldNotRetrievePatientDataException();
        }
    }

    function sendCode(string $email_jwt) : string{

        $jwt = new JWToken();
        // Do you have any idea of why am I doing it like this?
        // Simply because I want to reach email while it is stored as jwt.
        $email = $jwt->openToken($email_jwt)->user_id;
        // I also want to regenerate it and give user more chance because I am stupid
        $_SESSION['email_jwt'] = $jwt->generateJwt($email, '', 300);

        $verificationCode = generateVerificationCode();

        // if email is wrong
        $isEmailSent = sendVerificationEmail($email, $verificationCode);
        if(!$isEmailSent){
            throw new CouldNotSendEmailException();
        }
        // Store code in the session to check whether user will enter correct or not
        $_SESSION['verification_code_jwt'] = $jwt->generateJwt($verificationCode, '', 121);

        return "Code sent.";
    }