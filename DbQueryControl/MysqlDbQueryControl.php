<?php
require("connectServer.php");
$connection = ConnectToMysql();

class VeritabaniHatasi extends Exception
{
}

function SelectDatabase($Db_Name = "PhpCalismaSite")
{
    global $connection;
    try {
        reconnect();
        if (mysqli_select_db($connection, $Db_Name))
            echo "";
        else {

            throw new VeritabaniHatasi("Database Down");
        }
    } catch (Exception $e) {
        $e->getMessage();
    }
}

function RunQuery_Just_Return_ExitsTrue_NoneFalse($queryText)
{  SelectDatabase();
    global $connection;


    $result = mysqli_query($connection, $queryText);

    // $row = (aşağıdaki iften bunu çıkardım)
    if ( mysqli_fetch_assoc($result)) // sorgulama sonrası gelen satır varsa true olur
        return true;

    return false;
}
function RunQuery_to_Login__This_Function_Returns_row($TableName, $ColumnName, $UserId)
{  SelectDatabase();

    global $connection;


    $queryText = "select * from  " . $TableName . " where  " . $ColumnName . " like '$UserId' "; //MemberUsername MemberPassword
    $result = mysqli_query($connection, $queryText);
  if ($row = mysqli_fetch_assoc($result)) // sorgulama sonrası gelen satır varsa true olur
    {
        return $row;
    }
}

function RunQuery_to_Login__This_Function_Returns_rows_comparison_Bring_Books_Name($TableName, $ColumnName_Language, $languageValue, $ColumnName_MemberId, $UserId, $kelime_kitap_degerlendirme_ayrimi)
{
    SelectDatabase();

    $ArrayOfResultFromMysql = [];

    global $connection;
    if (!$connection) {
        $connection = ConnectToMysql();
    }

    $queryText = "select * from   $TableName where   $ColumnName_MemberId  = $UserId and
    $ColumnName_Language = $languageValue  and TotalReadPage < TotalPage order by Id desc   ";

    $result = mysqli_query($connection, $queryText);


    while ($row = mysqli_fetch_assoc($result)) // sorgulama sonrası gelen satır varsa true olur
    {
        array_push($ArrayOfResultFromMysql, $row);
    }
    return $ArrayOfResultFromMysql;
}

function RunQuery_to_Login__This_Function_Returns_rows_comparison_Int3($languageValue, $UserId, $BookName)
{  SelectDatabase();
    $ArrayOfResultFromMysql = [];

    $connection = ConnectToMysql();


    $queryText = "select * from booktbl where  MemberId  = $UserId and  Language = $languageValue  and Name like '$BookName' ";
    echo "<br>" . $queryText;


    $result = mysqli_query($connection, $queryText);


    if (mysqli_fetch_assoc($result)) // sorgulama sonrası gelen satır varsa true olur
    {
       
        // array_push($ArrayOfResultFromMysql, $row);
    }
    return $ArrayOfResultFromMysql;
}

function RunQuery_to_Bring_Book_ReadTotalPage($languageValue, $UserId, $BookName)
{  SelectDatabase();
    $ArrayOfResultFromMysql = "";
    //  global $connection;
    $connection = ConnectToMysql();

    $queryText = "select * from   booktbl where   MemberId = $UserId ";
    // and  Language = $languageValue   and Name like '$BookName'


    //  if($connection) echo 1; else echo 2;exit;


    $result = mysqli_query($connection, $queryText);

    // if(!$result){
    //     die('Veriyi çekemedik'.mysqli_errno($con));
    // } 

    while ($row = mysqli_fetch_all($result)) // sorgulama sonrası gelen satır varsa true olur
    {
        array_push($ArrayOfResultFromMysql, $row);
    }
    print_r($ArrayOfResultFromMysql);
    
    exit;
    return $ArrayOfResultFromMysql;
}
function RunQuery_to_Login__This_Function_Returns_rows_comparison_Int($TableName, $ColumnName_Language, $languageValue, $ColumnName_MemberId, $UserId, $kelime_kitap_degerlendirme_ayrimi, $limitOrCondition)
{
    SelectDatabase();
    $ArrayOfResultFromMysql = [];
    global $connection;
    if (!$connection) {
        $connection = ConnectToMysql();
    }

    if ($kelime_kitap_degerlendirme_ayrimi == "kelime") {

        $queryText = "select * from   $TableName where   $ColumnName_MemberId  = $UserId and
    $ColumnName_Language = $languageValue  order by Id desc $limitOrCondition  ";
    } else if ($kelime_kitap_degerlendirme_ayrimi == "kitap") {

        $queryText = "select * from   $TableName where   $ColumnName_MemberId  = $UserId and
    $ColumnName_Language = $languageValue  $limitOrCondition  ";
    }


    //MemberUsername MemberPassword
    // Her grupta id olduğu için otomatik olarak tersten sıralar

    // echo  $queryText;
    // exit;
    // SelectDatabase();
    $result = mysqli_query($connection, $queryText);

    while ($row = mysqli_fetch_assoc($result)) // sorgulama sonrası gelen satır varsa true olur
    {

        array_push($ArrayOfResultFromMysql, $row);
    }

    return $ArrayOfResultFromMysql;
}

