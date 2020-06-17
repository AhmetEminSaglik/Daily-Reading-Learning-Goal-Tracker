<?php
include "../timeControl.php";
include("../Layout/layoutFunctions.php");
Function_HeadTag_title_cssLink("İngilizce Kelime Silme Sayfası", "DeleteEnglishWord.css");
$tableName="wordtbl";
 
 $kelime_kitap_degerlendirme_ayrimi="kelime";
 $languageValue=2;

createTable("İngilizce Kelime Ezberleme Tablosu",  $tableName,
$languageValue,
$kelime_kitap_degerlendirme_ayrimi);
//($tableTitle, $tblName,$languageValue,$kelime_kitap_degerlendirme_ayrimi) 
// require "../Layout/layoutFunctions.php";

/*
function ifTooMuchCharacterShowLess($text, $max)
{
    echo mb_substr($text, 0, $max); //mb_substr -> türkçe karakterleri de algılıyor
    if (strlen($text) > $max) echo "...";
}*/
// Function_HeadTag_title_cssLink("İngilizce Kelime Sayfası", "");



function totalNumberWordsOrPages( $tableName,
$ColumnName_Language,
$languageValue,
$ColumnName_MemberId,
$UserId,
$kelime_kitap_degerlendirme_ayrimi )
{
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
    echo  count($row);
}
function PrintAllDatasInTable($tableName,
$ColumnName_Language,
$languageValue,
$ColumnName_MemberId,
$UserId,
$kelime_kitap_degerlendirme_ayrimi)
/** nedenini bilmediğim bir şekilde php de fonksiyonu üste yazmak zorundayım html de kullanabilmek için  */
{
        require("../DbQueryControl/MysqlDbQueryControl.php");

        
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
    $sayac = 1;
    foreach ($row as $var) {



?> <tr>
            <td style="text-align:center"><?php echo $sayac++; ?></td>
            <td> <?php escapePrint($var['AddedDate']);  ?> </td>
            <td class="td-bigger"> <?php escapePrint($var['Word']);   ?>
            </td>
            <td class="td-bigger"> <?php escapePrint($var['Meaning']); ?> </td>
            <td> <?php escapePrint($var['SampleUse']);  ?></td>
            <td><?php escapePrint($var['Note']);  ?> </td>
            <td>
                <div class="table-td-delete">
                    <form action="DeleteFromDatabase.php" method="post" onsubmit="return confirm('Silmek istiyor musunuz?');">
                        <input type="hidden" name="Delete" value="<?php echo $var['Id']; ?>">
                        <input type="hidden" name="HangiTablo" value="wordtbl">
                        <input type="hidden" name="Language" value="English">
                        <button style="cursor:pointer;"><img src="../img/delete-image.png" alt="Delete image" width="135px"></button>
                    </form>

                </div>
            </td>
        </tr> <?php
            }
        }
        function createTable($tableTitle, $tblName,$languageValue,$kelime_kitap_degerlendirme_ayrimi) //  global  $languageValue,$kelime_kitap_degerlendirme_ayrimi;
        {  ?>
    <div class="table-with-outside">
        <h3> <?php echo $tableTitle; ?></h3>
        <table class="special-table">
            <thead>
                <tr>
                    <th></th>
                    <th> Eklendiği Tarih </th>
                    <th>Kelime </th>
                    <th> Anlamı</th>

                    <th> Cümledeki Örnek Kullanımı </th>
                    <th>Note</th>
                    <th>Delete</th>

                </tr>

            </thead>
            <!-- burada en fazle 5 tane girdi olacak şekilde tablo görünür sonrasında hemen aşağıdan devam eder-->
            <tbody>
           
                <tr> <?php 
               
 
          
                 PrintAllDatasInTable(
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
                    <th colspan="4"> Ezberlenen Toplam Kelime Sayısı</th>
                    <th colspan="3"><?php
                    global  $tableName;
                  
                    totalNumberWordsOrPages(
                                        $tableName,
                                        "Language",
                                        $languageValue,
                                        "MemberId",
                                        $_SESSION['UserId'],$kelime_kitap_degerlendirme_ayrimi 
                                    );
                                     
                                    ?></th>


                </tr>

            </tfoot>

        </table>
    </div>
     
<?php


        } ?>

<body style="background-color:#b2bec3 "> </body>