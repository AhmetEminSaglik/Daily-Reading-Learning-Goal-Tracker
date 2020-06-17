<!DOCTYPE html>
<html lang="tr" dir="ltr">

<head>
  <meta charset="utf-8">
  <title> Giriş Sayfası</title>
  <?php echo '<link rel="stylesheet" type="text/css" href="index.css">';
  /* bu şekilde html uzantılı  ile yazdığımız kodlarımıza css bu şekilde ekleyebiliyoruz*/ ?>
</head>

<body>
  <?php
  /*
$Date = date('Y-m-d H:i:s');
echo "$Date<br>";*/

  if (isset($_POST['Login'])) {

    $Username = $_POST['Username'];
    $Password = $_POST['Password'];

    require "./DbQueryControl/MysqlDbQueryControl.php";

    SelectDatabase();

    $row = RunQuery_to_Login__This_Function_Returns_row("logintbl", "MemberUsername", $Username);
    //print_r($row);
    //echo "<hr>".$row['MemberId'];
    //login olacak ve sessionu verebiliriz bu saatten sonra
    //print_r($row);

    if (
      $row['MemberUsername'] == $_POST['Username'] &&
      password_verify($_POST['Password'], $row['MemberPassword'])
    ) {
      // 0 --> not validated account
      if ($row['MemberActivated'] == 1) { //2--> client
        session_start();
        ob_start();
        $_SESSION['time'] = time() + 3;
        $_SESSION['UserId'] = $row['MemberId'];
        $_SESSION['Username'] = $row['MemberUsername'];
        $_SESSION['SignupDate'] = $row['MemberSignupDate'];

        header('Location:./LoginSuccess/HomePage.php');
      } else if ($row['MemberActivated'] == 2) { // 2--> admin
        session_start();
        ob_start();
        $_SESSION['time'] = time() + 120;
        $_SESSION['UserId'] = $row['MemberId'];
        $_SESSION['Username'] = $row['MemberUsername'];
        $_SESSION['SignupDate'] = $row['MemberSignupDate'];
        $_SESSION['MemberActivated']=$row['MemberActivated'];
        header('Location:./LoginSuccess/Admin.php');
      }
    } else {
      HataliKullaniciAdi_Yada_Password_Uyarısı();
    }
  }

  ?>
  <div>
    <form class="Login" action="index.php" method="post">
      <h1>Login</h1>
      <div class="Container-Login">

        <input type="text" required="" name="Username" placeholder="Username">
        <input type="password" required="" name="Password" placeholder="Password">
        <input type="hidden" name="Login" value="1">
        <input type="submit" value="Login">
      </div>
    </form>


    <form class="Signup" action="./afterSignup/afterSignupPage.php" method="post">
      <h1>Sign up</h1>
      <div class="Container-Signup">
        <div class="form-info">
          <input type="text" required="" name="Username" placeholder="Username">
          <input type="password" required="" name="Password" placeholder="Password">
          <input type="email" required="" name="Email" placeholder="Email">
          <input type="hidden" name="Signup" value="1">
          <input type="submit" value="Signup">
        </div>
      </div>
    </form>

  </div>
  </div>


</body>

</html>

<?php
function HataliKullaniciAdi_Yada_Password_Uyarısı()
{ ?>
  <div class="WrongUsernameOrPassword">
    Kullanıcı Adı veya Parola Hatalı!!! </div>
<?php
}
?>