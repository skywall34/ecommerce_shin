<table width = "795" align = "center" bgcolor="skyblue">

  <tr align="center">
    <td colspan="6"><h2>View all Payments Here:</h2></td>
  </tr>

  <tr align="center" bgcolor = "white">
    <th>S.N</th><!--Serial Number?-->
    <th>Customer Email</th>
    <th>Product {S}</th>
    <th>Paid Amount</th>
    <th>Transaction ID</th>
    <th>Order Date</th>
  </tr>

  <?php
    include("db_shin.php");

    $get_payment = "SELECT * FROM paymentsudemy";
    $run_payment = mysqli_query($conn, $get_payment);

    $i = 0;

    while ($row_payment = mysqli_fetch_array($run_payment)) {

      $amount = $row_payment['amount'];
      $trx_id = $row_payment['trx_id'];
      $payment_date = $row_payment['payment_date'];
      $pro_id = $row_payment['product_id'];
      $customer_id = $row_customer['customer_id'];

      $i++;

      $get_pro = "SELECT * FROM productsudemy WHERE product_id='$pro_id'";
      $run_pro = mysqli_query($conn, $get_pro);

      $row_pro = mysqli_fetch_array($run_pro);

      $pro_image = $row_pro['product_image'];
      $pro_title = $row_pro['product_title'];

      $get_customer = "SELECT * FROM customersudmey WHERE customer_id = '$c_id'";
      $run_customer = mysqli_query($conn, $get_customer);

      //only need email
      $row_customer = mysqli_fetch_array($run_customer);

      $customer_email = $row_customer['customer_email'];
   ?>

  <tr align="center">
    <td><?php echo $i; ?></td>
    <td><?php echo $customer_email; ?></td>
    <td>
      <?php echo $pro_title ?>
      <img src="../admin_area/productImages/<?php echo $pro_image;?>" width="60" height="60">
    </td>
    <td><?php echo $amount;?></td>
    <td><?php echo $trx_id; ?></td>
    <td><?php echo $payment_date; ?></td>
  </tr>

<?php } //continues the loop throughout the html ?>

</table>
