<!--
<head>
  <meta charset="utf-8">
  <title> Animated Login Form</title>
  < ?php echo '<link rel="stylesheet" type="text/css" href="../LoginSuccess/Home.css">';
  /* bu şekilde html uzantılı  ile yazdığımız kodlarımıza css bu şekilde ekleyebiliyoruz*/ ?>
</head>-->


<?php
include "../timeControl.php";
include "../Layout/layoutFunctions.php";
$cssArray = ["../layout/Header.css", "AddEnglishWord.css"];

Function_HeadTag_title_cssLink("İngilizce Kelime Ekleme Sayfası", $cssArray);


?>

<p> İngilizce Kelime Ekleme </p>
<form action="ProcessDB.php" method="POST">
  <div class="WordAddBox">
    <div class="Explanation-Input"> Kelime <span class="iki-nokta"> : </span> </div>
    <input type="text" required="" class="Input-text" name="Word">
  </div>

  <div class="WordAddBox">
    <div class="Explanation-Input"> Anlamı<span class="iki-nokta"> : </span> </div>
    <input type="text" required="" class="Input-text" name="Meaning">
  </div>

  <div class="WordAddBox">
    <div class="Explanation-Input"> Cümledeki Örnek Kullanımı<span class="iki-nokta"> : </span> </div>
    <textArea required class="Input-textArea" maxlength="100" rows="3" cols="80" name="SampleUse"></textArea>
  </div>
  <div class="WordAddBox">
    <div class="Explanation-Input">Kısa Bir Not <span class="iki-nokta"> : </span></div>
    <textArea class="Input-textArea" maxlength="150"  rows="3" cols="80" name="Note"
    placeholder="Maksimum 150 karakter..."></textArea>
  </div>

  <input type="hidden" name="KelimeEkle" value="1">
  <input type="hidden" name="Language" value="English">
  <input type="hidden" name="HangiTablo" value="wordtbl">
  <input type="submit" class="Button" value="Kelimeyi Ekle">



</form>