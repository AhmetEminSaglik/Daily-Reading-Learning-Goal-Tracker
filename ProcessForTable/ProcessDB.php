<?php
include "../timeControl.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_POST['KelimeEkle'])) {
    //    unset($_POST);

    //header("Location:AddEnglishWord.php");

    $connection;
    include("../DbQueryControl/MysqlDbQueryControl.php");


    SelectDatabase();

    date_default_timezone_set("Europe/Istanbul");
    setlocale(LC_TIME, 'tr-TR');

    $Date = date('Y-m-d H:i:s');
    $language = "";
    //   ($_POST['Language']=="Turkish")? $language=1:  ($_POST['Language']=="English")? $language=2 :$language=3;
    // NEDEN BİLMİYORUM YUKARIDAN 2 ÇIKIYOR 1 OLMASI GEREKİRKEN

    if ($_POST['Language'] == "Turkish") {
        $language = 1;
    } else if ($_POST['Language'] == "English") {
        $language = 2;
    } else if ($_POST['Language'] == "Spanish") {
        $language = 3;
    } else {
        echo "dil hatası";
        exit;
    }
    function book_Word_Control($MemberId, $tabloName, $language, $bookName)
    {
        global $connection;

        $ControlQuery = "select * from $tabloName where MemberId = $MemberId and Language= $language and Name like '" . $bookName . "'";


        SelectDatabase();
        $result = mysqli_query($connection, $ControlQuery);


        if ($row = mysqli_fetch_assoc($result)) {

            echo "<h1> Kitap Zaten Kayıtlı olduğu için kayıt yapılamadı</h1>";
            if ($tabloName == "booktbl") {
                if ($language == 1) {
?> <a href="./AddTurkishBook.php">
                        <h2>Türkçe Kitap Ekleme Sayfasına gitmek için tıklayınız.</h2>
                    </a> <?php
                        } else {
                            ?> <a href="./AddEnglishBook.php">
                        <h2>İngilizce Kitap Ekleme Sayfasına gitmek için tıklayınız. </h2>
                    </a><?php
                        }
                    } else if ($tabloName == "wordtbl") {
                        if ($language == 2) {
                        ?> <a href="./AddEnglishWord.php">
                        <!-- kelime eklenilmiş ama tekrar eklemek istermisinize devam edemiyorum durdurduğum zaman -->
                    </a> <?php
                        } else {
                            ?> <a href="./AddSpanishWord.php">
                        <!-- kelime eklenilmiş ama tekrar eklemek istermisinize devam edemiyorum durdurduğum zaman -->
                    </a><?php
                        }
                    }
                    exit;
                }
                //   if(@mysqli_query($connection,$ControlQuery ))

                //   {echo "kitap var";echo $ControlQuery; exit;}else{ echo "kitap yok ";
                // echo $ControlQuery;
                // exit;}






            }
            // 1-2-3- türkçce-ingilizce-ispanyolca
            if ($_POST['HangiTablo'] == "wordtbl") { //turkishbooktbl
                $_POST['Word'] = ucwords($_POST['Word']);
                book_Word_Control($_SESSION['UserId'], 'booktbl', $language,  $_POST['Word']);
                $InsertIntoDbQuery = "insert into " . $_POST['HangiTablo'] . "(MemberId,	Language,	Word,	Meaning,	AddedDate,	SampleUse, Note) values
('" . $_SESSION['UserId'] . "','" . $language . "','" . $_POST['Word'] . "',
'" . $_POST['Meaning'] . "','" . $Date . "','" . $_POST['SampleUse'] . "','" . $_POST['Note'] . "')";
            } else if ($_POST['HangiTablo'] == "booktbl") {
                $_POST['BookName'] = ucwords($_POST['BookName']);
                book_Word_Control($_SESSION['UserId'], 'booktbl', $language,  $_POST['BookName']);

                $InsertIntoDbQuery = "insert into " . $_POST['HangiTablo'] . "(MemberId,	Language,	Name,	TotalPage, TotalReadPage,	AddedDate,   Note) 
    values ('" . $_SESSION['UserId'] . "','"  . $language . "','" . $_POST['BookName'] . "','" . $_POST['TotalPage'] . "','" . 0 . "','" .  $Date . "','" . $_POST['Note'] . "')";
            } else if ($_POST['HangiTablo'] == "readbooktbl") {

                $InsertIntoDbQuery = "insert into " . $_POST['HangiTablo'] . "(MemberId,	Language,    BookName,	ReadPageNumber,	ReadDate,   NoteFromBook) 
    values ('" . $_SESSION['UserId'] . "','"  . $language . "','" . $_POST['SelectBookItem'] . "','" . $_POST['ReadPage'] . "','" .  $Date . "','" . $_POST['Note'] . "')";
            } else {
                echo "beklenmedik -- post ~ tablo uyuşmazlığı -- hata ProcessDB.php";
                exit;
            }
            // echo "<br> $InsertIntoDbQuery <br>";


            $row = ReturnReadTotalPageNumber(
                $language,
                $_SESSION['UserId']
            );
            OkumaSayisiKitapSayisiniGecemez($_POST['ReadPage'], $row);

            if (@mysqli_query($connection, $InsertIntoDbQuery)) {
                // mysqli_close($connection);


                if ($_POST['HangiTablo'] == "readbooktbl") {


                    //önceki okunulan toplam sayfayı bulup bunu onun üzerine eklicez



                    $TotalReadPage = $_POST['ReadPage'] + $row['TotalReadPage'];


                    $UpdateIntoDbQuery = "update   booktbl   set TotalReadPage =  $TotalReadPage    where MemberId  = " . $_SESSION['UserId'] . " and Name like '" . $_POST['SelectBookItem'] . "' ";
                    echo $UpdateIntoDbQuery;


                    if (@mysqli_query($connection, $UpdateIntoDbQuery)) {
                        // mysqli_close($connection);

                    }
                }



                if ($_POST['HangiTablo'] == "wordtbl") {
                    if ($_POST['Language'] == "English") {
                        header("Location:./AddEnglishWord.php");
                    } else if ($_POST['Language'] == "Spanish") {
                        header("Location:./AddSpanishWord.php");
                    }
                } else    if ($_POST['HangiTablo'] == "booktbl") {
                    if ($_POST['Language'] == "Turkish") {

                        header("Location:./AddTurkishBook.php");
                    } else if ($_POST['Language'] == "English") {
                        header("Location:./AddEnglishBook.php");
                    }
                } else if ($_POST['HangiTablo'] == "readbooktbl") {
                    if ($_POST['Language'] == "Turkish") {

                        header("Location:./OkumaKayitSayfasiTurkish.php");
                    } else if ($_POST['Language'] == "English") {
                        header("Location:./OkumaKayitSayfasiEnglish.php");
                    }
                } else {
                    echo "beklenmeyen hata --- Sayfaya gitme  Hatası";
                }

                unset($_POST);
                return 1;
            }

            if ($connection) {
                mysqli_close($connection);
            }
            echo "<br>KELİME EKLENEMEDİ  <br>   LÜTFEN bu sayfayı ve bir önceki eklediğiniz sayfayı  ss alıp
       yönetiye mail atınız : <br>
       <u>ahmeteminsaglik@gmail.com</u>";
            unset($_POST);
            return 0;
        }




        function ReturnReadTotalPageNumber($languageValue, $UserId)
        {

            global $connection;
            if (!$connection) {
                $connection = ConnectToMysql();
            }


            $queryText = "select * from  booktbl where MemberId  = $UserId and
    Language = $languageValue  and Name like '" . $_POST['SelectBookItem'] . "'";


            SelectDatabase();
            $result = mysqli_query($connection, $queryText);


            if ($row = mysqli_fetch_assoc($result)) {

                return $row;
            }


            return 0;
        }
        function OkunulanSayfaKitapSayfasiniGectiHatasi()
        {
            global $language;

            echo '<pre></pre> <p style= "color:red ; font-size:25px">HATA -- Okuduğunuz sayfaların toplamı kitabın sayfa sayısını geçemez </p> ';
            if ($language == 1) {
                        ?>
        <p style="font-size:20px">Türkçe Kitap Okuma Kayıt Sayfasına Dönmek İçin <a href="./OkumaKayitSayfasiTurkish.php">TIKLAYINIZ...</a> </p>
    <?php
            } else if ($language == 2) {
    ?>
        <p style="font-size:20px">İngilizce Kitap Okuma Kayıt Sayfasına Dönmek İçin <a href="./OkumaKayitSayfasiEnglish.php">TIKLAYINIZ...</a> </p>
<?php
            }
            exit;
        }

        function OkumaSayisiKitapSayisiniGecemez($simdikiOkuma, $KitapBilgisiArray)
        {

            // exit;
            if ($KitapBilgisiArray['TotalPage'] < ($KitapBilgisiArray['TotalReadPage'] + $simdikiOkuma)) {
                OkunulanSayfaKitapSayfasiniGectiHatasi();
            }
        }
