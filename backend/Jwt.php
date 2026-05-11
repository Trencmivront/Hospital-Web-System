<?php
require_once dirname(__FILE__) . '/../vendor/autoload.php';
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

    function openToken(string $token) : stdClass{
        return JWT::decode($token, new Key(self::$secretKey, 'HS256'));
    }
}