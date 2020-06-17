<?php
/* $servername = "localhost";
$username = "ahmetem2_website";
$password = "";


function SelectDatabaseFirst($connection, $Db_Name = "ahmetem2_Php_Calisma_Sitesi")
{
    $connection;
    try {

        if (mysqli_select_db($connection, $Db_Name))
            echo "";
        else {

            throw new Exception("Database Down");
        }
    } catch (Exception $e) {
        $e->getMessage();
    }
}

$connection = new mysqli($servername, $username, $password);


// $Query = "CREATE DATABASE ahmetem2_Php_Calisma_Sitesi CHARACTER SET utf8 COLLATE utf8_turkish_ci;";
// mysqli_query($connection, $Query);


$createTable="CREATE TABLE `ahmetem2_Php_Calisma_Sitesi`.`logintbl` 
( `MemberId` INT NOT NULL AUTO_INCREMENT , `MemberUsername` VARCHAR(30) NOT NULL , 
`MemberPassword` VARCHAR(100) NOT NULL , `MemberEmail` VARCHAR(50) NOT NULL , 
`MemberSignupDate` DATETIME NOT NULL , `MemberActivated` INT NOT NULL , 
PRIMARY KEY (`MemberId`)) ENGINE = InnoDB;";
mysqli_query($connection, $createTable);
 

$createTable = "CREATE TABLE `ahmetem2_Php_Calisma_Sitesi`.`languagetbl`  ( `Id` INT NOT NULL AUTO_INCREMENT , 
`Language` VARCHAR(30) NOT NULL , PRIMARY KEY (`Id`)) ENGINE = InnoDB;";
mysqli_query($connection, $createTable);


$createTable = "CREATE TABLE `ahmetem2_Php_Calisma_Sitesi`.`booktbl` ( `Id` INT NOT NULL AUTO_INCREMENT ,  
`Language` INT NOT NULL , `MemberId` INT NOT NULL , `Name` VARCHAR(100) NOT NULL ,  
`TotalPage` INT NOT NULL , `TotalReadPage` INT NOT NULL , `AddedDate` DATETIME NOT NULL , 
`Note` VARCHAR(150) NOT NULL , PRIMARY KEY (`Id`)) ENGINE = InnoDB";
mysqli_query($connection, $createTable);

$createTable = "CREATE TABLE `ahmetem2_Php_Calisma_Sitesi`.`readbooktbl` ( `Id` INT NOT NULL AUTO_INCREMENT , 
`MemberId` INT NOT NULL , `Language` INT NOT NULL , `BookName` VARCHAR(100) NOT NULL , 
`ReadPageNumber` INT NOT NULL , `ReadDate` DATETIME NOT NULL , `NoteFromBook` VARCHAR(150) NOT NULL , 
PRIMARY KEY (`Id`)) ENGINE = InnoDB;";
mysqli_query($connection, $createTable);
 
$createTable="CREATE TABLE `ahmetem2_Php_Calisma_Sitesi`.`wordtbl` ( `Id` INT NOT NULL AUTO_INCREMENT ,`Language` INT NOT NULL , 
 `MemberId` INT NOT NULL , `Word` VARCHAR(50) NOT NULL , 
 `Meaning` VARCHAR(100) NOT NULL , `AddedDate` DATETIME NOT NULL , `SampleUse` VARCHAR(150) NOT NULL , 
 `Note` VARCHAR(150) NOT NULL , PRIMARY KEY (`Id`)) ENGINE = InnoDB;";
 mysqli_query($connection, $createTable);

 SelectDatabaseFirst($connection);
$pass='$2y$10$dROiQle2qbvH7ikY/nIEdOicuzCcRWg747SphrSxzQuiv8eI3V/Gm';
 $InsertIntoDb="INSERT INTO logintbl (`MemberId`, `MemberUsername`, `MemberPassword`, `MemberEmail`,
   `MemberActivated`) VALUES 
  (NULL, 'ahmetemin', '$2y$10$dROiQle2qbvH7ikY/nIEdOicuzCcRWg747SphrSxzQuiv8eI3V/Gm', 'ahmeteminsaglik@gmail.com', '2')";
 mysqli_query($connection, $InsertIntoDb);
 
  $InsertIntoDb="INSERT INTO languagetbl (`Id`, `Language`) VALUES (NULL, 'Turkish'), (NULL, 'English'), (NULL, 'Spanish')";
  mysqli_query($connection, $InsertIntoDb);
  
  echo "Tablolar eklenmiş olmalı";
  
*/