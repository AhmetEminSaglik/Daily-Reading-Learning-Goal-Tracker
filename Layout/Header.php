<?php

include "../timeControl.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../SessionEnded/SessionExistControl.php";
function temizle($str)
{
    return htmlspecialchars($str);
}
function escapePrint($text)
{
    echo temizle($text);
}


$MyString = get_included_files()[0];
$myPath = explode('\\', $MyString);
end($myPath);
$MyString = end($myPath);
$myPath = explode('.', $MyString);


$headerSection = $myPath[0];
?>
<header class="header">

    <nav>
        <ul>
            <li class="header-li"><a href="../LoginSuccess/HomePage.php" title="" class="<?php if ($headerSection == "HomePage") echo "active"; ?>">Anasayfa</a></li>
            <?php
            if (@isset($_SESSION['MemberActivated']) &&  @$_SESSION['MemberActivated'] == 2) {
            ?>
                <li style="float: left;"><a href="../LoginSuccess/Admin.php" title="Kullanıcılar" class="<?php if ($headerSection == "Admin") echo "active"; ?>">Kullanıcılar</a></li>

            <?php

            } ?>

            <li style="float: right;"><a href="../SessionEnded/SessionDestroy.php" title="Güvenli Çıkış Yapar">Çıkış</a></li>
            <li class="header-li" style="float: right;"><a href="../LoginSuccess/Profile.php" title="Profil" class="<?php if ($headerSection == "Profile") echo "active"; ?>"> <?php echo $_SESSION['Username'] ?></a></li>



        </ul>
    </nav>
</header>
<?php

?>