<?php
$connection;
//echo "$DbName"; //$DbName;  çağrıldığı yerde hazır var 
/*$connectedServer = require("../DbQueryControl/connectServer.php");
$DbName = "site";
$db_select = mysqli_select_db($connection, $DbName);*/
require("../DbQueryControl/MysqlDbQueryControl.php");
SelectDatabase();


$Date = date('Y-m-d H:i:s');

$sifrelenmis = password_hash($Password, PASSWORD_DEFAULT);

$InsertIntoDbQuery = "insert into logintbl(MemberUsername, MemberPassword, MemberEmail, MemberSignupDate) values
('" . $Username . "','" . $sifrelenmis . "','" . $Email . "','" . $Date . "')";
if (mysqli_query($connection, $InsertIntoDbQuery)) {
    mysqli_close($connection);
    return 1;
}
mysqli_close($connection);
return 0;
