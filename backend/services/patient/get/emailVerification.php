<?php

    use Mailtrap\Helper\ResponseHelper;
    use Mailtrap\MailtrapClient;
    use Mailtrap\Mime\MailtrapEmail;
    use Symfony\Component\Mime\Address;

    require dirname(__FILE__) . '/../../../../vendor/autoload.php';

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



    function sendVerificationEmail(string $email, string $verificationCode){

        $apiKey = $env['MAILTRAP_API'];
        $mailtrap = MailtrapClient::initSendingEmails(
            apiKey: $apiKey,
        );

        $email = (new MailtrapEmail())
            ->from(new Address('hello@demomailtrap.co', 'Nova Hospital'))
            ->to(new Address($email))
            ->subject('Verification Code')
            ->text('Your verification code is: ' . $verificationCode)
            ->category('Email Verification')
        ;
        $response = $mailtrap->send($email);
        return $response ? true:false;
    }
/*

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendVerificationEmail(string $email, string $verificationCode) {
    $mail = new PHPMailer (true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Set to DEBUG_SERVER for debugging
        $mail->isSMTP();
        $mail->Host = '127.0.0.1';
        $mail->SMTPAuth = false;
        $mail->SMTPAutoTLS = false;
        $mail->SMTPSecure = ''; // Enable TLS encryption
        $mail->Port = 1025; // TCP port to connect to

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
    }*/


/*    use Mailtrap\Helper\ResponseHelper;
    use Mailtrap\MailtrapClient;
    use Mailtrap\Mime\MailtrapEmail;
    use Symfony\Component\Mime\Address;

    require __DIR__ . '/vendor/autoload.php';

    $apiKey = '<YOUR_API_TOKEN>';
    $mailtrap = MailtrapClient::initSendingEmails(
        apiKey: $apiKey,
    );

    $email = (new MailtrapEmail())
        ->from(new Address('hello@demomailtrap.co', 'Mailtrap Test'))
        ->to(new Address("ysonmez824@gmail.com"))
        ->subject('You are awesome!')
        ->text('Congrats for sending test email with Mailtrap!')
        ->category('Integration Test')
    ;

    $response = $mailtrap->send($email);

    var_dump(ResponseHelper::toArray($response));*/
}