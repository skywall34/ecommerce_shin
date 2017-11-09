<table width = "795" align = "center" bgcolor="skyblue">

  <tr align="center">
    <td colspan="6"><h2>View all Orders Here:</h2></td>
  </tr>

  <tr align="center" bgcolor = "white">
    <th>S.N</th><!--Serial Number?-->
    <th>Customer Email</th>
    <th>Product {S}</th>
    <th>Quantity</th>
    <th>Invoice No</th>
    <th>Order Date</th>
    <th>Action</th>
  </tr>

  <?php
    include("db_shin.php");

    $get_order = "SELECT * FROM ordersudemy";
    $run_order = mysqli_query($conn, $get_order);

    $i = 0;

    while ($row_order = mysqli_fetch_array($run_order)) {
      $order_id = $row_order['order_id'];
      $qty = $row_order['qty']
      $pro_id = $row_order['p_id'];
      $c_id = $row_order['c_id'];
      $invoice_no = $row_order['invoice_no'];
      $roder_date = $row_order['order_date'];

      $i++; //increment for as many products there are (increments the id)

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
    <td><?php echo $qty;?></td>
    <td><?php echo $invoice_no; ?></td>
    <td><?php echo $order_date; ?></td>
    <td><a href="../index.php?confirm_order=<?php echo $order_id;?>"></a>Complete Order</td>
  </tr>

<?php } //continues the loop throughout the html ?>

</table>
