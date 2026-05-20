<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class Login {
    function execute(PDO $pdo) : bool {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);

        if(empty($username)){
            throw new NullInputsException();
        }
        if(empty($password)){
            throw new NullInputsException();
        }

        try{
            $query = 'SELECT admin_id, ad_password, usr_role FROM Admin WHERE username = :username';
            $statement = $pdo->prepare($query);
            $statement->execute(['username' => $username]);

            $admin = $statement->fetch();
            
            if (!$admin) {
                throw new UserNotFoundException();
            }

            if(!password_verify($password, $admin['ad_password'])){
                throw new IncorrectPasswordOrEmailException();
            }

            $jwt = new JWToken();
            
            // Admins get a 24-hour token (86400 seconds)
            $_SESSION['admin_jwt'] = $jwt->generateJwt($admin['admin_id'], $admin['usr_role'], 86400);
            
            return true;
        } catch(PDOException $e) {
            throw new CouldNotRetrieveAdminDataException();
        }
    }
}