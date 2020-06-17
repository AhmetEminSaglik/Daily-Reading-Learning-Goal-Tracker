<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../timeControl.php";
include "../Layout/layoutFunctions.php";
$cssArray = ["../layout/Header.css", "AddEnglishWord.css"];

Function_HeadTag_title_cssLink("Okuma Kaydetme Sayfası", $cssArray);
$PlaceHolder="Lütfen Kitap ismi Seçiniz";

function BringBooksName()
        {
            
$tableName="booktbl";
$ColumnName_Language="Language";
$languageValue=2;
$ColumnName_MemberId="MemberId";
$UserId=$_SESSION['UserId'];
 
$kelime_kitap_degerlendirme_ayrimi="kitap";

            require_once("../DbQueryControl/MysqlDbQueryControl.php");
            SelectDatabase("site");

            $row = RunQuery_to_Login__This_Function_Returns_rows_comparison_Bring_Books_Name(
                $tableName,
                $ColumnName_Language,
                $languageValue,        
                $ColumnName_MemberId,
                $UserId,  
                $kelime_kitap_degerlendirme_ayrimi       
              
                
            );
           
            

foreach($row as $var){
 ?>
<option>


    <?php echo $var['Name']; ?>

</option>
<!-- < ?php echo count($var); ?> -->
<?php
}

        }

?>


<p> Okuma Kaydetme (İngilizce  Kitap)</p>

<form action="ProcessDB.php" method="POST">
    <div class="WordAddBox">
        <div class="Explanation-Input"> Kitap Adı <span class="iki-nokta"> : </span> </div>
        <!-- <input type="text" required="" class="Input-text" name="BookName">
 -->
        <select required="" name="SelectBookItem">
            <option name="SelectBookItem" value="">
                <?php  echo $PlaceHolder; ?>

            </option>


            <?php    
 
 BringBooksName();  
 
?>
        </select>
        <?php 
 
?>
    </div>

    <div class="WordAddBox">
        <div class="Explanation-Input"> Sayfa Sayısı<span class="iki-nokta"> : </span> </div>
        <input type="number" required="" class="Input-text" name="ReadPage">
    </div>
    <!-- 
  <div class="WordAddBox">
    <div class="Explanation-Input"> Cümledeki Örnek Kullanımı<span class="iki-nokta"> : </span> </div>
    <textArea required class="Input-textArea" maxlength="100" rows="3" cols="80" name="SampleUse"></textArea>
  </div> -->
    <div class="WordAddBox">
        <div class="Explanation-Input">Kısa Bir Not <span class="iki-nokta"> : </span></div>
        <textArea class="Input-textArea" maxlength="100" rows="3" cols="80" name="Note"></textArea>
    </div>

<?php
  function totalNumberWordsOrPages( $tableName,$ColumnName_Language,$languageValue,$ColumnName_MemberId,$UserId,  $kelime_kitap_degerlendirme_ayrimi, 
      $limit)
  {
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
if($kelime_kitap_degerlendirme_ayrimi=="kelime"){
echo  count($row);
} else if($kelime_kitap_degerlendirme_ayrimi="kitap"){
$TotalReadPage=0;

foreach($row as $var){
  $TotalReadPage+=$var['ReadPageNumber'];
}
         echo  $TotalReadPage;
     }
     return $row;
}
    // totalNumberWordsOrPages(
    //     $tblName,
    //     "Language",
    //     $languageValue,
    //     "MemberId",
    //     $_SESSION['UserId'],
        
    //     $kelime_kitap_degerlendirme_ayrimi,5);
?>

    <input type="hidden" name="KelimeEkle" value="1">
    <input type="hidden" name="Language" value="English">
    <input type="hidden" name="HangiTablo" value="readbooktbl">
    <input type="submit" class="Button" value="Okumayı Ekle">



</form>