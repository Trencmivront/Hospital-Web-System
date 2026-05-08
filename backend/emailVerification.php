<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Function to generate a random verification code
function generateVerificationCode($length = 6) {
    $characters = '0123456789';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}

// Function to send a verification email using PHPMailer
function sendVerificationEmail(string $email, string $verificationCode) {
    $mail = new PHPMailer (true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Set to DEBUG_SERVER for debugging
        $mail->isSMTP();
        $mail->Host = '127.0.0.1'; // Mailtrap SMTP server host 
        $mail->SMTPAuth = false;
        $mail->SMTPAutoTLS = false;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 8025; // TCP port to connect to

        //Recipients
        $mail->setFrom(address:'novahospital@gmail.com', name:"Nova Hospital"); //Sender's email and name
        $mail->addAddress($email); // Recipient's email

        //Content
        $mail->isHTML(true); //Set to true if sending HTML email
        $mail->Subject = 'Email Verification';
        $mail->Body = "Your verification code is:<b> $verificationCode</b>";

        $mail->send();
        return true;
    }catch (Exception $e) {
        return false;
    }
}