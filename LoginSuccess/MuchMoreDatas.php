<?php
include "../timeControl.php";
include "../Layout/layoutFunctions.php";
setlocale(LC_TIME, 'tr-TR');
$TurkishTblValue = 1;
$EnglishTblValue = 2;
$SpanishTblValue = 3;
$kelime_kitap_degerlendirme_ayrimi = "";

$languageValue = $_POST['Language'];

if ($_POST['HangiTablo'] == 'wordtbl') {
    $kelime_kitap_degerlendirme_ayrimi = "kelime";
    if ($_POST['Language'] == $EnglishTblValue) {
        Function_HeadTag_title_cssLink("İngilizce Kelime Sayfası", "MuhcMoreDatas.css");
        createTable("İngilizce Kelime Ezberleme Tablosu", $_POST['HangiTablo']);
    } else if ($_POST['Language'] == $SpanishTblValue) {
        Function_HeadTag_title_cssLink("İspanyolca Kelime Sayfası", "MuhcMoreDatas.css");
        createTable("İspanyolca Kelime Ezberleme Tablosu", $_POST['HangiTablo']);
    } else {
        echo "Bilinmeyen Hata Lütfen Yöneticiye başvurun";
    }
} else if ($_POST['HangiTablo'] == 'readbooktbl') {
    $kelime_kitap_degerlendirme_ayrimi = "kitap";
    if ($_POST['Language'] == $EnglishTblValue) {
        Function_HeadTag_title_cssLink("İngilizce Kelime Sayfası", "MuhcMoreDatas.css");
        createTable("İngilizce Kitap Okuma Tablosu", $_POST['HangiTablo']);
    } else if ($_POST['Language'] == $TurkishTblValue) {
        Function_HeadTag_title_cssLink("Türkçe Kitap Sayfası", "MuhcMoreDatas.css");
        createTable("Türkçe Kitap Okuma Tablosu", $_POST['HangiTablo']);
    } else {
        echo "Bilinmeyen Hata Lütfen Yöneticiye başvurun";
    }
}

//    spanishwordtbl
//     englishwordtbl;

// require "../Layout/layoutFunctions.php";

/*
function ifTooMuchCharacterShowLess($text, $max)
{
echo mb_substr($text, 0, $max); //mb_substr -> türkçe karakterleri de algılıyor
if (strlen($text) > $max) echo "...";
}*/

