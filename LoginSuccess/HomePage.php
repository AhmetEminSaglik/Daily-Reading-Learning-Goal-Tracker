<?php
$TurkishTblValue = 1;
$EnglishTblValue = 2;
$SpanishTblValue = 3;

$eng_word_nbr;
$spa_word_nbr;
$turk_read_page;
$eng_read_page;

require "../timeControl.php";
 
// $Date = date('Y-m-d ');
// echo $Date;exit;
function ifTooMuchCharacterShowLess($text, $max = 18)
{

    echo mb_substr($text, 0, $max); //mb_substr -> türkçe karakterleri de algiliyor
    if (strlen($text) > $max) {
        echo "...";
    }
}
function PrintTodayDatas($tblName, $userId, $languaValue, $DateName)
{

    require_once "../DbQueryControl/MysqlDbQueryControl.php";
    $row = BringTodayDatas($tblName, $userId, $languaValue, $DateName);

    $page_or_number = 0;

    global $eng_word_nbr, $spa_word_nbr, $turk_read_page, $eng_read_page;

    if ($tblName == "readbooktbl") {
        $page_or_number = 0;
        foreach ($row as $var) {
            $page_or_number += $var['ReadPageNumber'];
        }
        if ($languaValue == 1) {
            $turk_read_page = $page_or_number;
            echo  $page_or_number;
        } else if ($languaValue == 2) {
            $eng_read_page = $page_or_number;
            echo  $page_or_number;
        }
    } else if ($tblName = "booktbl") {
        $page_or_number = count($row);
        if ($languaValue == 2) {
            $eng_word_nbr = $page_or_number;
            echo  $page_or_number;
        } else if ($languaValue == 3) {
            $spa_word_nbr = $page_or_number;
            echo  $page_or_number;
        }
    } else {
        echo "bilimeyen hata --> günün değerlendirme bölümünde kelime sayısı kitapsayfa sayısı hesaplamasında";
    }


    // echo count($row);
}
function PrintAllDatasInTable(
    $tableName,
    $ColumnName_Language,
    $languageValue,
    $ColumnName_MemberId,
    $UserId,
    $kelime_kitap_degerlendirme_ayrimi
)
/** nedenini bilmediğim bir şekilde php de fonksiyonu üste yazmak zorundayim html de kullanabilmek için  */
{
    // echo $tableName."<br>";
    // echo $ColumnName_Language."<br>";
    // echo $languageValue."<br>";
    // echo $ColumnName_MemberId."<br>";
    // echo $UserId."<br>";

    require_once "../DbQueryControl/MysqlDbQueryControl.php";

    // SelectDatabase("site");
    $limit = "limit 5";

    if ($kelime_kitap_degerlendirme_ayrimi == "kitap") {
        $limit = "and ReadPageNumber > 0 order by Id desc $limit";
    }
    $row = RunQuery_to_Login__This_Function_Returns_rows_comparison_Int(
        $tableName,
        $ColumnName_Language,
        $languageValue,
        $ColumnName_MemberId,
        $UserId,
        $kelime_kitap_degerlendirme_ayrimi,
        $limit

    );

    foreach ($row as $var) {

?> <tr>

            <td> <?php
                    setlocale(LC_TIME, 'tr-TR');
                    $alinanDegisken = "";

                    if ($kelime_kitap_degerlendirme_ayrimi == "kelime") {
                        $alinanDegisken = $var['AddedDate'];
                    } else if ($kelime_kitap_degerlendirme_ayrimi = "kitap") {
                        $alinanDegisken = $var['ReadDate'];
                    }

                    $AddedDate = iconv('latin5', 'utf-8', strftime(' %d %B %Y<br>%A %T', strtotime($alinanDegisken)));
                    echo $AddedDate;

                    ?> </td>
            <?php

            global $kelime, $kitap, $degerlendirme;

            if ($kelime_kitap_degerlendirme_ayrimi == $kelime) { ?>
                <td class="td-bigger"> <?php ifTooMuchCharacterShowLess(temizle($var['Word'])); ?>
                </td>
                <td class="td-bigger"> <?php ifTooMuchCharacterShowLess(temizle($var['Meaning'])); ?> </td>
                <td> <?php echo escapePrint($var['SampleUse']); ?></td>

            <?php } else if ($kelime_kitap_degerlendirme_ayrimi == $kitap) {
            ?>

                <td class="td-bigger"> <?php ifTooMuchCharacterShowLess(temizle($var['BookName'])); ?>
                </td>
                <td class="td-bigger"> <?php
                                        echo $var['ReadPageNumber'];
                                        ?> </td>
                <td> <?php echo escapePrint($var['NoteFromBook']); ?></td>
            <?php
            } ?>
        </tr> <?php
            }
            if (count($row) == 0) {
                global $kelime, $kitap;
                if ($kelime_kitap_degerlendirme_ayrimi == $kelime) {
                ?> <tr>
                <td colspan="4">
                    <?php echo "KELİME KAYDINIZ YOKTUR"; ?>
                </td>

            </tr> <?php

                } else if ($kelime_kitap_degerlendirme_ayrimi == $kitap) {
                    ?> <tr>
                <td colspan="4">
                    <?php echo "KİTAP OKUMA KAYDINIZ YOKTUR"; ?>
                </td>
                </u>
            </tr> <?php

                }
            }
        }
        function totalNumberWordsOrPages(
            $tableName,
            $ColumnName_Language,
            $languageValue,
            $ColumnName_MemberId,
            $UserId,
            $kelime_kitap_degerlendirme_ayrimi,
            $limit
        ) {
            /**  require("../DbQueryControl/MysqlDbQueryControl.php");
             * bir kere yukarida çağirdiğimiz için tekrar çağirmaya gerek duymuyoruz
             */

            SelectDatabase("site");
            $limit = "";
            $row = RunQuery_to_Login__This_Function_Returns_rows_comparison_Int(
                $tableName,
                $ColumnName_Language,
                $languageValue,
                $ColumnName_MemberId,
                $UserId,
                $kelime_kitap_degerlendirme_ayrimi,
                $limit
            );
            if ($kelime_kitap_degerlendirme_ayrimi == "kelime") {
                echo count($row);
            } else if ($kelime_kitap_degerlendirme_ayrimi = "kitap") {
                $TotalReadPage = 0;

                foreach ($row as $var) {
                    $TotalReadPage += $var['ReadPageNumber'];
                }
                echo $TotalReadPage;
            }
            return $row;
        }

        //echo  "Hoşgeldin " . $_SESSION['Username']."  ARTIK ANA SAYFADASINIZ";

                    ?>


