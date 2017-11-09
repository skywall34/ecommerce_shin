<!DOCTYPE html>
<?php
session_start();
include("functionsUdemy/functions.php");
 ?>
<html>
  <head>
    <title>My Online Shop</title>

    <link rel="stylesheet" href="/stylesUdemy/style.css" media="all">
  </head>

<body>

  <!--Main Container starts here-->
  <div class="main_wrapper">
      <!--HEader starts here-->
      <div class="header_wrapper">
        <a href="index.php"><img id="logo" src="imagesUdemy/logo.png"></a>
        <img id="banner" src="imagesUdemy/bitnami.png">

      </div>
      <!--HEader ends here-->

      <!--Navigation bar starts-->
      <div class="menubar">
          <ul id="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="all_products.php">All Products</a></li>
            <li><a href="customerUdemy/my_account.php">My Account</a></li>
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
              <span style="float:right; font-size:17px; padding:5px; line-height:40px;">
                <?php
                if (isset($_SESSION['customer_email'])) {
                  echo "<b>Welcome:</b>" . $_SESSION['customer_email'] . "<b style='color:yellow;'>Your</b>";
                }
                else {
                  echo "<b>Welcome Guest:</b>";
                }

                 ?>

                <b style="color:yellow;">Shopping Cart - </b><b>Total Items: <?php total_items(); ?> Total Price: <?php total_price(); ?></b>
                <a href="cart.php" style="color:yellow;">Go to Cart</a>

                <?php
                //Login and Logout framework
                if (!isset($_SESSION['customer_email'])) {
                  echo "<a href='checkout.php' style='color:orange'>Login</a>";
                }
                else {
                  echo "<a href='logout.php' style='color: orange'>Logout</a>";
                }


                 ?>

              </span>
          </div>

          <!--try getIp() with echo here if you need to test the function-->

          <div id="products_box">
            <?php getPro();?> <!--if category not selected this runs-->
            <?php getCatPro(); ?> <!--if category was clicked this will run-->
            <?php getBrandPro(); ?><!--if brands were clicked this will run-->
          </div>

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
