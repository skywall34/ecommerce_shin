<?php
include("includesUdemy/dbUdemy.php");
 ?>


<div>
  <form action="" method="post">
    <table width= "500" align="center" bgcolor = "skyblue">

      <tr align ="center">
        <td colspan="3"><h2>Login or Register to Buy!</h2></td>
      </tr>

      <tr>
        <td align="right"><b>Email: </b></td>
        <td><input type="text" name="email" placeholder="Enter Email" style="float:left;" required></td>
      </tr>

      <tr>
        <td align="right"><b>Password:</b></td>
        <td><input type="password" name="pass" value="Enter Password" style="float:left;" required></td>
      </tr>

      <tr align = "center">
        <td colspan="3"><a href="checkout.php?forgot_pass">Forgot Password?</a></td>
      </tr>

      <tr align="center">
        <td colspan="3"><input type="submit" name="login" value="Login"></td>
      </tr>

    </table>

    <h2><a href="customer_register.php" style="text-decoration:none;">New? Register Here</a></h2>
  </form>

  <?php
    if (isset($_POST['login'])) {
      $c_email = $_POST['email'];
      $c_pass = $_POST['pass'];

      $sel_customer = "SELECT * FROM customersudemy WHERE customer_pass = '$c_pass' AND customer_email = '$c_email'";
      $run_customer = mysqli_query($conn, $sel_customer);
      $check_customer = mysqli_num_rows($run_customer);

      if ($check_customer ==0) {
        echo "<script>alert('Password or Email is Incorrect Please Try Again')</script>";
        exit();
      }
      $ip = getIp();

      $sel_cart = "SELECT * FROM cartudemy WHERE ip_add = '$ip'";
      $run_cart = mysqli_query($conn, $sel_cart);

      $check_cart = mysqli_num_rows($run_cart);

      if ($check_customer >0 AND $check_cart ==0) {
        $_SESSION['customer_email'] = $c_email;
        echo "<script>alert('You logged in successfully!')</script>";
        echo "<script>window.open('customerUdemy/my_account.php','_self')</script>";
      }
      else {
        $_SESSION['customer_email'] = $c_email;
        echo "<script>alert('You logged in successfully~')</script>";
        echo "<script>window.open('checkout.php','_self')</script>";
      }
    }

   ?>
</div>
<!-- the include php code puts this code inside where it was referenced-->
