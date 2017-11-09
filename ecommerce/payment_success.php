<!DOCTYPE html>
<?php
session_start();
 ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Payment Successful!!</title>
  </head>
  <body>
    <?php
   include("includesUdemy/db_shin.php");
   include("functions_shin/functions.php");

   //this is all for product details

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
        $product_id = $pp_price['product_id'];
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
      $total = $total * $qty;
    }

   //this is about the customer
    $user = $_SESSION['customer_email'];
    $get_c = "SELECT * FROM customersudemy WHERE customer_email = '$user'";

    $run_c = mysqli_query($conn, $get_c);

    $row_c = mysqli_fetch_array($run_c);

    $c_id = $row_c['customer_id'];

    //payment details from paypal

    $amount = $_GET['amount'];
    $currency = $_GET['cc'];
    $trx_id = $_GET['tx'];

    //generates random number
    $invoice = mt_rand();

    //inserting the payments to table
    $insert_payments = "INSERT INTO paymentsudemy (amount, customer_id, product_id, trx_id, currency, payment_date)
    VALUES ('$amount','$c_id','$pro_id','$trx_id','$currency',NOW())";

    $run_payments = mysqli_query($conn, $insert_payments);

    //inserting the order to table
    $insert_order = "INSERT INTO ordersudemy (p_id, c_id, qty, invoice_no, order_date, status) VALUES ('$pro_id','$c_id','$qty','$invoice',NOW(), 'in Progress')";
    $run_order = mysqli_query($conn, $insert_order);

    //removing the objects from the cart
    $empty_cart = "DELETE * FROM cartudemy";
    $run_cart = mysqli_query($conn, $empty_cart);



    if ($amount == $total) {
      echo "<h2>Welcome:". $_SESSION['customer_email'] ."<br>". "Your payment was successful</h2>";
      echo "<a href = 'http://www.onlinetuting.com/myshop/customerUdemy/my_account.php'>Go to Your Account</a>";
    }
    else {
      echo "<h2>Welcome Guest, Payment was made</h2><br>";
      echo "<a href = 'http://www.onlinetuting.com/myshop'>Go back to Shop</a>";
    }

     ?>
  </body>
</html>
