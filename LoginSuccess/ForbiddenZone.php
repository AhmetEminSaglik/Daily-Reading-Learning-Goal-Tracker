<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
for($i=0;$i<3;$i++)
echo "<h1>Yetkisiz alana girmeye çalıştığınız Hesabınız bloke edilmiştir...</h1>";
session_destroy();


exit;
?>