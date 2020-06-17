<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

try {

    function sendMail($mailAtılacakAdress, $Username, $NewPosition)
    {
        $mail = new PHPMailer(true);
        //((normalde böyleydi SMTP::DEBUG_SERVER  ))
        $mail->SMTPDebug = 2;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'example@gmail.com';                     // SMTP username
        $mail->Password   = 'password';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        $mail->CharSet    = 'UTF-8';

        //maili gönderen kişi yani biz
        $mail->setFrom('example@gmail.com', '');
        $mail->addAddress($mailAtılacakAdress, $Username); // gidilecek adres ve  o kişinin ismi VE name is optinal.
        $mail->addReplyTo('gönderilecek mailin adresi ', $Username . 'adlı kullanıcıdan gelen mesaj');  // kişi yukarıdan gelen maile cevap yazmak isterse buradaki hesaba mailini gönderecektir
        $mail->isHTML(true); // html kullanmak için true yazıyoruz  


        switch ($NewPosition) {
            case -1:
                $mail->Subject = 'Hesap Askıya Alındı';
                $mail->Body = "Hesabınız önlem amacıyla askıya alınmıştır. Aktif edildiği zaman bilgilendirileceksiniz.";
                break;
            case 1:
                $mail->Subject = 'Hesap Onaylama';
                $mail->Body = "Merhaba Sayın $Username; <br> Hesabınız onaylanmıştır. İlgileriniz için teşekkür eder iyi günler dileriz.
            Aşağıdaki adresten  sitemize kolayca  ulaşabilirsiniz.<br> <a href =" . "http://localhost/calisma/LoginSuccess/Admin.php" . ">  http://localhost/calisma/LoginSuccess/Admin.php  </a>";
                break;
            case 2:
                break;
            case 404:
                $mail->Subject = 'Sitene Yetkisiz  Giriş Yapılmaya Çalışıldı - '.$Username;
                $mail->Body = "$Username id'li birisi admin paneline girmeye çalıştı... Ve hesabı bloke edildi";
            break;
            default:               echo " switch de hata var ";
        }

        $mail->send();
    };
} catch (Exception $e) {
    echo $e->ErrorInfo;
    exit;
}
