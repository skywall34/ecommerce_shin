<!DOCTYPE html>
<?php
session_start(); //initialize session
include("functions_shin/functions.php");
include("admin_area_udemy/includes/db_shin.php");
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
          <?php cart(); ?> <!--calls the cart function-->
          <div id="shopping_cart" style="width:800px; height:50px; background:black; color:white;">
              <span style="float:right; font-size:18px; padding:5px; line-height:40px;">

                <?php
                if (isset($_SESSION['customer_email'])) {
                  echo "<b>Welcome:</b>" . $_SESSION['customer_email'] . "<b style='color:yellow;'>Your</b>";
                }
                else {
                  echo "<b>Welcome Guest:</b>";
                }

                 ?>

                <b style="color:yellow;">Shopping Cart - </b><b>Total Items: <?php total_items(); ?> Total Price: <?php total_price(); ?></b>
                <a href="index.php" style="color:yellow;">Back to Shop</a>

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

            <form action="" method="post" enctype="multipart/form-data">

              <table align="center" width="700" bgcolor="skyblue">

                <tr align="center">
                  <th>Remove</th>
                  <th>Products</th>
                  <th>Quantity</th>
                  <th>Total Price</th>
                </tr>

                <?php
                  $total = 0; //initiate local value for result
                  global $conn;
                  $ip = getIp();

                  $sel_price = "SELECT * FROM cartudemy WHERE ip_add = '$ip'";

                  $run_price = mysqli_query($conn, $sel_price);

                  while($p_price=mysqli_fetch_array($run_price)){

              			$pro_id = $p_price['p_id'];
                    //now going to products table and take data using p_id as a reference
                    //using two tables
                    $pro_qty = $p_price['qty'];
              			$pro_price = "SELECT * FROM productsudemy WHERE product_id='$pro_id'";

              			$run_pro_price = mysqli_query($conn,$pro_price);
                    //taking data from products table
                    // this is because there might be more products
              			while ($pp_price = mysqli_fetch_array($run_pro_price)){
                      //getting the price column and taking all prices in one array
                			#$product_price = array($pp_price['product_price']);
                      $product_id = $pp_price['product_id'];
                			$product_title = $pp_price['product_title'];

                			$product_image = $pp_price['product_image'];
                      //this product_price is different it takes the single price
                      //not all the prices in the array
                			$single_price = $pp_price['product_price'];

                      $sub_total_price = $single_price * $pro_qty; #New Add Items

                			$values = array_sum($pp_price);
                      //get sum of values in the array
                      #$values = array_sum($product_price);
                			$total += $values;


                 ?>

                 <tr align="center">
          					<td><br><br><input type="checkbox" name="remove[]" value="<?php echo $pro_id;?>"/>
                      <input type="hidden" name="product_adjust_id[]" value="<?php echo $pro_id;?>">
                    </td>
          					<td><?php echo $product_title; ?><br>
          					<img src="admin_area_udemy/productImages/<?php echo $product_image;?>" width="60" height="60"/>
          					</td>
          					<td><br><input type="text" size="4" name="qty" value="<?php echo $qty;?>"/></td>
          					<?php
                    if(isset($_POST['update_cart'])){

                      $qty = $_POST['qty'];

                      #$pro_id = $_GET['add_cart'];

                      $update_qty = "UPDATE cartudemy SET qty='$qty' WHERE p_id='$pro_id'";

                      $run_qty = mysqli_query($conn, $update_qty);

                      $_SESSION['qty']=$qty;

                      $total = $total*$qty;

                    }

          					?>
                   <td><?php echo "$".$single_price; ?></td>
                 </tr>

                 <!--Ends the while loop-->
               <?php }} ?>

               <tr align="right">
                 <td colspan="4"><b>Sub Total: </b></td>
                 <td colspan="4"><?php echo "$".$total; ?></td>
               </tr>

               <tr align="center">
                 <td colspan="2"><input type="submit" name="update_cart" value="Update Cart"></td>
                 <td><input type="submit" name="continue" value="Continue Shopping"></td>
                 <td><a href="checkout.php" style="text-decoration: none; color: black;"><button>Checkout</a></button></td>
               </tr>

              </table>
              <?php
                #function updateCart()
                  global $conn;
                  $ip = getIp(); //localize ip address variable
                  //function to handle when update_cart is pressed (the submit button Update Cart)
                  if (isset($_POST['remove'])) {
                    if ($_POST['remove'] != "") {
                      foreach($_POST['remove'] as $remove_id){
                        $delete_product = "DELETE FROM cartudemy WHERE p_id = '$remove_id' AND ip_add = '$ip'";
                        $run_delete = mysqli_query($conn, $delete_product);
                        if ($run_delete) {
                          echo "<script>window.open('cart.php', '_self')</script>";
                        }
                      }
                    }
                  } elseif ((isset($_POST['update_cart']) AND empty($_POST['remove']))) {
                    //RUn Pudate All Product with quantity
                    $i = 0;
                    $new_qty = $_POST['qty'];
                    foreach ($_POST['product_adjust_id'] as $pro_adj_id) {
                      $new_qty = $_POST['qty'][$i];
                      $update_prodcut_qty = "UPDATE cartudemy SET qty = '$new_qty' WHERE ip_add = '$ip' AND p_id = '$pro_adj_id'";
                      $run_update = mysqli_query($conn, $update_prodcut_qty);
                      $i++;
                    }
                    echo "<script>window.location.href=window.location.href</script>";
                  }elseif (isset($_POST['continue'])) {
                    echo "<script>window.open('index.php', '_self')</script>";
                  }

                #echo @$up_cart = updateCart();
                //@ means if not working do not generate an error
                //this is to avoid collision with the quantity error

               ?>
            </form>
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
