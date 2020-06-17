<?php
include "../timeControl.php";
if (!@isset($_SESSION['MemberActivated']) &&  @$_SESSION['MemberActivated'] != 2) {

    require_once "../DbQueryControl/MysqlDbQueryControl.php";
    @Forbidden_Member($_SESSION['UserId'], 404);
}
require "../timeControl.php";
include "../Layout/layoutFunctions.php";

Function_HeadTag_title_cssLink("Anasayfa", "HomePage.css");
// yukarıdaki 3 kodu da ekleyince header tam olarak çalışıyor

$UsersNumbers=0;
function PrintAllDatasInTable(){
    global   $UsersNumbers;
    require_once "../DbQueryControl/MysqlDbQueryControl.php";
    $row = Run_Query_For_Admin_Bring_Members();


    foreach ($row as $var) {
    
        if ($_SESSION['UserId'] != $var['MemberId']) {
              $UsersNumbers++;
?> <tr>

                <td> <?php
                        setlocale(LC_TIME, 'tr-TR');

                        $alinanDegisken = $var['MemberSignupDate'];


                        $AddedDate = iconv('latin5', 'utf-8', strftime(' %d %B %Y<br>%A %T', strtotime($alinanDegisken)));
                        echo $AddedDate;

                        ?> </td>
                <?php



                ?>

                <td class="td-bigger"> <?php escapePrint($var['MemberUsername']); ?>
                </td>
                <td class="td-bigger"> <?php escapePrint($var['MemberEmail']); ?> </td>
                <td> <?php
                        if ($var['MemberActivated'] == 0) {
                            echo "Yeni Kayıt";
                        } else if ($var['MemberActivated'] == 1) {
                            echo "Müşteri";
                        } else if ($var['MemberActivated'] == 2) {
                            echo "Yönetici";
                        } else
                    if ($var['MemberActivated'] == 404) {
                            echo "!!!Şüpheli!!!";
                        }

                        ?></td>

                <form action="ChangeDbMemberPosition.php" method="post" onsubmit="return confirm('Onay verdiğiniz anda  şahsa Email atılacaktır. Emin misiniz?');">
                    <td> <select required="" name="SelectPositon">
                            <option name="SelectPositon" selected value="">
                                Seçiniz

                            </option>
                            <option value=-1>Hesabı Askıya Al </option> <!-- Ayrı bir sayfa yapılacak -->
                            <option value=1>Müşteri</option>
                            <option value=2>Yönetici</option>

                        </select>
                    </td>
                    <td> <input type="submit" value="Onayla"> </input></td>
                    <input hidden name="MemberId" value="<?php echo $var['MemberId'] ?>">
                    <input hidden name="MemberEmail" value="<?php echo $var['MemberEmail'] ?>">
                    <input hidden name="Username" value="<?php echo $var['MemberUsername'] ?>">
                    <input hidden name="MemberId" value="<?php echo $var['MemberId'] ?>">

                </form>


                <?php   ?>
            </tr> <?php
                }
            }

            if (count($row) == 0) {


                    ?> <tr>
            <td colspan="4">
                <?php echo "Müşteri Kaydı Yoktur"; ?>
            </td>

        </tr> <?php

            } else {
                ?>
        <tr>
            <td colspan="3" style="font-weight:bold; font-size:18px;padding:1%">Kayıtlı Kullanıcı Sayısı</td>
            <td colspan="3" style="font-weight:bold; font-size:18px;text-align:center"><?php echo $UsersNumbers;?></td>
        </tr>
    <?php

            }
        }



        function createTable($tableTitle, $tblName)
        { ?>
    <table class="special-table">
        <thead>
            <tr>
                <th>Member Sigup Date</th>
                <th>Member Username</th>
                <th>Member Email</th>
                <th>Member Positon</th>
                <th>Change Position</th>
                <th>Onaylama</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php

                PrintAllDatasInTable();

                ?>
            </tr>
        </tbody>
    <?php

        }
        createTable(
            "Kayıt Tablosu",
            "logintbl"

        );
?> <body style="background-color:lightgray;">
    
</body>