<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
?>
işlem süresini geciktirdiğiniz için oturum kapatıldı lütfen tekrar giriş yapınız
<a href="../index.php">Tekrar Giriş Yapın</a>
 