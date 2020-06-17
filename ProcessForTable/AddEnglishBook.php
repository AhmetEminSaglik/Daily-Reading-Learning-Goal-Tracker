<?php
include "../timeControl.php";
include "../Layout/layoutFunctions.php";
$cssArray = ["../layout/Header.css", "AddEnglishWord.css"];

Function_HeadTag_title_cssLink("İngilizce Kitap Ekleme Sayfası", $cssArray);


?>

<p> Kitap Ekleme (İngilizce Kitap)</p>
<form action="ProcessDB.php" method="POST">
  <div class="WordAddBox">
    <div class="Explanation-Input"> Kitap Adı <span class="iki-nokta"> : </span> </div>
    <input type="text" required="" class="Input-text" name="BookName">
  </div>

  <div class="WordAddBox">
    <div class="Explanation-Input"> Sayfa Sayısı<span class="iki-nokta"> : </span> </div>
    <input type="number" required="" class="Input-text" name="TotalPage">
  </div>
<!-- 
  <div class="WordAddBox">
    <div class="Explanation-Input"> Cümledeki Örnek Kullanımı<span class="iki-nokta"> : </span> </div>
    <textArea required class="Input-textArea" maxlength="100" rows="3" cols="80" name="SampleUse"></textArea>
  </div> -->
   <div class="WordAddBox">
    <div class="Explanation-Input">Kitaba Dair Kısa Bir Not <span class="iki-nokta"> : </span></div>
    <textArea class="Input-textArea" maxlength="150" rows="3" cols="80" name="Note" placeholder="Maksimum 150 karakter.."></textArea>
  </div> 

  <input type="hidden" name="KelimeEkle" value="1">
  <input type="hidden" name="Language" value="English">
  <input type="hidden" name="HangiTablo" value="booktbl">
  <input type="submit" class="Button" value="Kitabı Ekle">



</form>