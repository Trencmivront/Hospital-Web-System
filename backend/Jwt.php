<?php

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
    
    class JWToken{
        private $secretKey = 'TUMTUMTUMTUMTUMTUMTUMTUMTUMTUMopehr0329uhfdjğc*329rh23ğ08ruh
        cy93rhc29nry9pv4t651466,6,25bww5y**=/\[>|\½$[|oğıuny5cf
        98eyp]]oıesrjfopmchopq4h4y8pqcew98mpf';

        function generateJwt(int | string $user_id, string $user_role, int $exp_time) : string{
            $payload = [
                'user_id' => $user_id,
                'role' => $user_role,
                'iat' => time(),
                'exp' => time() + $exp_time
            ];

            return JWT::encode($payload, self::$secretKey, 'HS256');
        }

        // check if toke is still valid
        // for loading user without log in phase
        function isExpired(string $token) : bool{
            try{
                JWT::decode($token, [self::$secretKey, 'HS256']);
            }catch(ExpiredException $e){
                return true;
            }
            return false;
        }

        // returns true if token is valid
        function openToken(string $token) : stdClass{
            return JWT::decode($token, [self::$secretKey, 'HS256']);
        }

    }