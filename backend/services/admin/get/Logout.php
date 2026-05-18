<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

class Logout {
    function execute() : bool {
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