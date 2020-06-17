<?php
include "../timeControl.php";
include("../Layout/layoutFunctions.php");
Function_HeadTag_title_cssLink("İngilizce Kelime Silme Sayfası", "DeleteEnglishWord.css");
$tableName = "booktbl";

$kelime_kitap_degerlendirme_ayrimi = "kitap";
$languageValue = 2;

createTable(
    "İngilizce Kitap silme Tablosu",
    $tableName,
    $languageValue,
    $kelime_kitap_degerlendirme_ayrimi
);



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

    SelectDatabase();
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
    require("../DbQueryControl/MysqlDbQueryControl.php");


    SelectDatabase();
    $limit = "order by Id desc";
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
            <td class="td-bigger"> <?php escapePrint($var['Name']);   ?>
            </td>
            <td class="td-bigger"> <?php escapePrint($var['TotalPage']); ?> </td>
            <td> <?php escapePrint($var['TotalReadPage']);  ?></td>

            <td><?php escapePrint($var['Note']);  ?> </td>
            <td><label style="margin: auto; padding-left:20%"><?php echo "%" . (int) ($var['TotalReadPage'] * 100 / $var['TotalPage']); ?></label>
                <meter style="width: 90%; padding-right:10% " value="<?php echo $var['TotalReadPage']; ?>" max="<?php echo $var['TotalPage']; ?>"> </meter>
            </td>
            <!-- < ?php  echo $var['TotalReadPage']/$var['TotalPage']; ?> -->
            <td>
                <div class="table-td-delete">
                    <form action="DeleteFromDatabase.php" method="post" onsubmit="return confirm('Sadece kitap silinecektir okuduğunu sayfa sayısı ve aldığınız notlar kalacaktır. <br>Kitabı silmek istiyor?');">
                        <input type="hidden" name="Delete" value="<?php echo $var['Id']; ?>">
                        <input type="hidden" name="HangiTablo" value="booktbl">
                        <input type="hidden" name="Language" value="English">
                        <button style="cursor:pointer;"><img src="../img/delete-image.png" alt="Delete image" width="135px"></button>
                    </form>

                </div>
            </td>
        </tr> <?php
            }
        }
        function createTable($tableTitle, $tblName, $languageValue, $kelime_kitap_degerlendirme_ayrimi) //  global  $languageValue,$kelime_kitap_degerlendirme_ayrimi;
        {  ?>
    <div class="table-with-outside">
        <h3> <?php echo $tableTitle; ?></h3>
        <table class="special-table">
            <thead>
                <tr>
                    <th></th>
                    <th> Eklendiği Tarih </th>
                    <th>Kitap Adı </th>
                    <th> Toplam Sayfa Sayısı</th>

                    <th> Okunulan Sayfa Sayısı </th>
                    <th>Note</th>
                    <th>Okunma Yüzdeliği</th>
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
                    <th colspan="4">Kayıtlı Kitap Sayısı</th>
                    <th colspan="4"><?php
                                    global  $tableName;

                                    totalNumberWordsOrPages(
                                        $tableName,
                                        "Language",
                                        $languageValue,
                                        "MemberId",
                                        $_SESSION['UserId'],
                                        $kelime_kitap_degerlendirme_ayrimi
                                    );

                                    ?></th>


                </tr>

            </tfoot>

        </table>
    </div>

<?php


        } ?>

<body style="background-color:#b2bec3 "> </body>