<?php

//Şimdilik bu sayfa olmadan da kod çalışıyor
$connection;

function ConnectToMysql()
{
    try {
        $connection = @mysqli_connect("localhost", "mysql_user", "mysql_password");
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

function CloseTheMysqlConnection()
{
    global $connection;
    mysqli_close($connection);
}
