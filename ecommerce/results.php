<!DOCTYPE html>
<?php
include("functions_shin/functions.php");
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
        <a href="index.php"><img id="logo" src="imagesUdemy/logo.png"></a>
        <img id="banner" src="imagesUdemy/bitnami.png">

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

                <b style="color:yellow;">Shopping Cart - <b>Total Items: Total Price:</b></b>
                <a href="cart.php" style="color:yellow;">Go to Cart</a>



              </span>
          </div>

          <div id="products_box">
          <?php
            if (isset($_GET['search'])) {

              $search_query = $_GET['user_query'];

              //shows all the products that match the search query
              $get_pro = "SELECT * FROM productsudemy WHERE product_keywords LIKE '%$search_query%'";

              //run the get_pro mysql query command through connect conn value
              $run_pro = mysqli_query($conn, $get_pro);

              while ($row_pro = mysqli_fetch_array($run_pro)) {
                //row_pro is the array format of run_pro
                $pro_id = $row_pro['product_id'];
                $pro_cat = $row_pro['product_cat'];
                $pro_brand = $row_pro['product_brand'];
                $pro_title = $row_pro['product_title'];
                $pro_price = $row_pro['product_price'];
                $pro_image = $row_pro['product_image'];

                //careful only use single quotations inside the double quotations
                echo "
                  <div id= 'single_product'>
                    <h3>$pro_title</h3>
                    <img src='admin_area_udemy/productImages/$pro_image' width = '180' height = '180' />
                    <p><b> $ $pro_price</b></p>
                    <a href='details.php?pro_id=$pro_id' style='float:left;'>Details</a>
                    <a href = 'index.php?pro_id=$pro_id'><button style='float:right;'>Add to Cart</button></a>
                  </div>
                  ";
              }
            }
           ?>
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
