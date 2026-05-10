<?php
    use FFI\Exception;
    require_once dirname(__FILE__) . "/../../../Jwt.php";

// if session does not exists, create one
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    function verifyCode(PDO $pdo) : bool {

        $jwt = new JwToken();
        // user's input
        $submittedCode = $_POST['verification_code'] ?? '';

        if (!isset($_SESSION['verification_code_jwt'])) {
            throw new Exception("Verification Code Does Not Exists");
        }

        if(!isset($_SESSION['email_jwt'])){
            throw new Exception("Help, Thief!");
        }

        if ($submittedCode === $jwt->openToken($_SESSION['verification_code_jwt'])->user_id){
            // Clear verification data from session
            unset($_SESSION['verification_code_jwt']);

            $_SESSION['is_email_verified'] = true;
            return true;
        }
        return false;
    }
