<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class JWToken {
    private static $secretKey = 'TUMTUMTUMTUMTUMTUMTUMTUMTUMTUMopehr0329uhfdjğc*329rh23ğ08ruh...';

    function generateJwt(int | string $user_id, string $user_role, ?int $exp_time = null) : string {
        $payload = [
            'user_id' => $user_id,
            'role' => $user_role,
            'iat' => time()
        ];

        // If you don't write exp time, it will be infinite
        if ($exp_time !== null) {
            $payload['exp'] = time() + $exp_time;
        }

        return JWT::encode($payload, self::$secretKey, 'HS256');
    }

    // check if key is expired
    function isExpired(string $token) : bool {
        try {
            JWT::decode($token, new Key(self::$secretKey, 'HS256'));
            return false;
        } catch (Exception $e) {
            return true;
        }
    }

    function openToken(string $token) : stdClass{
        try{
            return JWT::decode($token, new Key(self::$secretKey, 'HS256'));
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}