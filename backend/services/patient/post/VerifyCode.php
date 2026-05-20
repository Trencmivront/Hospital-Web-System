<?php
    use Firebase\JWT\ExpiredException;
class VerifyCode {
    function execute() : bool {
        $jwt = new JwToken();

        // getting json data
        $json = file_get_contents('php://input');
        $data = json_decode($json, true) ?? '';

        // clearing special characters
        $submittedCode = htmlspecialchars($data['code']);

        if (!isset($_SESSION['verification_code_jwt'])) {
            throw new Exception("Verification Code Does Not Exists", 400);
        }

        if(!isset($_SESSION['email_jwt'])){
            throw new Exception("Help, Thief!", 403);
        }

        try{
            $storedCode = $jwt->openToken($_SESSION['verification_code_jwt'])->user_id;
            if ($submittedCode === $storedCode){
                // Clear verification data from session
                unset($_SESSION['verification_code_jwt']);

                $_SESSION['is_email_verified'] = true;
                return true;
            }
            else{
                throw new IncorrectVerificationCodeException();
            }
        }catch(ExpiredException $e){
            throw new IncorrectVerificationCodeException();
        }
    }
}
