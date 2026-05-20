<?php
class LogIn {
    function execute(PDO $pdo){
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $email = $data['email'];
        $password = $data['password'];
        $remember_me = $data['remember_me'];

        $email = htmlspecialchars($email);
        $password = htmlspecialchars($password);
        $remember_me = htmlspecialchars($remember_me);

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
                throw new IncorrectPasswordOrEmailException();
            }

            // if user entered wrong password
            if(!password_verify($password, $user['pat_password'])){
                throw new IncorrectPasswordOrEmailException();
            }

            $jwt = new JwToken();

            // only for a shor time store email to find user again
            // we will give extra 3 minute for user to press "resend code" button
            // after time passed, kill user
            $_SESSION['email_jwt'] = $jwt->generateJwt($email, '', 300);
            // also store remember_me if user wants to be Memorized By The System
            $_SESSION['remember_me'] = $remember_me;
            
            $sendCode = new SendCode();
            // this feels so stupid
            $sendCode->execute($_SESSION['email_jwt']);

            return true;
        }catch(PDOException $e){
            throw new CouldNotRetrievePatientDataException();
        }
    }
}