<?php
session_start();
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="../styles/style_login.css">
  </head>
  <body>
    <div class="login-page">
      <h2 style="color:white; text-align:center;"> <?php echo @$_GET['not_admin']; ?></h2>
      <h2 style="color:white; text-align:center;"> <?php echo @$_GET['logged_out']; ?></h2>
      <div class="form">
        <h1>Admin Login</h1>
        <form class="login-form" method="post" action="login.php">
          <input type="text" placeholder="email" name="email" required/>
          <input type="password" placeholder="password" name="password" required/>
          <button type="submit" name="login">login</button>
        </form>
      </div>
    </div>
  </body>
</html>

<script type="text/javascript">
  $('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
  });
</script>

<?php

include("db_shin.php");

if (isset($_POST['login'])) {
  //prevent malicious code from entering!
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  $sel_user = "SELECT * FROM adminudemy WHERE user_email='$email' AND user_pass = '$password'";
  $run_user = mysqli_query($conn, $sel_user);

  $check_user = mysqli_num_rows($run_user);

  if ($check_user == 1) {
    $_SESSION['user_email']=$email;
    echo "<script>window.open('../index.php?logged_in=You have succesfully logged in!', '_self')</script>";

  }
  else {
    echo "<script>alert('Password or Email is Incorrect!')</script>";
  }
}
 ?>
