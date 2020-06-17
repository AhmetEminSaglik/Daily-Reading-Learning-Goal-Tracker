<?php
 
include "../Layout/Header.php";
setlocale(LC_ALL, 'tr_TR');

function Function_HeadTag_title_cssLink($title = "Başlık Eklenmemiş", $linkArray = "Link gönderilmemiş")

{

?>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->
        <title> <?php echo "$title"; ?></title>

        <?php if (is_array($linkArray)) {

            array_walk($linkArray, function (&$value) {
                $value = '<link rel="stylesheet" type="text/css" href="' . $value . '">';
            });



            for ($i = 0; $i < count($linkArray); $i++) {
                echo $linkArray[$i];
            }
            echo '<link rel="stylesheet" type="text/css" href="../Layout/Header.css">';
        } else {


            echo '<link rel="stylesheet" type="text/css" href="' . $linkArray . '">';
            echo '<link rel="stylesheet" type="text/css" href="../Layout/Header.css">';
        }

        //echo '<link rel="stylesheet" type="text/css" href="../LoginSuccess/Home.css">'
        /* bu şekilde html uzantılı  ile yazdığımız kodlarımıza css bu şekilde ekleyebiliyoruz*/ ?>
    </head>

<?php
}






?>