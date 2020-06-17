<!DOCTYPE html>
<html lang="tr-TR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo '<link rel="stylesheet" type="text/css" href="afterSignupPage.css">'; ?>
    <title>Document</title>
    <?php
    $Email = $_POST['Email'];
    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    $feedBackEmail = require_once("connectForSignupEmailControl.php");    //      if $feedBackEmail == 1  sign up ok
    // else if $feedBack == 0 sign up  cancelled   because it  signed up already
    $feedBackUsername = require_once("connectForSignupUsernameControl.php");
    // $username == "1" ? ok : cancelled becaulse already taken 


    if ($feedBackEmail && $feedBackUsername) {

    ?>
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: sans-serif;
                background: white url("../img/loading-img.jpg") no-repeat center fixed;
                background-size: 100% 100%;
            }
        </style><?php
            } else if (!$feedBackEmail) {

                ?> <style>
            body {
                margin: 0;
                padding: 0;
                font-family: sans-serif;
                background: white url("../img/wait2.jpg") no-repeat center fixed;
                background-size: 100% 100%;

            }
        </style><?php
            } else if (!$feedBackUsername) {

                ?>
        <style>
            .body {
                margin: 0;
                padding: 0;
                background-color: #b2bec3;
            }

            .warning {
                width: 35%;
                height: 10%;
                line-height: 2.5em;
                margin: 15% 0 0 32%;
                color: red;
                text-align: center;
                border: 4px dashed brown;
                font-size: 1.2em;
            }

            .bold {
                font-weight: bold;
                color: blue
            }
        </style>
    <?php
            }

    ?>

</head>

<body>
    <?php


    if ($feedBackEmail && $feedBackUsername) {
        // önce veritabanına kayıt gönderilecek ondan sonra bilgi gösterilecek
        $connection = @mysqli_connect("localhost", "root", "");
        $DbName = "abc";
        require("insertIntoDbSignupMembers.php");
        SignupSuccessInfo();
    } else if (!$feedBackEmail) {
        SignedUpBeforeInfo();
    } else if (!$feedBackUsername) {
        WarningInfo();
    } else {
        echo "beklenmeyen durum";
    }

    ?>

    <?php

    function SignedUpBeforeInfo()
    {
    ?>
        <div lang="tr" class="Signedup-info">
            <h3>Bu email hesabı zaten kullanımda</h3>
            <p>lütfen bekleyiniz. Çalışmalarımız yoğun. İlginiz İçin teşekkür ederiz...
            </p>

        </div>
    <?php
    }

    function WarningInfo()
    {
    ?>
        <div class="warning">

            <body class="body"></body>
            <h3> Üzgünüm Bu Kullanıcı Adı Önceden Alınmış.
                <span class="bold">Lütfen Başka Bir Kullanıcı Adı Giriniz...</span></h3>
        </div>

    <?php
    }

    function SignupSuccessInfo()
    {
    ?>
        <div lang="tr" class="Signup-info">
            <h3>Kaydınız İşleme Alınmıştır.</h3>
            <p>Hesabınız aktif edildiği zaman
                bilgilendirileceksiniz...</p>

        </div>
    <?php
    }

    ?>
</body>

</html>