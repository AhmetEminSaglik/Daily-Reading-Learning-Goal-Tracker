<?php
include "../timeControl.php";


if (isset($_POST['Delete'])) {
    // $_POST['Delete'];
    $connection = ConnectToMysql();
    Delete($connection, $_POST['HangiTablo'],"Id", $_POST['Delete']);
}

function Delete($connection, $tableName, $columnName, $deleteId)
{
    SelectDatabase($connection);
    $DeleteQuery = "DELETE FROM $tableName WHERE $columnName = $deleteId";

    $result = mysqli_query($connection, $DeleteQuery);

 
    if ($result) {
        if ($_POST['HangiTablo'] == "wordtbl") {
            if ($_POST['Language'] == "English") {
                  header("Location:./DeleteEnglishWord.php");
            }else    if ($_POST['Language'] == "Spanish") {
                header("Location:./DeleteSpanishWord.php");
            }
      
        }  else if($_POST['HangiTablo'] == "booktbl"){
            if ($_POST['Language'] == "Turkish") {
                header("Location:./DeleteTurkishBook.php");
          }else    if ($_POST['Language'] == "English") {
            header("Location:./DeleteEnglishBook.php");
          }
    
        }
    }
}



function SelectDatabase($connection, $Db_Name = "PhpCalismaSite")
{
    $connection;
    try {

        if (mysqli_select_db($connection, $Db_Name))
            echo "";
        else {

            throw new VeritabaniHatasi("Database Down");
        }
    } catch (Exception $e) {
        $e->getMessage();
    }
}




function ConnectToMysql()
{
    try {
        $connection = @mysqli_connect("localhost", "root", "");
        if ($connection)

            return $connection;
        else
            throw new Exception("Veri tabanı sunucusuna bağlanılamadı");
    } catch (Exception $e) {
        echo $e->getMessage();
        //   CloseTheMysqlConnection();
        exit;
    }
    // CloseTheMysqlConnection();
}
