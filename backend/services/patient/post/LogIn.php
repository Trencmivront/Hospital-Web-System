<?php
    require_once dirname(__FILE__) . "/../../../emailVerification.php";
    require_once dirname(__FILE__) . "/../../../JWToken.php";
    require_once dirname(__FILE__) . "/../../../SendCode.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
class LogIn {
    function execute(PDO $pdo){
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
            
            $sendCode = new SendCode();
            // this feels so stupid
            $sendCode->execute($_SESSION['email_jwt']);

            return true;
        }catch(PDOException $e){
            throw new CouldNotRetrievePatientDataException();
        }
    }
}