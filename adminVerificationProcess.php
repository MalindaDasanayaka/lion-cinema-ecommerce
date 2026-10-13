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

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tytydilan8@gmail.com';
        $mail->Password = 'kqtbblcdzmzwkyqn';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('tytydilan8@gmail.com', 'Admin Verification');
        $mail->addReplyTo('tytydilan8@gmail.com', 'Admin Verification');
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