function totalNumberWordsOrPages(
    $tableName,
    $ColumnName_Language,
    $languageValue,
    $ColumnName_MemberId,
    $UserId,
    $kelime_kitap_degerlendirme_ayrimi
) {
    /**  require("../DbQueryControl/MysqlDbQueryControl.php");
     * bir kere yukarıda çağırdığımız için tekrar çağırmaya gerek duymuyoruz
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
    }
}
function PrintAllDatasInTable(
    $tableName,
    $ColumnName_Language,
    $languageValue,
    $ColumnName_MemberId,
    $UserId,
    $kelime_kitap_degerlendirme_ayrimi
)
/** nedenini bilmediğim bir şekilde php de fonksiyonu üste yazmak zorundayım html de kullanabilmek için  */
{

    require "../DbQueryControl/MysqlDbQueryControl.php";

    SelectDatabase("site");
    $limit = "";
    if ($kelime_kitap_degerlendirme_ayrimi == "kelime") {
    } else if ($kelime_kitap_degerlendirme_ayrimi == "kitap") {
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
    $sayac = 1;

    if ($kelime_kitap_degerlendirme_ayrimi == "kelime") {
        foreach ($row as $var) {

?> <tr>
                <td style="text-align:center " class="first-td-tbody"><?php echo $sayac++; ?></td>
                <td> <?php escapePrint($var['AddedDate']); ?> </td>
                <td class="td-bigger"> <?php escapePrint($var['Word']); ?>
                </td>
                <td class="td-bigger"> <?php escapePrint($var['Meaning']); ?> </td>
                <td> <?php escapePrint($var['SampleUse']); ?></td>
                <td> <?php escapePrint($var['Note']); ?></td>
            </tr>


        <?php
        }
    } else if ($kelime_kitap_degerlendirme_ayrimi == "kitap") {
        $totalReadpage = 0;

        $sayac = 0;
        foreach ($row as $var) {

            $totalReadpage += $row[$sayac]['ReadPageNumber'];

            // $totalReadpage+=$row['ReadPageNumber'];
            // echo "SAYFA SAYISI------------------>>>>>>>>>>>>>.$totalReadpage";

        ?> <tr>
                <td style="text-align:center" class="first-td-tbody"><?php echo $sayac++; ?></td>

                <td> <?php

                        $AddedDate = iconv('latin5', 'utf-8', strftime(' %d %B %Y<br>%A <br>%T', strtotime($var['ReadDate'])));
                        echo $AddedDate;

                        ?> </td>
                <td class="td-bigger"> <?php escapePrint($var['BookName']); ?></td>
                <td> <?php escapePrint($var['ReadPageNumber']); ?></td>
                <td class="td-bigger"> <?php escapePrint($var['NoteFromBook']); ?> </td>
                <!-- <td> <?php escapePrint($var['SampleUse']); ?></td>
                            <td> <?php escapePrint($var['Note']); ?></td> -->
            </tr>


    <?php
        }

        return $totalReadpage;
    }
}
function createTable($tableTitle, $tblName)
{ ?>
    <div class="table-with-outside">
        <h3> <?php echo $tableTitle; ?></h3>
        <table class="special-table">
            <thead>
                <tr><?php global $kelime_kitap_degerlendirme_ayrimi;
                    if ($kelime_kitap_degerlendirme_ayrimi == "kelime") { ?>
                        <th></th>
                        <th> Eklendiği Tarih </th>
                        <th>Kelime </th>
                        <th> Anlamı</th>

                        <th> Cümledeki Örnek Kullanımı </th>
                        <th> Alınan Notlar</th>

                    <?php } else if ($kelime_kitap_degerlendirme_ayrimi == "kitap") {
                    ?>
                        <th></th>
                        <th> Okunduğu Tarih </th>
                        <th>Kitap Adı </th>
                        <th> Okunulan Sayfa</th>
                        <th> Okunduğunda alınan Notlar</th>
                    <?php

                    } ?>
                </tr>
            </thead>
            <!-- burada en fazle 5 tane girdi olacak şekilde tablo görünür sonrasında hemen aşağıdan devam eder-->
            <tbody>
                <tr> <?php
                        global $languageValue, $kelime_kitap_degerlendirme_ayrimi;

                        $totalReadPage = PrintAllDatasInTable(
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
                    <?php if ($kelime_kitap_degerlendirme_ayrimi == "kelime") { ?>
                        <th colspan="4"> Ezberlenen Toplam Kelime Sayısı</th>
                        <th colspan="2"><?php totalNumberWordsOrPages(
                                            $tblName,
                                            "Language",
                                            $languageValue,
                                            "MemberId",
                                            $_SESSION['UserId'],
                                            $kelime_kitap_degerlendirme_ayrimi

                                        ); ?></th>

                    <?php
                    } else if ($kelime_kitap_degerlendirme_ayrimi == "kitap") {
                    ?>
                        <th colspan="3"> Okunulan Toplam Sayfa Sayısı</th>
                        <th colspan="2"><?php

                                        echo $totalReadPage;
                                        // totalNumberWordsOrPages(
                                        //                     $tblName,
                                        //                     "Language",
                                        //                     $languageValue,
                                        //                     "MemberId",
                                        //                     $_SESSION['UserId'],
                                        //                     $kelime_kitap_degerlendirme_ayrimi

                                        // );

                                        ?></th>
                    <?php
                    }

                    ?>
                </tr>

            </tfoot>

        </table>
    </div>
    <hr>
<?php

} ?>

<body style="background-color:#b2bec3 "> </body>