<?php
    use FFI\Exception;
    require_once "./backend/Jwt.php";

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

        if ($submittedCode === $jwt->openToken($_SESSION['verification_code_jwt'])->verificationCode){
            
            // Clear verification data from session
            unset($_SESSION['verification_code_jwt']);

            $email = $jwt->openToken($_SESSION['email_jwt'])->email;

            try{
                $query = 'SELECT pat_password FROM Patient WHERE email = ?';
                $statement = $pdo->prepare($query);
                $statement->execute([$email]);

                // erase email right after we get patient data
                unset($_SESSION['email_jwt']);
                $user = $statement->fetch();

                $patient_id = $user['patient_id'];
                $usr_role = $user['usr_role'];

                // from now on, if this JWT is present, patient is logged in
                /* If present but could not be decoded, patient should be
                sent to the log in page */
                $_SESSION['patient_jwt'] = $jwt->generateJwt($patient_id, $usr_role, 3600);

            }catch(PDOException $e){
                throw new UserNotFoundException();
            }

            return true;
        }
        return false;
    }