function RunQuery_to_Login__This_Function_Returns_rows_comparison_Int2($TableName, $ColumnName, $UserId, $limit)
{  SelectDatabase();
    $ArrayOfResultFromMysql = [];
    global $connection;
    if (!$connection) {
        $connection = ConnectToMysql();
    }

    $queryText = "select * from   $TableName where   $ColumnName  = $UserId   order by Id desc $limit  "; //MemberUsername MemberPassword
    // Her grupta id olduğu için otomatik olarak tersten sıralar

    // echo  $queryText;
    // exit;
    $result = mysqli_query($connection, $queryText);


    while ($row = mysqli_fetch_assoc($result)) // sorgulama sonrası gelen satır varsa true olur
    {
        array_push($ArrayOfResultFromMysql, $row);
    }
    return $ArrayOfResultFromMysql;
}





function RunQuery_Return_Results_In_Only_One_row($connection, $queryText)
{  SelectDatabase();
    $result = mysqli_query($connection, $queryText);
    if ($row = mysqli_fetch_assoc($result)) // sorgulama sonrası gelen satır varsa true olur
        return $row;
}
function Forbidden_Member($MemberId, $NewPosition)
{  SelectDatabase();

    global $connection;
    if (!$connection) {
        $connection = ConnectToMysql();
    }
    $queryText = "UPDATE logintbl SET MemberActivated = $NewPosition WHERE  MemberId = $MemberId ";
    SelectDatabase();
    if (mysqli_query($connection, $queryText)) {
        echo "güncelleme yapıldı";

        include "MailPage.php";

        sendMail("ahmeteminsaglik@gmail.com", $MemberId, $NewPosition);
        header("Location:./ForbiddenZone.php");
        // sendMail();
    } else {
        echo "Güncelleme Hatası";
        exit;
    }
}
function Update_Member_Position($MemberId, $NewPosition, $MemberEmail, $username)
{  SelectDatabase();
    global $connection;
    if (!$connection) {
        $connection = ConnectToMysql();
    }
    $queryText = "UPDATE logintbl SET MemberActivated = $NewPosition WHERE  MemberId = $MemberId ";
    SelectDatabase();

    if (mysqli_query($connection, $queryText)) {
        include "MailPage.php";

        sendMail($MemberEmail, $username, $NewPosition);
        // sendMail();
    } else {
        echo "Güncelleme Hatası";
        exit;
    }
}
function Run_Query_For_Admin_Bring_Members($limitOrCondition = "")
{  SelectDatabase();
    $ArrayOfResultFromMysql = [];
    global $connection;
    if (!$connection) {
        $connection = ConnectToMysql();
    }
    $queryText = "SELECT * FROM logintbl  " . "$limitOrCondition" . " order by MemberId desc ";
    SelectDatabase();
    $result = mysqli_query($connection, $queryText);

    while ($row = mysqli_fetch_assoc($result)) // sorgulama sonrası gelen satır varsa true olur
    {

        array_push($ArrayOfResultFromMysql, $row);
    }

    return $ArrayOfResultFromMysql;
}


function ConnectionControl($connection)
{
    if ($connection)
        return 1;
    return  0;
}
function reconnect()
{
    global $connection;
    if (!ConnectionControl($connection)) {

        $connection = ConnectToMysql();
        ConnectionControl($connection);
    }
}
function BringTodayDatas($tblName, $userId, $languaValue, $DateName)
{  SelectDatabase();
    $ArrayOfResultFromMysql = [];
    global $connection;
    if (!$connection) {
        $connection = ConnectToMysql();
    }

    $Today = date('Y-m-d ');
    //  $todayBegining=$Today." 00"
    // SELECT * FROM `wordtbl`  where AddedDate   BETWEEN '2020-05-14  00:00:00' and '2020-05-14 23:59:59'  

    $queryText = "SELECT * FROM $tblName where Language = $languaValue and MemberId=$userId and
    $DateName   BETWEEN '$Today  00:00:00' and '$Today 23:59:59' ";

    // SelectDatabase();
    $result = mysqli_query($connection, $queryText);

    while ($row = mysqli_fetch_assoc($result)) // sorgulama sonrası gelen satır varsa true olur
    {

        array_push($ArrayOfResultFromMysql, $row);
    }

    return $ArrayOfResultFromMysql;
}
