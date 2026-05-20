<?php

use Firebase\JWT\ExpiredException;

require_once dirname(__FILE__) . "/../../patient/get/JWToken.php";

class Logout {
    function execute() : bool {

        if(!isset($_SESSION['admin_jwt'])){
            throw new UserIsNotAuthenticatedException();
        }

        $jwt = new JWToken();

        try{
            $jwtContents = $jwt->openToken($_SESSION['admin_jwt']);
            $admin_id = $jwtContents->user_id;
            $admin_role = $jwtContents->role;
            if((empty($admin_id) || empty($admin_role)) || $admin_role !== 'ADMIN'){
                throw new UserIsNotAuthenticatedException();
            }
        }catch(ExpiredException $e){
            throw new UserIsNotAuthenticatedException();
        }

        // Erase all session content
        $_SESSION = array();

        // Erase session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // destroy session on the backend
        session_destroy();
        return true;
    }
}