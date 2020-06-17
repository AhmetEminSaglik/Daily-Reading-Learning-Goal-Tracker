<?php
$Email;
class VeritabaniHatasiUsernameConrtol extends Exception
{
}

try {
    /*$db= new PDO('mysql:host=localhost;dbname=site','root','');*/
    $connection = @mysqli_connect("localhost", "root", "");
    if ($connection);
    /* yukarıdaki de olur  satır 15 daki de  olur   YANİ İF TE ; İLE İŞLEM YAPMADAN BİTİRMEK*/
    else

        throw new Exception("Veri tabanı sunucusuna bağlanılamadı -> signup username");


    if (mysqli_select_db($connection, "abc"))
        echo ""; /* buda  olur    satır 9 daki de  olur YANİ İF TE ; İLE İŞLEM YAPMADAN BİTİRMEK*/

    else {

        throw new  VeritabaniHatasiUsernameConrtol("Vt down --> Username");
    }

    $sql = "select  * from logintbl where  MemberUsername like '$Username' ";
 

    $result = mysqli_query($connection, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        return 0;
    } else {
 
        return 1;
    }
} catch (Exception $e) {


    echo $e->getMessage();
    exit;
}
