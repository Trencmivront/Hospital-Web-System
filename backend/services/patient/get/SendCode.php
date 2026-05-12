<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

class SendCode {
    function execute(string $email_jwt) : string{

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
}