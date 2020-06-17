<?php
$Email;
class VeritabaniHatasiEmailControl extends Exception
{
}

try {
    /*$db= new PDO('mysql:host=localhost;dbname=site','yeK2Tp9J68TBB/?_','');*/
    $connection = @mysqli_connect("localhost", "root", "");
 
    if ($connection);
    /* yukarıdaki de olur  satır 15 daki de  olur   YANİ İF TE ; İLE İŞLEM YAPMADAN BİTİRMEK*/
    else{
        var_dump($connection);
        throw new Exception("Veri tabanı sunucusuna bağlanılamadı-Email kontrol");
    }
 

    if (mysqli_select_db($connection, "abc"))
        echo ""; /* buda  olur    satır 9 daki de  olur YANİ İF TE ; İLE İŞLEM YAPMADAN BİTİRMEK*/

    else {
   
        // include_once "../CreateDb.php";
        echo "tekrar db bağlanamadı";
         throw new  VeritabaniHatasiEmailControl("Vt down");
    }
      
  

    $sql = "select  * from logintbl where MemberEmail like '$Email' ";

 

    $result = mysqli_query($connection, $sql);
    if ($row = @mysqli_fetch_assoc($result))
        return 0;

    return 1;
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}
