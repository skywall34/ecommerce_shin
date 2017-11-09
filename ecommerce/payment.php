<div>
<?php
include("includes_shin/db_shin.php");
$total = 0; //initiate local value for result
global $conn;
$ip = getIp();

$sel_price = "SELECT * FROM cartudemy WHERE ip_add = '$ip'";

$run_price = mysqli_query($conn, $sel_price);

//fetch data from the table
while ($p_price = mysqli_fetch_array($run_price)) {
  //getting the id from the table
  $pro_id = $p_price['p_id'];
  //now going to products table and take data using p_id as a reference
  //using two tables
  $pro_price = "SELECT * FROM productsudemy WHERE product_id = '$pro_id'";
  $run_pro_price = mysqli_query($conn, $pro_price);
  //taking data from products table
  // this is because there might be more products
  while ($pp_price = mysqli_fetch_array($run_pro_price)) {
    //getting the price column and taking all prices in one array
    $product_price = array($pp_price['product_price']);
    $product_name = $pp_price['product_title'];
    //get sum of values in the array
    $values = array_sum($product_price);

    $total += $values;
  }
}

  //getting quantity of the product
  $get_qty = "SELECT * FROM cartudemy WHERE p_id = '$pro_id'";
  $run_qty = mysqli_query($conn, $get_qty);

  $row_qty = mysqli_fetch_array($run_qty);

  $qty = $row_qty['qty'];

  if ($qty == 0) {
    //error handling
    $qty = 1;
  }
  else {
    $qty = $qty;

  }

 ?>



<h2 align="center" style="padding:2px;">Pay now with Paypal!</h2>
<!--action is the site source (the testing site)-->
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

  <!-- Identify your business so that you can collect the payments. -->
  <!--The email should be the account where I am getting money from-->
  <input type="hidden" name="business" value="doshinkorean@gmail.com">

  <!-- Specify a Buy Now button. -->
  <input type="hidden" name="cmd" value="_xclick">

  <!-- Specify details about the item that buyers will purchase. -->
  <!--Values will equal the data from the cart page-->
  <input type="hidden" name="item_name" value="<?php echo $product_name;?>">
  <input type="hidden" name="item_number" value="<?php echo $pro_id;?>">
  <input type="hidden" name="amount" value="<?php echo $total;?>">
  <input type="hidden" name="quantity" value="<?php echo $qty;?>">
  <!--The value can be changed to match the currency-->
  <input type="hidden" name="currency_code" value="USD">
  <!--These files will be created at a later tutorial not during paypal-->
  <input type="hidden" name="return" value="http://www.onlinetuting.com/myshop/paypal_success.php">
  <input type="hidden" name="cancel_return" value="http://www.onlinetuting.com/myshop/paypal_cancel.php">

  <!-- Display the payment button. -->
  <input type="image" name="submit" border="0"
  src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_buynow_107x26.png"
  alt="Buy Now" width="250" height="100">
  <img alt="" border="40" width="1" height="1"
  src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

</form>

</div>
