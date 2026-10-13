<?php

include "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST["e"]) && isset($_POST["p"])){

    $email = $_POST["e"];
    $password = $_POST["p"];

    $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email`='".$email."' AND `password`='".$password."' AND `status_status_id`='1'");
    $admin_num = $admin_rs->num_rows;

    if($admin_num > 0){

        $code = uniqid();

        Database::iud("UPDATE `admin` SET `vcode`='".$code."' WHERE `email`='".$email."'");

        $smtpUser = getenv('SMTP_USERNAME') ?: 'demo.mailer@lioncinema.com';
        $smtpPass = getenv('SMTP_PASSWORD') ?: '';

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUser;
        $mail->Password = $smtpPass;
        $mail->SMTPSecure = getenv('SMTP_SECURE') ?: 'ssl';
        $mail->Port = intval(getenv('SMTP_PORT') ?: 465);
        $mail->setFrom($smtpUser, 'Admin Verification');
        $mail->addReplyTo($smtpUser, 'Admin Verification');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Lion Cinema Admin Login Verification Code';
        $bodyContent = '<h1 style="color:blue;">Your Verification Code is '.$code.'</h1>';
        $mail->Body    = $bodyContent;

        if(!$mail->send()){
            echo 'Verification code sending failed.';
        }else{
            echo 'Success';
        }

    }else{
        echo ("You are not a Valid Admin.");
    }

}else{
    echo ("Email or Password or Both fields should not be empty.");
}

?>