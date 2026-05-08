<?php
    require_once '../../../emailVerification.php';
    require_once '../../../Jwt.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    function logIn(PDO $pdo){

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        try{
            $query = 'SELECT pat_password FROM Patient WHERE email = ?';
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
            if(!sendVerificationEmail($email, $verificationCode)){
                throw new CouldNotSendEmailException();
            };

            $jwt = new JwToken();

            // only for a shor time store email to find user again
            $_SESSION['emial_jwt'] = $jwt->generateJwt($email, '', 181);

            // Store verification code in session as JWT for later use.
            // I set timer for 3 minutes and 1 second, extra time for page reload.
            $_SESSION['verification_code_jwt'] = $jwt->generateJwt($verificationCode, '', 181);

            return true;
        }catch(PDOException $e){
            throw new UserNotFoundException();
        }
    }