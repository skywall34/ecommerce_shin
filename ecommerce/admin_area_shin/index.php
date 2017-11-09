<?php
session_start();

  if (!isset($_SESSION['user_email'])) {
    echo "<script>window.open('includes/login.php?not_admin=You are not an Admin!', '_self')</script>";
  }
  else {

 ?>

<!DOCTYPE html>
<!--Main html page for the admin panel-->
<html>
  <head>
    <meta charset="utf-8">
    <title>This is the Admin Panel</title>
    <link rel="stylesheet" href="styles/style.css" media="all">
  </head>

  <body>
    <div class="main_wrapper">

      <div id="header">

      </div>

      <div id="left">
        <br><br>
        <h2 style="color:red; text-align:center;"><?php echo @$_GET['logged_in'];?></h2>
        <?php
          if (isset($_GET['view_payments'])) {
            include("includes/view_payments.php");
          }
          if (isset($_GET['view_orders'])) {
            include("includes/view_orders.php");
          }
          if (isset($_GET['insert_product'])) {
            include("includes/insert_product.php");
          }
          if (isset($_GET['view_products'])) {
            include("includes/view_products.php");
          }
          if (isset($_GET['edit_product'])) {
            include("includes/edit_product.php");
          }
          if (isset($_GET['insert_cat'])) {
            include("includes/insert_cat.php");
          }
          if (isset($_GET['view_cats'])) {
            include("includes/view_cats.php");
          }
          if (isset($_GET['edit_cat'])) {
            include("includes/edit_cat.php");
          }
          if (isset($_GET['insert_brand'])) {
            include("includes/insert_brand.php");
          }
          if (isset($_GET['view_brands'])) {
            include("includes/view_brands.php");
          }
          if (isset($_GET['edit_brand'])) {
            include("includes/edit_brand.php");
          }
          if (isset($_GET['view_customers'])) {
            include("includes/view_customers.php");
          }
         ?>
      </div>
      <div id="right">
        <h2 style="text-align: center;"> Manage Content</h2>

        <!--links to different admin pages-->
        <a href="index.php?insert_product">Insert New Product</a>
        <a href="index.php?view_products">View Products</a>
        <a href="index.php?insert_cat">Insert Category</a>
        <a href="index.php?view_cats">View All Categories</a>
        <a href="index.php?insert_brand">Insert New Brand</a>
        <a href="index.php?view_brands">View All Brands</a>
        <a href="index.php?view_customers">View Customers</a>
        <a href="index.php?view_orders">View Orders</a>
        <a href="index.php?view_payments">View Payments</a>
        <a href="includes/logout.php">Admin Logout</a>

      </div>

    </div>
  </body>
</html>

<?php
}
 ?>

 <?php
   include("includes/dbUdemy.php");

   if (isset($_GET['confirm_order'])) {
     $get_id = $_GET['confirm_order'];

     $status = 'Completed';

     $update_order = "UPDATE ordersudemy SET status = '$status' WHERE order_id = '$get_id'";

     $run_update = mysqli_query($conn, $update_order);

     if ($run_update) {
       echo "<script>alert('Order Was Updated!')</script>";
       echo "<script>window.open('index.php?view_orders','_self')</script>";
     }
   }

  ?>