<?php
include "../Layout/layoutFunctions.php";
$headerSection = "HomePage";
Function_HeadTag_title_cssLink("Anasayfa", "HomePage.css");

include "../Layout/SideBar.php";

Function_HeadTag_title_cssLink("Anasayfa", "../Layout/SideBar.css");

?>


<!--
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    < ?php // echo '<link rel="stylesheet" type="text/css" href="Home.css">';
    ?>
    <title>Anasayfa</title>

</head>-->

<body style="background-color:#b2bec3 ">




    <div style="margin-top:-8%">
        <?php

        $kelime = "kelime";
        $kitap = "kitap";
        $degerlendirme = "degerlendirme";

        createTable(
            "ingKelEz",
            "İngilizce Kelime Ezberleme Tablosu",
            "wordtbl",
            $EnglishTblValue,
            "../ProcessForTable/AddEnglishWord.php",
            "../ProcessForTable/DeleteEnglishWord.php",
            $kelime

        );

        createTable(
            "ispKelEz",
            "İspanyolca Kelime Ezberleme Tablosu",
            "wordtbl",
            $SpanishTblValue,
            "../ProcessForTable/AddSpanishWord.php",
            "../ProcessForTable/DeleteSpanishWord.php",
            $kelime
        );

        createTable(
            "turkKtpTbl",
            "Türkçe Kitap Okuma Tablosu",
            "readbooktbl",
            $TurkishTblValue,
            "../ProcessForTable/AddTurkishBook.php",
            "../ProcessForTable/DeleteTurkishBook.php",
            $kitap
        );

        createTable(
            "ingKtpTbl",
            "İngilizce Kitap Okuma Tablosu",
            "readbooktbl",
            $EnglishTblValue,
            "../ProcessForTable/AddEnglishBook.php",
            "../ProcessForTable/DeleteEnglishBook.php",
            $kitap
        );
        createTableDegerlendirme('Gunun-Degerlendirmesi', 'Günün Değerlendirmesi');
        ?> </div>
    </div>

