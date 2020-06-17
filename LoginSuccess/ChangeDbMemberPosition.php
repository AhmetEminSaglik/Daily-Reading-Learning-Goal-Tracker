<?php 
 
require_once "../DbQueryControl/MysqlDbQueryControl.php";
$text="Hesabınız Aktif Edilmiştir.";
Update_Member_Position($_POST['MemberId'],$_POST['SelectPositon'],$_POST['MemberEmail'],$_POST['Username']);


 