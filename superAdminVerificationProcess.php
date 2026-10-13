<?php
include "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST["e"])){

    $email = $_POST["e"];

    $sadmin_rs = Database::search("SELECT * FROM `super_admin` WHERE `email`='".$email."'");
    $sadmin_num = $sadmin_rs->num_rows;

    if($sadmin_num > 0){

        $code = uniqid();

        Database::iud("UPDATE `super_admin` SET `vcode`='".$code."' WHERE `email`='".$email."'");

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tytydilan8@gmail.com';
        $mail->Password = 'kqtbblcdzmzwkyqn';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('tytydilan8@gmail.com', 'Super Admin Verification');
        $mail->addReplyTo('tytydilan8@gmail.com', 'Super Admin Verification');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Lion Cinema Super Admin Login Verification Code';
        $bodyContent = '<h1 style="color:red;">Your Verification Code is '.$code.'</h1>';
        $mail->Body    = $bodyContent;

        if(!$mail->send()){
            echo 'Verification code sending failed.';
        }else{
            echo 'Success';
        }
    }else{
        echo ("You are not the Super Admin.");
    }
}else{
    echo ("Email field should not be empty.");
}
?>