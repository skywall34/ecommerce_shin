<!DOCTYPE html>
<?php
session_start(); //anything that uses $_SESSION needs this included
include("functions_shin/functions.php");
include("includes_shin/db_shin.php");
 ?>
<html>
  <head>
    <title>My Online Shop</title>

    <link rel="stylesheet" href="/styles_shin/style.css" media="all">
  </head>

<body>

  <!--Main Container starts here-->
  <div class="main_wrapper">
      <!--HEader starts here-->
      <div class="header_wrapper">
        <a href="index.php"><img id="logo" src="images_shin/logo.png"></a>
        <img id="banner" src="images_shin/bitnami.png">

      </div>
      <!--HEader ends here-->

      <!--Navigation bar starts-->
      <div class="menubar">
          <ul id="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="all_products.php">All Products</a></li>
            <li><a href="customer/my_account.php">My Account</a></li>
            <li><a href="checkout.php">Sign Up</a></li>
            <li><a href="cart.php">Shopping Cart</a></li>
            <li><a href="#">Contact Us</a></li>
          </ul>

          <div id="form">
            <form action="results.php" method="get" enctype="multipart/form-data">
              <input type="text" name="user_query"placeholder="Search a Product">
              <input type="submit" name="search" value="Search">
            </form>
          </div>
      </div>
      <!--Navigation ends-->

      <!--Content wrapper starts-->
      <div class="content_wrapper">

        <div id="sidebar">
          <div id="sidebar_title">
            Categories
          </div>

          <ul id="cats">
            <!--coming from the functions.php funciton-->
            <?php getCats();?>
          </ul>

          <div id="sidebar_title">
            Brands
          </div>

          <ul id="cats">
            <?php getBrands(); ?>
          </ul>

        </div>

        <div id="content_area">
          <?php cart(); ?> <!--calls the cart function-->
          <div id="shopping_cart" style="width:800px; height:50px; background:black; color:white;">
              <span style="float:right; font-size:18px; padding:5px; line-height:40px;">

                Welcome Guest! <b style="color:yellow;">Shopping Cart - </b><b>Total Items: <?php total_items(); ?> Total Price: <?php total_price(); ?></b>
                <a href="cart.php" style="color:yellow;">Go to Cart</a>

              </span>
          </div>
          <!--action is where the user should go when clicking this button-->
          <form action="customer_register.php" method="post" enctype="multipart/form-data">
            <table align = "center" width="750">

              <tr align="center">
                <td colspan="6"><h2>Create an Account</h2></td>
              </tr>

              <tr>
                <td align="right">Customer Name:</td>
                <td><input type="text" name="c_name" required></td>
              </tr>

              <tr>
                <td align="right">Customer Email:</td>
                <td><input type="text" name="c_email" required></td>
              </tr>

              <tr>
                <td align="right">Customer Password:</td>
                <td><input type="password" name="c_pass" required></td>
              </tr>

              <tr>
                <td align="right">Customer Country:</td>
                <td><select class="" name="c_country" required>
                  <option>Select a country</option>
                  <option>Afghanistan</option>
                  <option>India</option>
                  <option>South Korea</option>
                  <option>Japan</option>
                  <option>United States</option>
                  <option>Canada</option>
                  <option>Mexico</option>
                  <option>United Kingdom</option>

                </select></td>

              </tr>

              <tr>
                <td align="right">Customer City:</td>
                <td><input type="text" name="c_city" required></td>
              </tr>

              <tr>
                <td align="right">Customer Contact:</td>
                <td><input type="text" name="c_contact" required></td>
              </tr>

              <tr>
                <td align="right">Custormer Address:</td>
                <td><input type="text" name="c_address" required></td>
              </tr>

              <tr>
                <td align="right">Customer Image:</td>
                <td><input type="file" name="c_image" required></td>
              </tr>

              <tr align="center">
                <td colspan="6"><input type="submit" name="register" value="Create Account"></td>
              </tr>

            </table>
          </form>

        </div>

      </div>
      <!--Content wrapper ends-->

      <div id="footer">
        <h2 style="text-align:center; padding-top:30px;">&copy; 2017 by www.shintutorials.com </h2>

      </div>

  </div>
  <!--Main Container ends here-->
</body>

</html>

<?php
  if (isset($_POST['register'])) {
    $ip = getIp();

    $c_name = $_POST['c_name'];
    $c_email = $_POST['c_email'];
    $c_pass = $_POST['c_pass'];
    $c_image = $_FILES['c_image']['name'];
    //get image data
    $c_image_tmp = $_FILES['c_image']['tmp_name'];
    $c_country = $_POST['c_country'];
    $c_city = $_POST['c_city'];
    $c_contact = $_POST['c_contact'];
    $c_address = $_POST['c_address'];

    //uploades the data of the image and names it as the inputed name c_image
    move_uploaded_file($c_image_tmp, "customerUdemy/customer_images/$c_image");

    $insert_c = "INSERT INTO customersudemy(customer_ip, customer_name, customer_email, customer_pass, customer_country, customer_city, customer_contact, customer_address, customer_image)
    VALUES('$ip','$c_name','$c_email','$c_pass','$c_country','$c_city','$c_contact','$c_address','$c_image')";

    $run_c = mysqli_query($conn, $insert_c);

    $sel_cart = "SELECT * FROM cartudemy WHERE ip_add = '$ip'";
    $run_cart = mysqli_query($conn, $sel_cart);

    $check_cart = mysqli_num_rows($run_cart);

    //need to recreate this so that it handles overlaps
    if ($check_cart==0) {
      $_SESSION['customer_email'] = $c_email;
      echo "<script>alert('Registration Successful! Account has been created thanks!')</script>";
      echo "<script>window.open('customerUdemy/my_account.php','_self')</script>";
    }
    else {
      $_SESSION['customer_email'] = $c_email;
      echo "<script>alert('Account Created')</script>";
      echo "<script>window.open('checkout.php','_self')</script>";
    }
  }
 ?>