</body>

</html>
<?php

function createTableDegerlendirme($divId, $tableTitle)
{
    $Kelime_ing_sayi_Hedef = 3;
    $Kelime_isp_sayi_Hedef = 3;
    $Kitap_turk_sayfa_Hedef = 20;
    $Kitap_ing_sayfa_Hedef = 10;
?>
    <div id="<?php echo $divId; ?>" style="padding-top: 3%"> </div>
    <div class="table-with-outside">
        <h3> <?php echo $tableTitle; ?></h3>
        <table class="special-table">

            <thead>
                <tr>
                    <th></th>
                    <th>İngilizce Kelime Ezberleme </th>
                    <th>İspanyolca Kelime Ezberleme </th>
                    <th>Kitap Okuma Türkçe </th>
                    <th>Kitap Okuma İngilizce </th>

                </tr>

            </thead>
            <tbody>
                <tr>
                    <td>Günlük Hedef</td>
                    <td><?php echo  $Kelime_ing_sayi_Hedef ?> </td>
                    <td><?php echo  $Kelime_isp_sayi_Hedef ?> </td>
                    <td><?php echo  $Kitap_turk_sayfa_Hedef ?> </td>
                    <td><?php echo  $Kitap_ing_sayfa_Hedef ?> </td>
                </tr>
                <tr>
                    <td> Bugün Yapılanlar </td>
                    <td> <?php PrintTodayDatas("wordtbl", $_SESSION['UserId'], 2, "AddedDate"); ?> </td>
                    <td> <?php PrintTodayDatas("wordtbl", $_SESSION['UserId'], 3, "AddedDate"); ?> </td>
                    <td> <?php PrintTodayDatas("readbooktbl", $_SESSION['UserId'], 1, "ReadDate"); ?> </td>
                    <td> <?php PrintTodayDatas("readbooktbl", $_SESSION['UserId'], 2, "ReadDate"); ?> </td>


                </tr>
                <tr style="height:70px;">
                    <td> Yüzdelik Gösterim </td>

                    <td><label style="margin: auto;padding-left:30%">
                            <?php global $eng_word_nbr;
                            echo "%" . (int) ($eng_word_nbr * 100 / $Kelime_ing_sayi_Hedef); ?> </label>

                        <meter style="width: 90%; height:50%" value="<?php global $eng_word_nbr;
                                                                        echo $eng_word_nbr; ?>" max="<?php echo $Kelime_ing_sayi_Hedef; ?>"> </meter>
                    </td>
                    <td> <label style="margin: auto; padding-left:30%">
                            <?php global $spa_word_nbr;
                            echo "%" . (int) ($spa_word_nbr * 100 / $Kelime_isp_sayi_Hedef); ?> </label>
                        <meter style="width: 90%; height:50%" value="<?php global $spa_word_nbr;
                                                                        echo $spa_word_nbr; ?>" max="<?php echo $Kelime_isp_sayi_Hedef; ?>"> </meter>
                    </td>
                    <td><label style="margin: auto; padding-left:30%">
                            <?php global $turk_read_page;
                            echo "%" . (int) ($turk_read_page * 100 / $Kitap_turk_sayfa_Hedef); ?> </label>
                        <meter style="width: 90%; height:50%" value="<?php global $turk_read_page;
                                                                        echo $turk_read_page; ?>" max="<?php echo $Kitap_turk_sayfa_Hedef; ?>"> </meter>
                    </td>

                    <td><label style="margin: auto; padding-left:30%">
                            <?php global $eng_read_page;
                            echo "%" . (int) ($eng_read_page * 100 / $Kitap_ing_sayfa_Hedef); ?> </label>
                        <meter style="width: 90%; height:50%; background-color:red" value="<?php global $eng_read_page;
                                                                        echo $eng_read_page; ?>" max="<?php echo $Kitap_ing_sayfa_Hedef; ?>"> </meter>

                    </td>

                </tr>

            </tbody>
        <?php

    }

    function createTable($divId, $tableTitle, $tblName, $languageValue, $EklemeSayfasi, $SilmeSayfasi, $kelime_kitap_degerlendirme_ayrimi)
    { ?>
            <div id="<?php echo $divId; ?>" style="padding-top: 3%">
                <div class="table-with-outside">
                    <h3> <?php echo $tableTitle; ?></h3>
                    <table class="special-table">

                        <thead>
                            <tr class="not-hover">
                                <?php global $kelime, $kitap, $degerlendirme;

                                if ($kelime_kitap_degerlendirme_ayrimi == $kelime) {
                                    /**
        <?php
        if ($kelime_kitap_degerlendirme_ayrimi == $kelime) {
        ?> <?php
        } else if ($kelime_kitap_degerlendirme_ayrimi == $kitap) {
        ?> <?php
        } else if ($kelime_kitap_degerlendirme_ayrimi == $degerlendirme) {
        ?> <?php
        } ?>
                                     */
                                ?> <?php
                                    ?>
                                    <th colspan="3" class="Ekle"><a href="<?php echo $EklemeSayfasi; ?>">Kelime Ekle</a></th>
                                    <th colspan="1" class="Sil"><a href="<?php echo $SilmeSayfasi; ?>"> Kelime Sil</a></th>

                                <?php
                                } else if ($kelime_kitap_degerlendirme_ayrimi == $kitap) {
                                ?>
                                    <th colspan="2" class="Ekle"><a href="<?php echo $EklemeSayfasi; ?>">Kitap Ekle</a></th>
                                    <?php if ($languageValue == 1) { ?> <th colspan="1" class="Sil"><a href="../ProcessForTable/OkumaKayitSayfasiTurkish.php"> <span style="color: cyan">Günlük
                                                    Okuma Ekle</span></a>
                                        <?php } else if ($languageValue == 2) { ?>
                                        <th colspan="1" class="Sil"><a href="../ProcessForTable/OkumaKayitSayfasiEnglish.php"> <span style="color: cyan">Günlük Okuma Ekle</span></a>
                                        <?php } ?>
                                        </th>
                                        <th colspan="1" class="Sil"><a href="<?php echo $SilmeSayfasi; ?>"> Kitap Sil</a></th>
                            </tr>
                            <tr>

                            <?php
                                } else if ($kelime_kitap_degerlendirme_ayrimi == $degerlendirme) {
                            ?>
                                <th colspan="3" class="Ekle"><a href="<?php echo $EklemeSayfasi; ?>">degerlendirme pas geçildi</a>
                                </th>
                                <th colspan="1" class="Sil"><a href="<?php echo $SilmeSayfasi; ?>"> degerlendirme pas geçildi</a>
                                </th>
                            <?php
                                }

                            ?>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <?php
                                if ($kelime_kitap_degerlendirme_ayrimi == $kelime) { ?>
                                    <th> Eklendiği Tarih </th>
                                    <th>Kelime </th>
                                    <th> Anlami</th>
                                    <th> Cümledeki Örnek Kullanimi </th>
                                <?php
                                } else if ($kelime_kitap_degerlendirme_ayrimi == $kitap) { ?>
                                    <th> Okunduğu Tarih </th>
                                    <th>Kitap Adi </th>
                                    <th> Kaç Sayfa Okundun</th>
                                    <th> Alinan Notlar</th>
                                <?php
                                } else if ($kelime_kitap_degerlendirme_ayrimi == $degerlendirme) {
                                ?> <th> Eklendiği Tarih </th>
                                    <th>Kelime </th>
                                    <th> Anlami</th>
                                    <th> Cümledeki Örnek Kullanimi </th> <?php
                                                                        } ?>


                            </tr>

                        </thead>
                        <!-- burada en fazle 5 tane girdi olacak şekilde tablo görünür sonrasinda hemen aşağidan devam eder-->
                        <tbody>
                            <tr> <?php

                                    // echo "<br>".$tblName."   ".$tblName."   ".$tblName."   ".$tblName."   ".$tblName."   ".$tblName."   ".$tblName."   ".$tblName."   ";
                                    //  echo $tblName. "   "."Language".    "   ".$languageValue."   ". "MemberId"."   ".  $_SESSION['UserId']."   ". $kelime_kitap_degerlendirme_ayrimi;
                                    PrintAllDatasInTable(
                                        // $tableName, $ColumnName_Language,$languageValue, $ColumnName_MemberId, $UserId
                                        $tblName,
                                        "Language",
                                        $languageValue,
                                        "MemberId",
                                        $_SESSION['UserId'],
                                        $kelime_kitap_degerlendirme_ayrimi
                                    );

                                    ?>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="4"> <a href="">
                                        <form action="MuchMoreDatas.php" method="POST">
                                            <input type="hidden" name="Language" value="<?php echo $languageValue; ?>">
                                            <input type="hidden" name="HangiTablo" value="<?php echo $tblName; ?>">

                                            <button value="1" class="form-button"> Daha fazla bilgi için lütfen
                                                tiklayiniz...</button>


                                        </form>
                                    </a></th>

                            </tr>

                            <tr>
                                <?php
                                if ($kelime_kitap_degerlendirme_ayrimi == $kelime) {
                                ?>
                                    <th colspan="2"> Ezberlenen Toplam Kelime Sayisi</th>
                                <?php
                                } else if ($kelime_kitap_degerlendirme_ayrimi == $kitap) {
                                ?>
                                    <th colspan="2">Toplam Okunulan Sayfa Sayisi</th><?php

                                                                                    } else if ($kelime_kitap_degerlendirme_ayrimi == $degerlendirme) {
                                                                                        ?>
                                    <th colspan="2"> Ezberlenen Toplam Kelime Sayisi</th><?php

                                                                                        } ?>

                                <th colspan="2">

                                    <?php totalNumberWordsOrPages(
                                        /**
                                         *   $tableName,
        $ColumnName_Language,
        $languageValue,
        $ColumnName_MemberId,
        $UserId,
        $limit

                                         */
                                        $tblName,
                                        "Language",
                                        $languageValue,
                                        "MemberId",
                                        $_SESSION['UserId'],

                                        $kelime_kitap_degerlendirme_ayrimi,
                                        5
                                    );
                                    //         $AddedDate = iconv('latin5','utf-8',strftime(' %d %B %Y<br>%A %T',strtotime($alinanDegisken)));
                                    // echo $AddedDate;

                                    ?></th>
                            </tr>
                            <!--  <tr>
                <th colspan="2">Okunulan Toplam Sayfa Sayisi</th>
               <th colspan="2">4515</th>
            </tr>-->
                        </tfoot>

                    </table>
                </div>
            </div>
            <hr id="split-tables">
        <?php

    }


        ?>

        </body>